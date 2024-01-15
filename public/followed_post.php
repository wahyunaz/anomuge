<?php

$inp = file_get_contents('php://input');
$input = json_decode($inp, true);

if (isset($input['token']) && isset($input['start_index'])) {
    $token = $input['token'];
    $startIndex = intval($input['start_index']);

    $j_users = file_get_contents('databases/users.json');
    $users = json_decode($j_users, true);

    $f_id = null;
    foreach ($users as $user) {
        if (isset($user['token']) && $user['token'] === $token) {
            $f_id = $user['id'];
            break;
        }
    }

    $reslt = [];
    if ($f_id) {
        foreach ($users as $user) {
            if (isset($user['followers']) && is_array($user['followers']) && in_array($f_id, $user['followers'])) {
                $reslt[] = $user['id'];
            }
        }
    }


    $j_messages = file_get_contents('databases/messages.json');
    $messages = json_decode($j_messages, true);

    $total_reply = [];

    foreach ($messages as $message) {
        if (isset($message['type']) && $message['type'] === 'reply' && isset($message['replyto'])) {
            $replyto = $message['replyto'];
            if (!isset($total_reply[$replyto])) {
                $total_reply[$replyto] = 1;
            } else {
                $total_reply[$replyto]++;
            }
        }
    }

    $filtered_msgs = array_filter($messages, function ($message) use ($f_id, $reslt) {
        return isset($message['type'], $message['access'], $message['sender_id']) &&
            $message['type'] === 'caption' &&
            $message['access'] === 'public' &&
            ($message['sender_id'] === $f_id || (is_array($reslt) && in_array($message['sender_id'], $reslt)));
    });

    usort($filtered_msgs, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    $msg = array_slice($filtered_msgs, $startIndex, 22);

    $indexComplete = min($startIndex + count($msg), count($filtered_msgs));

    foreach ($msg as &$message) {
        $userIndex = array_search($message['sender_id'], array_column($users, 'id'));
        $userData = $users[$userIndex];

        $message['username'] = isset($userData['username']) ? $userData['username'] : '';
        $message['name'] = isset($userData['name']) ? $userData['name'] : '';
        $message['verification'] = isset($userData['verification']) ? $userData['verification'] : '';
        $message['os'] = isset($userData['os']) ? $userData['os'] : '';
        $message['profile_picture'] = isset($userData['profile_picture']) ? $userData['profile_picture'] : '';
        $message['cover_photo'] = isset($userData['cover_photo']) ? $userData['cover_photo'] : '';

        if (isset($message['id']) && isset($total_reply[$message['id']])) {
            $message['total_reply'] = $total_reply[$message['id']];
        } else {
            $message['total_reply'] = 0;
        }

        $message['timestamp'] = isset($message['date']) ? strtotime($message['date']) : 0;
    }

    $other_people = array_filter($users, function ($user) use ($f_id) {
        return isset($user['followers']) && is_array($user['followers']) && !in_array($f_id, $user['followers']);
    });

    $follow_other_people = array_map(function ($user) {
        return [
            'id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'verification' => $user['verification'],
            'os' => $user['os'],
            'profile_picture' => $user['profile_picture'],
            'cover_photo' => $user['cover_photo'],
            'bio' => $user['bio'],
        ];
    }, $other_people);

    $follow_other_people = array_filter($follow_other_people, function ($user) use ($f_id) {
        return $user['id'] !== $f_id;
    });

    shuffle($follow_other_people);
  

    // output
    $output = json_encode([
        'status' => array_values($msg),
        'index_complete' => $indexComplete,
        'status_length' => count($filtered_msgs),
        'follow_other_people' => array_values(array_slice($follow_other_people, 0, 2)),
        'follow' => array_values(array_slice($follow_other_people, 0, 12))
    ]);

 
    $res = ob_get_clean();

    $res = gzencode($output, 9, FORCE_GZIP);
 
    header('Content-Encoding: gzip');
    header('Content-Length: ' . strlen($res));

    echo $res;
} else {
    // token atau star_index kosong
    echo json_encode(['error' => 'isi data']);
}
?>

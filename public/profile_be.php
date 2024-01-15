<?php

$all_user_data = file_get_contents('databases/users.json');
$users = json_decode($all_user_data, true);

$all_message_data = file_get_contents('databases/messages.json');
$messages = json_decode($all_message_data, true);

function chrt($char, $key) {
    if (preg_match('/[a-zA-Z]/', $char)) {
        $base = preg_match('/[A-Z]/', $char) ? 65 : 97;
        return chr((ord($char) - $base + $key + 26) % 26 + $base);
    } else {
        return $char;
    }
}

function ttb($text) {
    return base64_encode($text);
}

function btt($base64) {
    return base64_decode($base64);
}

function encrypt($text, $key) {
    $resl = array_map(function ($char) use ($key) {
        return chrt($char, $key);
    }, str_split($text));

    return ttb(implode('', $resl));
}

function decrypt($text, $key) {
    $resl = array_map(function ($char) use ($key) {
        return chrt($char, (26 - $key) % 26);
    }, str_split(btt($text)));

    return implode('', $resl);
}

$start_index = 0;

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $user_found = null;
    foreach ($users as $user) {
        if (isset($user['username']) && strtolower(decrypt($user['username'], 71)) === strtolower(decrypt($username, 71))) {
            $user_found = $user;
            break;
        }
    }

    if ($user_found) {
        $status_found = array_filter($messages, function ($message) use ($user_found) {
            return isset($message['sender_id']) && $message['sender_id'] === $user_found['id'] && isset($message['type']) && $message['type'] === 'caption';
        });

        usort($status_found, function ($a, $b) {
            if (isset($a['timestamp'], $b['timestamp'])) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            } else {
                return 0;
            }
        });

        $all_status = array_reverse(array_values($status_found));
        $status_found = array_slice($all_status, $start_index, 12);

        $last_index = $start_index + count($status_found) - 1;

        $res = [
            'success' => true,
            'user' => [
                'id' => $user_found['id'],
                'username' => $user_found['username'],
                'name' => $user_found['name'],
                'profile_picture' => $user_found['profile_picture'],
                'bio' => $user_found['bio'],
                'verification' => $user_found['verification'],
                'verification_reason' => $user_found['verification_reason'],
                'cover_photo' => $user_found['cover_photo'],
                'created' => $user_found['created'],
                'os' => $user_found['os'],
                'userAgent' => $user_found['userAgent'],
            ],
            // 'status' => $status_found,
            // 'last_index' => $last_index,
            // 'all' => count($all_status) +1,
        ];

        $results = gzencode(json_encode($res), 9);

        header('Content-Encoding: gzip');
        header('Content-Type: application/json');
        echo $results;
    } else {
        http_response_code(404);
        $res = [
            'success' => false,
            'message' => 'User tidak ditemukan',
        ];

        header('Content-Type: application/json');
        echo json_encode($res);
    }
} else {
    http_response_code(400);
    $res = [
        'success' => false,
        'message' => 'Tidak ada data post',
    ];

    header('Content-Type: application/json');
    echo json_encode($res);
}

?>

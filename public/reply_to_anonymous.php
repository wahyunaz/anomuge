<?php

// baca file json
function read_data($file)
{
    $dat = file_get_contents($file);
    return json_decode($dat, true);
}

function write_data($file, $data)
{
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Cari data pengguna dengan id tertentu
function get_user_data($users, $id)
{
    foreach ($users as $user) {
        if (isset($user['id']) && $user['id'] == $id) {
            // Hanya ambil data yang dibutuhkan
            return array(
                'id' => $user['id'],
                'profile_picture' => $user['profile_picture'],
                'username' => $user['username'],
                'verification' => $user['verification'],
                'name' => $user['name'],
                'os' => $user['os'],
            );
        }
    }

    return null; // jika tidak ditemukan
}

// data dari POST
$data = json_decode(file_get_contents('php://input'), true);

$id_data = isset($data['id']) ? $data['id'] : null;
$anonymous_user = isset($data['anonymous_user']) ? $data['anonymous_user'] : null;

if ($id_data !== null && $anonymous_user !== null) {
    $messages = read_data('databases/messages.json');
    $users = read_data('databases/users.json');

    // data pesan
    function get_message_data(&$messages, $id, $send_to_anonymous_user)
    {
        foreach ($messages as &$message) {
            if (
                isset($message['id'], $message['send_to_anonymous_user'])
                && $message['id'] == $id
                && $message['send_to_anonymous_user'] == $send_to_anonymous_user
            ) {
                // ubah read menjadi true
                if (!$message['read']) {
                    $message['read'] = true;
                }
                    return $message;
                
            }
        }
        return null; //jika tidak ditemukan
    }

    // data pesan
    $message_data = get_message_data($messages, $id_data, $anonymous_user);

    if ($message_data) {
        // data pengguna
        $user_data = get_user_data($users, $message_data['sender_id']);

        if ($user_data) {
            // Gabungkan data pesan dan data pengguna
            $result_data = array_merge($message_data, array('profile' => $user_data));

        
            write_data('databases/messages.json', $messages);

            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'data' => $result_data), JSON_PRETTY_PRINT);
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'pengguna tidak ditemukan'), JSON_PRETTY_PRINT);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'pesan tidak ditemukan'), JSON_PRETTY_PRINT);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'message' => 'Isi data'), JSON_PRETTY_PRINT);
}
?>

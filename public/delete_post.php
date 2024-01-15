<?php

function read($filename)
{
    $json_data = file_get_contents($filename);
    return json_decode($json_data, true);
}

function write($filename, $data)
{
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json_data);
}

// data dari php://input
$input_data = json_decode(file_get_contents("php://input"), true);

// token dan post_id dari input
$token = $input_data['token'];
$post_id = $input_data['post_id'];

// users.json
$users_data = read('./databases/users.json');
$user_id = null;
foreach ($users_data as $user) {
    if ($user['token'] == $token) {
        $user_id = $user['id'];
        break;
    }
}


if ($user_id !== null) {

    $messages_data = read('./databases/messages.json');
    foreach ($messages_data as $key => $message) {
        if ($message['id'] == $post_id) {
            if ($message['sender_id'] == $user_id) {
                unset($messages_data[$key]);
                $messages_data = array_values($messages_data);
                write('./databases/messages.json', $messages_data);
                echo "Pesan berhasil dihapus.";
            } else {
                echo "tidak ada izin";
            }
            break;
        }
    }
} else {
    echo "Token tidak valid.";
}

?>

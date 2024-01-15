<?php

// buat id acak
function create_id() {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 15);
}

// data dari frontend
$sender_token = urldecode($_POST['token']);
$caption = substr($_POST['caption'],0,2000);
$access = $_POST['access'];

// os
function os() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    return strpos($userAgent, 'Windows') !== false ? "Windows" : (
        strpos($userAgent, 'Mac') !== false ? "MacOS" : (
            strpos($userAgent, 'Linux') !== false ? "Linux" : (
                strpos($userAgent, 'Android') !== false ? "Android" : (
                    strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false || strpos($userAgent, 'iPod') !== false ? "iOS" : "Unknown"
                )
            )
        )
    );
}

// cari data user dari token
$users_data = json_decode(file_get_contents('databases/users.json'), true);

$sender_id = null;
$sender_name = null;

foreach ($users_data as $user) {
    if ($user['token'] === $sender_token) {
        $sender_id = $user['id'];
        $sender_name = $user['username'];
        break;
    }
}

if ($sender_id === null || $sender_name === null) {
    // Jika token tidak ditemukan
    $response = array('success' => false, 'message' => 'User not found');
    echo json_encode($response);
    exit;
}

// array data untuk posting
$post_data = array(
    'id' => create_id(),
    'sender_id' => $sender_id,
    'sender_name' => $sender_name,
    'caption' => $caption,
    'date' => gmdate('Y-m-d\TH:i:s\Z'),
    'access' => $access,
    'type' => 'caption',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
    'os' => os()
);

// data dari databases
$previous_data = json_decode(file_get_contents('databases/messages.json'), true);

// cek id belum digunakan
$still_new = false;
while (!$still_new) {
    $already_used = false;
    foreach ($previous_data as $existingMessage) {
        if ($existingMessage['id'] === $post_data['id']) {
            $already_used = true;
            break;
        }
    }

    if (!$already_used) {
        $still_new = true;
    } else {
        // Jika id sudah digunakan buat id baru
        $post_data['id'] = create_id();
    }
}

// simpan data baru ke array
$previous_data[] = $post_data;

// simpan ke databases
if (file_put_contents('databases/messages.json', json_encode($previous_data)) === false) {
    $response = array('success' => false, 'message' => 'Error');
    echo json_encode($response);
} else {
    $response = array('success' => true, 'id' => $post_data['id'], 'message' => 'success');
    echo json_encode($response);
}

?>

<?php

function read($file)
{
    $json = file_get_contents($file);
    return json_decode($json, true);
}

function write($file, $data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($file, $json);
}

function update($file, $token, $new_username, $new_bio)
{
    $users = read($file);
    $success = false;

    foreach ($users as &$user) {
        if ($user['token'] == $token) {
            $user['username'] = $new_username;
            $user['bio'] = substr($new_bio,0,200);
            $success = true;
            break;
        }
    }

    if ($success) {
        write($file, $users);
    }

    return $success;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $file = 'databases/users.json';
    $token = isset($data['token']) ? $data['token'] : '';
    $new_username = isset($data['username']) ? $data['username'] : '';
    $new_bio = isset($data['bio']) ? $data['bio'] : '';

    if (!empty($token) && !empty($new_username) && !empty($new_bio)) {
        $success = update($file, $token, $new_username, $new_bio);
        $results = ['success' => $success];
        echo json_encode($results);
    } else {
        $results = ['success' => false, 'message' => 'Masukkan data'];
        echo json_encode($results);
    }
} else {
    $results = ['success' => false, 'message' => 'Tidak benar'];
    echo json_encode($results);
}

?>

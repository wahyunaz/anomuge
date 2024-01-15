<?php

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


// data post
$token = $_POST['token'];
$username = $_POST['username'];

// Baca data dari file users.json
$usersData = file_get_contents('./databases/users.json');
$users = json_decode($usersData, true);

// cari id melalui token
$userId = null;
foreach ($users as $user) {
    if ($user['token'] === $token) {
        $userId = $user['id'];
        break;
    }
}

// jika ID melalui token ditemukan
if ($userId !== null) {
    // cari user
    $userFound = null;
    foreach ($users as $user) {
        if (strtolower(decrypt($user['username'],71)) === strtolower($username)) {
            $userFound = $user;
            break;
        }
    }

    if ($userFound !== null) {
        $followers = $userFound['followers'];
        if (in_array($userId, $followers)) {
            echo json_encode(['success' => true, 'have_followed' => true]);
        } else {
            echo json_encode(['success' => true, 'have_followed' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid token']);
}

?>

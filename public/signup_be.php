<?php
// Mulai sesi
session_start();

// Data dari parameter post
$username = urldecode($_POST['username']) ?? '';
$password = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';
$name = $_POST['name'] ?? '';
$bio = $_POST['bio'] ?? '';
$number = $_POST['number'] ?? '';

$res = [
    'success' => false,
    'token' => '',
    'message' => '',
    'id' => '',
];

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

// os
function os() { 
    return strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== false ? "Windows" : (strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false ? "MacOS" : (strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== false ? "Linux" : (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false ? "Android" : (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== false ? "iOS" : "Unknown")))); 
}

// Cek value
if (empty($username) || empty($password)) {
    $res['message'] = "Isi semua data dengan benar.";
    echo json_encode($res);
    exit;
}

// Data dari file user.json
$user_data = file_get_contents('databases/users.json');
$all_user = json_decode($user_data, true);

// Cek username
if (checkUsername($username, $all_user)) {
    $res['message'] = "already";
    echo json_encode($res);
    exit;
}

// data untuk signup
$signup_data = [
    'id' => createId($all_user),
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'email' => $email,
    'name' => $name,
    'bio' => $bio,
    'followers' => [],
    'number' => $number,
    'verification' => false,
    'token' => token(), // autentikasi
    'verification_reason' => "",
    'userAgent' => $_SERVER['HTTP_USER_AGENT'],
    'profile_picture' => '',
    'cover_photo' => '',
    'anonymous_id' => "",
    'pseudonym' => "",
    'os' => os(),
    'created' => date('Y-m-d H:i:s'),
];

// Tambah data baru ke array
$all_user[] = $signup_data;

// simpan ke users.json
file_put_contents('databases/users.json', json_encode($all_user, JSON_PRETTY_PRINT));

// response success
$res['success'] = true;
$res['token'] = $signup_data["token"];
$res['id'] = $signup_data["id"];

// kirim ke frontend
echo json_encode($res);

// Cek username
function checkUsername($username, $all_user) {
    foreach ($all_user as $user) {
        if (strtolower(decrypt($user['username'],71)) === strtolower(decrypt($username,71))) {
            return true;
        }
    }
    return false;
}

// Create new id 
function createId($all_user) {
    $id = token(); // ini adalah id bukan token, hanya saja untuk membuat karakter acak
    while (checkId($id, $all_user)) {
        $id = token(); // ini adalah id bukan token
    }
    return $id;
}

// Cek id
function checkId($id, $all_user) {
    foreach ($all_user as $user) {
        if ($user['id'] === $id) {
            return true;
        }
    }
    return false;
}

// buat token
function token($length = 25) {
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $random_results = '';
    for ($i = 0; $i < $length; $i++) {
        $random_results .= $char[rand(0, strlen($char) - 1)];
    }
    return $random_results;
}
?>

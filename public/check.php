<?php
function check($token, $newt) {
    $data = file_get_contents('databases/users.json');
    $users = json_decode($data, true);

    foreach ($users as &$user_data) {
        if ($user_data['token'] == urldecode($token)) {
            if ($newt == 1) {
                // Jika newt = 1, buat token baru
                do {
                    $new_token = token_();
                } while (token_exists($new_token, $users));

                $user_data['token'] = $new_token;

                // Simpan ke file JSON
                file_put_contents('databases/users.json', json_encode($users, JSON_PRETTY_PRINT));

                return [
                    'success' => true,
                    'token' => $new_token,
                    'message' => 'success',
                    'id' => $user_data['id'],
                    'username' => $user_data['username'],
                    'bio' => $user_data['bio'],
                    'anonymous_id' => $user_data['anonymous_id'] ?? '',
                    'pseudonym' => $user_data['pseudonym'] ?? '',
                ];
            } else {
                // Jika newt = 0, tidak ubah tokennya
                return [
                    'success' => true,
                    'token' => $user_data['token'],
                    'message' => 'success',
                    'id' => $user_data['id'],
                    'username' => $user_data['username'],
                    'bio' => $user_data['bio'],
                    'anonymous_id' => $user_data['anonymous_id'] ?? '',
                    'pseudonym' => $user_data['pseudonym'] ?? '',
                ];
            }
        }
    }

    return [
        'success' => false,
        'message' => 'token salah',
    ];
}

// Dari frontend
$token = isset($_POST['token']) ? $_POST['token'] : '';
$newt = isset($_POST['newt']) ? intval($_POST['newt']) : 0;

// Cek
$output = check($token, $newt);

// kompresi gzip
ob_start();
header("Content-Encoding: gzip");
echo gzencode(json_encode($output, JSON_PRETTY_PRINT), 9); // Angka 9 adalah tingkat kompresi (0 hingga 9)

// berhenti
ob_end_flush();

// buat token
function token_($length = 25) {
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomResults = '';
    for ($i = 0; $i < $length; $i++) {
        $randomResults .= $char[rand(0, strlen($char) - 1)];
    }
    return $randomResults;
}

// apakah sudah digunakan
function token_exists($token, $users) {
    foreach ($users as $user_data) {
        if ($user_data['token'] == $token) {
            return true;
        }
    }
    return false;
}
?>

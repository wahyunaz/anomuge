<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dari frontend
    $username = isset($_POST['username']) ? urldecode($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Cek
    $output = check($username, $password);

    echo json_encode($output);
} else {
    echo json_encode([
        'success' => false,
        'id' => '',
        'message' => 'Permintaan tidak benar',
    ]);
}

function check($username, $password) {
    $data = file_get_contents('databases/users.json');
    $users = json_decode($data, true);

    if ($users === null && json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'id' => '',
            'message' => 'Error',
        ];
    }

    foreach ($users as &$user_data) {
        if ($user_data['username'] == $username) {
            // Cek password
            if (password_verify($password, $user_data['password'])) {
                // Buat token baru yang belum pernah digunakan
                do {
                    $new_token = token_();
                } while (token_exists($new_token, $users));

                // Simpan token baru
                $user_data['token'] = $new_token;

                // Simpan
                file_put_contents('databases/users.json', json_encode($users, JSON_PRETTY_PRINT));

                return [
                    'success' => true,
                    'token' => $new_token,
                    'id' => $user_data['id'],
                    'message' => 'success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Password salah",
                ];
            }
        }
    }

    return [
        'success' => false,
        'message' => 'Akun tidak ada',
    ];
}

// buat token
function token_($length = 25) {
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomResults = '';
    for ($i = 0; $i < $length; $i++) {
        $randomResults .= $char[rand(0, strlen($char) - 1)];
    }
    return $randomResults;
}

// cek apakah sudah digunakan
function token_exists($token, $users) {
    foreach ($users as $user_data) {
        if ($user_data['token'] == $token) {
            return true;
        }
    }
    return false;
}

?>

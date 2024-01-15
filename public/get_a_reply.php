<?php

// id postingan / balasan
$post_id = $_POST['id'];
// token user
$token = $_POST['token'];

// baca data pengguna
$users_file = 'databases/users.json';
$users_data = file_get_contents($users_file);
$users = json_decode($users_data, true);

// cari pengguna
$user_found = false;
$user_data = null;

foreach ($users as $user) {
    if ($user['token'] === $token) {
        $user_data = $user;
        $user_found = true;
        break;
    }
}

// jika pengguna ditemukan
if ($user_found) {
    // ambil data pesan
    $messages_file = 'databases/messages.json';
    $messages_data = file_get_contents($messages_file);
    $messages = json_decode($messages_data, true);

    $success = false;
    $selected_data = null;

    // cari data dengan ID tertentu
    foreach ($messages as $message) {
        if ($message['id'] === $post_id) {
            $selected_data = $message;
            $success = true;

            // jika data ditemukan, ubah variabel read menjadi true
            $message['read'] = true;
            break;
        }
    }

    // jika berhasil
    if ($success) {
        // ambil indeks
        $index = array_search($selected_data, $messages);

        // ganti data
        $messages[$index]['read'] = true;

        // ke JSON
        $latest_data = json_encode($messages, JSON_PRETTY_PRINT);

        // simpan
        file_put_contents($messages_file, $latest_data);
    }

    // output
    $output = [
        'success' => $success,
        'data' => $selected_data,
    ];

    // kompres data dengan gzip
    $results_data = gzencode(json_encode($output), 9); // 9 level 

    // header untuk kompresi gzip
    header('Content-Type: application/json');
    header('Content-Encoding: gzip');

    // kirim ke frontend
    echo $results_data;
} else {
    // jika token salah
    $output = [
        'success' => false,
        'error' => 'Token salah',
    ];

    // kompres data dengan gzip
    $results_data = gzencode(json_encode($output), 9); // 9 level

    // header kompres
    header('Content-Type: application/json');
    header('Content-Encoding: gzip');

    echo $results_data;
}
?>

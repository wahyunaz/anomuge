<?php
// Dari JS
$data = json_decode(file_get_contents("php://input"), true);

// cek data ada
if (
    isset($data['sendto']) &&
    isset($data['replyto']) &&
    isset($data['anonymousId']) &&
    isset($data['pseudonym']) &&
    isset($data['username']) &&
    isset($data['message_him']) &&
    isset($data['my_message'])
) {
    // File JSON
    $file = 'databases/messages.json';
    $previous_data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    // membuat id
    function create_id($all_ids) {
        // prefix untuk id
        $random_prefix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        
        // tambahkan prefix
        $id = $random_prefix . uniqid();
    
        // Selalu buat id baru yang tidak sama
        while (in_array($id, $all_ids)) {
            $random_prefix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $id = $random_prefix . uniqid();
        }
    
        return $id;
    }

    // os
    function os()
    {
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

    // Data baru
    $new_reply_data = array(
        'id' => create_id(array_column($previous_data, 'id')),
        'sendto' => $data['sendto'],
        'replyto' => $data['replyto'],
        'pseudonym' => $data['pseudonym'],
        'username' => $data['username'],
        'anonymousId' => $data['anonymousId'],
        'message_him' => $data['message_him'],
        'my_message' => $data['my_message'],
        'date' => gmdate('Y-m-d\TH:i:s\Z'),
        'type' => 'reply_from_anonymous_user',
        'userAgent' => $_SERVER['HTTP_USER_AGENT'],
        'os' => os(),
        'read' => false,
        'hide' => false
    );

    $previous_data[] = $new_reply_data;

    // Simpan data
    file_put_contents($file, json_encode($previous_data, JSON_PRETTY_PRINT));

    // Berhasil
    header('Content-Type: application/json');
    echo json_encode(array('status' => true, 'message' => 'Success'));
} else {
    // Tidak diisi semua
    header('Content-Type: application/json');
    echo json_encode(array('status' => false, 'message' => 'Data harus diisi semua'));
}
?>

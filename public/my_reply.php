<?php
// Dari JS
$data = json_decode(file_get_contents("php://input"), true);

if (
    isset($data['send_to_anonymous_user']) &&
    isset($data['replyto']) &&
    isset($data['sender_id']) &&
    isset($data['message_him']) &&
    isset($data['my_message']) &&
    isset($data['his_pseudonym'])
) {
    // File
    $jsonFile = 'databases/messages.json';
    $previous_data = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

    // buat id
    function create_id($all_ids) {
        // prefix untuk id
        $random_prefix = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        
        //prefix
        $id = $random_prefix . uniqid();

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
        'send_to_anonymous_user' => $data['send_to_anonymous_user'],
        'replyto' => $data['replyto'],
        'sender_id' => $data['sender_id'],
        'message_him' => $data['message_him'],
        'my_message' => $data['my_message'],
        'his_pseudonym' => $data['his_pseudonym'],
        'date' => gmdate('Y-m-d\TH:i:s\Z'),
        'type' => 'send_to_anonymous_user',
        'userAgent' => $_SERVER['HTTP_USER_AGENT'],
        'os' => os(),
        'read' => false,
        'hide' => false
      

    );

    $previous_data[] = $new_reply_data;

    // Simpan data
    file_put_contents($jsonFile, json_encode($previous_data, JSON_PRETTY_PRINT));

    // Berhasil
    header('Content-Type: application/json');
    echo json_encode(array('status' => true, 'message' => 'Success'));
} else {
    // Tidak diisi
    header('Content-Type: application/json');
    echo json_encode(array('status' => false, 'message' => 'Data harus diisi semua'));
}
?>

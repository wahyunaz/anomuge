<?php

$msg_file = file_get_contents('databases/messages.json');
$messages = json_decode($msg_file, true);
$usr_file = file_get_contents('databases/users.json');
$users = json_decode($usr_file, true);

// post
$anonymous_id = isset($_POST['anonymous_id']) ? $_POST['anonymous_id'] : "";
$start_index = isset($_POST['start_index']) ? (int)$_POST['start_index'] : 0; // Take start_index from post data
$length = 12;
$result = [];
$end_index = 0;

// Filter dari terbaru
usort($messages, function ($a, $b) {
    return isset($b['timestamp']) && isset($a['timestamp']) ? strtotime($b['timestamp']) - strtotime($a['timestamp']) : 0;
});

foreach ($messages as $index => $message) {
    // ambil data yang send_to_anonymous_user dan anonymous_id nya sama
    if (isset($message['send_to_anonymous_user']) && $message['send_to_anonymous_user'] == $anonymous_id &&
        isset($message['sender_id'])) {
        $senderId = $message['sender_id'];

        $profile_data = array_values(array_filter($users, function ($user) use ($senderId) {
            return isset($user['id']) && $user['id'] == $senderId;
        }));

        // Data profile
        if (!empty($profile_data)) {
            $profile = [
                "username" => isset($profile_data[0]["username"]) ? $profile_data[0]["username"] : "",
                "verification" => isset($profile_data[0]["verification"]) ? $profile_data[0]["verification"] : "",
                "verification_reason" => isset($profile_data[0]["verification_reason"]) ? $profile_data[0]["verification_reason"] : "",
                "cover_photo" => isset($profile_data[0]["cover_photo"]) ? $profile_data[0]["cover_photo"] : "",
                "os" => isset($profile_data[0]["os"]) ? $profile_data[0]["os"] : "",
                "userAgent" => isset($profile_data[0]["userAgent"]) ? $profile_data[0]["userAgent"] : ""
            ];

            $data_results = array_merge($message, $profile);
            $result[] = $data_results;
        }

        $end_index = $index;
    }
}

// potong data 12 length dari start_index
$result_slice = array_slice($result, $start_index, $length);

// data response
$ress = [
    "data" => $result_slice,
    "end_index" => $end_index,
    "lots_of_data" => count($result)
];

$dt_results = json_encode($ress, JSON_PRETTY_PRINT);

// Compress
$d_results = gzencode($dt_results, 9);

header('Content-Encoding: gzip');
header('Content-Length: ' . strlen($d_results));

// result
echo $d_results;
?>

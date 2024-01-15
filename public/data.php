<?php

// data
$users_path = 'databases/users.json';
$messages_path = 'databases/messages.json';
$users_dataa = file_get_contents($users_path);
$users_data = json_decode($users_dataa, true);

// Check
if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'id cannot be empty']);
    exit;
}

$id = $_POST['id'];

$user_exists = false;
$user_token = '';

foreach ($users_data as $userData) {
    if ($userData['id'] === $id) {
        $user_exists = true;
        $user_token = $userData['token'];
        break;
    }
}

// jika tidak ada id
if (!$user_exists) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// jika tidak ada token
if (!isset($_POST['token'])) {
    echo json_encode(['success' => false, 'message' => 'token kosong']);
    exit;
}

$token = $_POST['token'];

// jika token salah
if ($token !== $user_token) {
    echo json_encode(['success' => false, 'message' => 'Invalid token']);
    exit;
}

//message data
$messages_content = file_get_contents($messages_path);
$allData = json_decode($messages_content, true);

// filter data dengan id
$filtered_data = array_filter($allData, function ($data) use ($id) {
    return isset($data['sendto']) && $data['sendto'] === $id;
});

usort($filtered_data, function ($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

// Potong data 12
if (isset($_POST['start_index'])) {
    $start_index = intval($_POST['start_index']);
    $sliced_data = array_slice($filtered_data, $start_index, 12);
    
    $end_of_index = $start_index + count($sliced_data);
    
    $result_data = array_values($sliced_data);
    
    // Kompress
    $results = gzencode(json_encode(['data' => $result_data, 'end_index' => $end_of_index, 'has_been_used' => count($filtered_data)]), 9);
    
    header('Content-Type: application/json');
    header('Content-Encoding: gzip');
    
    // Kirim ke frontend
    echo $results;
} else {
    echo json_encode(['success' => false, 'message' => 'start_index 0']);
}
?>

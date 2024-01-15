<?php

$inp = file_get_contents("php://input");

$input = json_decode($inp, true);

if ($input === null || !isset($input['token'], $input['anonymous_id'], $input['pseudonym'])) {
    echo json_encode(['success' => false, 'message' => 'invalid request']);
    exit();
}

$token = trim($input['token']);
$anonymous_id = $input['anonymous_id'];
$pseudonym = $input['pseudonym'];

if ($token === null || $anonymous_id === null || $pseudonym === null) {
    echo json_encode(['success' => false, 'message' => 'invalid request']);
    exit();
}

$jsonData = file_get_contents('databases/users.json');
$users = json_decode($jsonData, true);

// cari data dengan token
$f = false;
foreach ($users as &$user) {
    if ($user['token'] == $token) {
        // simpan data
        $user['anonymous_id'] =$anonymous_id;
        $user['pseudonym'] = $pseudonym;
        $f = true;
        break;
    }
}

// Jika user tidak ada
if (!$f) {
    echo json_encode(['success' => false, 'message' => 'not found']);
    exit();
}
// simpan
file_put_contents('databases/users.json', json_encode($users, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'success']);

?>

<?php
// cari data dengan id
function getData($id) {
    // json
    $mData = file_get_contents('databases/messages.json');
    $uData = file_get_contents('databases/users.json');
    
    // jadikan array
    $m_data = json_decode($mData, true);
    $u_data = json_decode($uData, true);

    $result = ['message' => '', 'data' => [], 'profile' => []];

    // Cari data dari id pada messages.json
    foreach ($m_data as $message) {
        if ($message['id'] === $id) {
            // ada
            $result['data'] = $message;
            
            // Cari data
            $senderId = $message['sender_id'];
            foreach ($u_data as $user) {
                if ($user['id'] === $senderId) {
                    $result['profile'] = $user;
                    break;
                }
            }
            
            //  Data pesan dan profil
            $resultData = array_merge($result['data'], ['profile' => $result['profile']]);
            
            return json_encode($resultData);
        }
    }

    // tidak ada
    $result['message'] = 'Tidak ada';
    return json_encode($result);
}

// id dari frontend
$id_data = isset($_POST['id']) ? $_POST['id'] : '';
// output
$result = getData($id_data);
echo $result;
?>

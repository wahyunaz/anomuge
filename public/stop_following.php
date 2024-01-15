<?php

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

function sv($path, $data)
{
    $dataa = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($path, $dataa);
}

function is_this_already_following($user, $follower_id)
{
    return in_array($follower_id, $user['followers']);
}

function remove($users, $username, $follower_id)
{
    foreach ($users as &$user) {
        if (strtolower(decrypt($user['username'], 71)) === strtolower($username)) {
            $key = array_search($follower_id, $user['followers']);
            if ($key !== false) {
                // Hapus follower dengan ID yang ditemukan
                unset($user['followers'][$key]);
                $user['followers'] = array_values($user['followers']); // Reset kembali indeks array
                return count($user['followers']);
            } else {
                // Follower tidak ditemukan
                return false;
            }
        }
    }

    // Username tidak ditemukan
    return false;
}

$token = $_POST['token'];
$username = $_POST['username'];

$path = './databases/users.json';
$users = json_decode(file_get_contents($path), true);

$follower_id = null;
foreach ($users as $user) {
    if ($user['token'] === $token) {
        $follower_id = $user['id'];
        break;
    }
}

if ($follower_id !== null) {
    try {
        $previous_length = 0;

        // cari user melalui username
        $target = null;
        foreach ($users as &$user) {
            if (strtolower(decrypt($user['username'], 71)) === strtolower($username)) {
                $target = $user;
                $previous_length = count($user['followers']);
                break;
            }
        }

        // ditemukan
        if ($target !== null) {
            $follower_length = remove($users, $username, $follower_id);

            // berhasil
            if ($follower_length !== false) {
                // save
                sv($path, $users);

                echo json_encode([
                    'status' => 'success',
                    'number_of_followers' => $follower_length,
                ]);
            } else {
                // follower tidak ditemukan
                echo json_encode(['status' => 'error', 'message' => 'follower not found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'user not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'err ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
}
?>

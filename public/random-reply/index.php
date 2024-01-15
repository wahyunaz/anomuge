<?php
function chrt($char, $key)
{
    if (preg_match('/[a-zA-Z]/', $char)) {
        $base = preg_match('/[A-Z]/', $char) ? 65 : 97;
        return chr((ord($char) - $base + $key + 26) % 26 + $base);
    } else {
        return $char;
    }
}

function ttb($text)
{
    return base64_encode($text);
}

function btt($base64)
{
    return base64_decode($base64);
}

function encrypt($text, $key)
{
    $resl = array_map(function ($char) use ($key) {
        return chrt($char, $key);
    }, str_split($text));

    return ttb(implode('', $resl));
}

function decrypt($text, $key)
{
    $resl = array_map(function ($char) use ($key) {
        return chrt($char, (26 - $key) % 26);
    }, str_split(btt($text)));

    return implode('', $resl);
}

function redirect($url)
{
    header("Location: $url");
    exit();
}

$username = isset($_GET['username']) ? $_GET['username'] : '';
$users = json_decode(file_get_contents('../databases/users.json'), true);

// ambil id dengan username sama
$id = null;
foreach ($users as $user) {
    if (strtolower(decrypt($user['username'], 71)) === strtolower($username)) {
        $id = $user['id'];
        break;
    }
}

$err = "";
$res = null;

// id tidak ditemukan
if ($id === null) {
    $err = '<h2 class="err">' . $username . ' tidak ditemukan</h2>';
} else {
    $messages = json_decode(file_get_contents('../databases/messages.json'), true);

    // seluruh data yang di filter
    $data = array_filter($messages, function ($message) use ($id) {
        return isset($message['sender_id'], $message['type'], $message['caption']) &&
            $message['sender_id'] == $id &&
            $message['type'] == "caption";
    });


    if (count($data) > 0) {
        $res = $data[array_rand($data)];
    } else {
        $err = '<h2 class="err">' . $username . ' belum memposting apapun</h2>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>balas acak ke <?php echo htmlspecialchars(($id !== null && isset($res['id'])) ? decrypt($user['username'], 71) : ''); ?></title>
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icon.png">
    <link rel="manifest" href="../manifest.json">

    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            background-color: black;
            padding: 0;
            margin: 0;
        }

        .err {
            color: white;
            text-align: center;
            font-size: 20px;
            margin-top: 10%;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <script>
        navigator.language && (document.documentElement.lang = navigator.language)
    </script>

    <?php
    if ($res !== null && isset($res['id'])) {
        redirect("../reply?id=" . $res["id"]);
    } else {
        echo '<script> document.title = "' . htmlspecialchars($username) . ' tidak ditemukan - Anomuge";</script>';
        echo $err;
    }
    ?>
</body>

</html>
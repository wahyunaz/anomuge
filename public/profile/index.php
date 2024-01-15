<?php

function format($num)
{
    if ($num >= 1000000000) {
        return number_format($num / 1000000000, 0, ',', '.') . ' Miliar';
    } else if ($num >= 1000000) {
        return number_format($num / 1000000, 0, ',', '.') . ' Juta';
    } else if ($num >= 1000) {
        return number_format($num / 1000, 0, ',', '.') . ' Ribu';
    } else {
        return strval($num);
    }
}


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

$users_data = '../databases/users.json';
$jsonn = file_get_contents($users_data);
$users = json_decode($jsonn, true);
$search = isset($_GET['n']) ? str_replace('@', '', $_GET['n']) : '';
$username = '';
$created = '';
$user_id = '';
$found = null;

foreach ($users as $user) {
    if (strtolower(decrypt($user['username'], 71)) === strtolower($search)) {
        $found = $user;
        break;
    }
}

if ($found) {
    $username = decrypt($found['username'], 71);
    $created = $found['created'];
    $user_id =  $found['id'];
}

// cek berapa kali menerima pesan
$messages = '../databases/messages.json';
$dat = file_get_contents($messages);

$msggs = json_decode($dat, true);

$amount_of_data = 0;

foreach ($msggs as $msg) {
    if (isset($msg['sendto']) && $msg['sendto'] === $user_id) {
        $amount_of_data++;
    }
}

// cek berapa kali memposting

$posting = 0;

foreach ($msggs as $post) {
    if (isset($post['sender_id']) && $post['sender_id'] === $user_id && $post['type'] === 'caption') {
        $posting++;
    }
}

// cek followers
function check_followers($username, $file)
{
    $ctn = file_get_contents($file);

    $users = json_decode($ctn, true);

    $user = array_filter($users, function ($u) use ($username) {
        return strtolower(decrypt($u['username'], 71)) == strtolower($username);
    });

    if (!empty($user)) {
        $followers = reset($user)['followers'];
        $fol = count($followers);
        return $fol;
    }

    return 0;
}



$followers = check_followers($search, $users_data);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($username); ?> on anomuge</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="description" content="Send <?php echo htmlspecialchars($username) ?> an anonymous message, and wait for a reply. <?php echo htmlspecialchars($username) ?> has received anonymous messages <?php echo $amount_of_data ?> times, and has posted <?php echo $posting ?> times">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icon.png">
    <meta property="og:title" content="<?php echo htmlspecialchars($username) ?> on anomuge">
    <meta property="og:description" content="Send <?php echo htmlspecialchars($username) ?> an anonymous message, and wait for a reply. <?php echo htmlspecialchars($username) ?> has received anonymous messages <?php echo $amount_of_data ?> times, and has posted <?php echo $posting ?> times">
    <meta property="og:image" content="../assets/icon.png">
    <link rel="manifest" href="../manifest.json">
    <script type="module">
        (async function() {
            // jika query kosong
            if (!new URLSearchParams(window.location.search).get('n')) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', '../check.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        let output = JSON.parse(xhr.responseText);

                        if (output.success) {
                            window.location.href = "../profile/?n=@" + decrypt(output.username, 71);
                        } else {
                            // akun salah
                            window.location.replace("../signin");
                        }
                    }
                };

                // Kirim data ke server
                xhr.send('token=' + encodeURIComponent(localStorage.getItem("_0_n")));
            }
            // akhir cek
        })();
    </script>


    <style>
        /* font teks poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap');

        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* chrome */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #2f2f2f;
        }

        ::-webkit-scrollbar-track {
            background-color: transparent;
        }

        /* Firefox & Edge */

        * {
            scrollbar-color: #2f2f2f transparent;
            /* Warna thumb dan track */
        }


        .read_more {
            color: #1D9BF0;
            font-family: Arial, Helvetica, sans-serif;
            user-select: none;
        }

        ::selection {
            background-color: #4a4a4a;
        }

        .paragraph {
            color: #afafaf;
        }

        .done {
            color: white;
            font-size: 14px;
            margin-left: 7px;
        }

        .open {
            color: #1D9BF0;
            cursor: default;
            border-radius: 2px;
        }

        .status_information {
            color: #E7E9EA;
            margin: 0 10px 10px 0;
            user-select: none !important;
            font-family: Arial, Helvetica, sans-serif;
        }

        .open:active {
            background-color: #053758;

        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }


        @-webkit-keyframes rotate {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        .load_data {
            width: 45px;
            height: 45px;
            border: solid 4px #E7E9EA;
            border-radius: 50%;
            border-right-color: transparent;
            border-bottom-color: transparent;
            -webkit-transition: all 0.5s ease-in;
            -webkit-animation-name: rotate;
            -webkit-animation-duration: 1.0s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;

            transition: all 0.5s ease-in;
            animation-name: rotate;
            animation-duration: 1.0s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }








        .hideData {
            display: none;
        }

        #loading {
            display: block;
            height: 92vh;
        }

        .button-container {
            margin-top: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none !important;
        }



        #user-information-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            font-family: Arial, Helvetica, sans-serif;
            user-select: none;
        }



        .information-title {
            text-align: center;
            color: #b5b5b5;
        }

        .information-value {
            text-align: center;
            color: #E7E9EA;
        }

        @media only screen and (max-height: 440px) {
            #main {
                height: 100vh;
            }
        }

        #mobile-footer {
            user-select: none;
        }




        #pc-navb,
        #mobile-navb {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 53px;
            font-size: 15px;
            justify-content: space-between;
            border-bottom: 0.5px solid rgb(47, 51, 54);
            align-items: center;
            padding: 0 25px 0 16px;
            background-color: black;
            user-select: none;
            z-index: 5;
            color: #E7E9EA;
            will-change: transform;
        }

        #edit,
        #editt {
            display: none;
            padding: 3px 6px;
            background-color: #1D9BF0;
            border-radius: 4px;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: 550;
        }

        #editt {
            cursor: unset;
        }

        #editt:active {
            background-color: #0d6cab;
        }

        #edit:hover {
            background-color: #0d6cab;
        }




        #mobile-footer {
            display: none;
            user-select: none;
        }


        .icn {
            margin: 0 10px;
        }


        .post-button {
            user-select: none !important;
            font-weight: 600;
            font-family: Arial, Helvetica, sans-serif;
        }

        .post-button:active {
            background-color: #0d6cab;
        }

        .bwhite {
            background-color: white;
        }

        .white {
            color: #E7E9EA;
        }

        .blue {
            color: #1D9BF0;
        }


        .bblue {
            background-color: #1D9BF0;
        }


        .title {
            font-size: 23px;
            font-family: Poppins, Arial, Helvetica, sans-serif;
        }

        .ic-click:hover {
            background-color: rgb(61, 61, 61);
        }

        .ic-click {
            font-size: 24px;
            cursor: pointer;
            padding: 8px 9px;
            background-color: transparent;
            border-radius: 70%;
        }

        .ic-click:active {
            background-color: rgb(61, 61, 61);
        }


        .icon-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
            font-size: 19px;
            padding: 10px 0;
        }

        .rounded-default {
            border-radius: 6px;
        }

        .desc {
            max-width: 350px;
        }

        .t-inf {
            font-size: 19px;

        }

        #profile-container {
            display: grid;
            place-items: center;
            padding: 40px 20px 0 20px;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        #name {
            color: #E7E9EA;
            font-size: 25px;
            font-weight: 550;
            font-family: Arial, Helvetica, sans-serif;
            user-select: none;
        }

        #bio {
            color: #b5b5b5;
            font-size: 17px;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 20px;
            user-select: none;
        }



        @media only screen and (max-width: 765px) {

            body {
                overflow: hidden;
            }

            button {
                cursor: unset;
            }

            #main {
                min-height: 90vh;
                overflow: auto;
                /*Firefox */
                scrollbar-width: thin;
                scrollbar-color: transparent transparent;

            }

            .backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.6);
                z-index: 10;
            }

            .read_more:active {
                color: #0675bf;
            }

            /* pupup button */

            .button-popup {
                display: none;
                position: fixed;
                border-radius: 9px;
                width: 80%;
                top: 50%;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgb(42, 42, 42);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
                font-family: Arial, Helvetica, sans-serif;
                z-index: 15;
                user-select: none;
            }

            .info-container {
                padding: 17px 12px 12px 12px;
                color: #E7E9EA;
            }

            .info-message {
                color: #979797;
                margin: 7px 0;
                padding: 0 12px;
            }

            .button-ctr {
                border-top: 0.5px solid #3A3A3A;
                display: flex;
            }

            .popup-button {
                width: 49.9%;
                padding: 12px 0;
                color: #1D9BF0;
                font-size: 16px;
                font-weight: bold;
                white-space: nowrap;
                overflow: hidden;
                cursor: unset;
            }

            .left-button {
                border-right: 0.5px solid #3A3A3A;
            }

            .right-button {
                border-left: 0.5px solid #3A3A3A;
            }

            .left-button:active {
                background-color: #3A3A3A;
                border-radius: 0 0 0 9px;

            }

            .right-button:active {
                background-color: #3A3A3A;
                border-radius: 0 0 9px 0
            }

            /* end */

            #follow {
                padding: 0 17px;
                height: 35px;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #0095F6;
                color: white;
                font-weight: 530;
                border-radius: 5px;
            }

            #has-been-followed {
                padding: 0 11px;
                height: 35px;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #404040;
                color: #E7E9EA;
                font-weight: 530;
                border-radius: 5px;
            }

            #random-reply {
                padding: 0 11px;
                margin-left: 20px;
                height: 35px;
                font-size: 15px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #404040;
                color: white;
                font-weight: 530;
                border-radius: 5px;
            }


            #random-reply:active {
                background-color: #303030;
            }

            #has-been-followed:active {
                background-color: #303030;
            }

            #follow:active {
                background-color: #0061a2;
            }



            /* Chrome dan Safari */
            #main::-webkit-scrollbar {
                width: 0;
            }

            /* Firefox */
            #main::-moz-scrollbar {
                display: none;
            }

            #pc-navb {
                display: none;
            }

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 10px;
                margin: 0 5px;
                color: black;
                border-radius: 50%;
            }



            #empty-data {
                border-top: 1px solid rgb(47, 51, 54);
                padding-top: 30px;
                margin-top: 12%;
            }

            #data-container {
                border-top: 1px solid rgb(47, 51, 54);
                margin-top: 40px;
            }

            .time {
                color: #96999a;
                font-size: 15px;
                font-family: Arial, Helvetica, sans-serif;
                margin-left: 5px;
                margin-top: 2px;
            }

            .icn {
                cursor: unset;
                font-size: 24px;
                padding: 9px;
                border-radius: 50%;
                margin: 0 7px;
            }

            .icn:active {
                background-color: #343434;
            }


            .post-container {
                padding: 10px 17px;
                width: 100%;
                border-bottom: 1px solid rgb(47, 51, 54);
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
            }

            .username-ctr {
                padding: 10px 0;
            }

            .user-name {
                color: #E7E9EA;
                font-size: 19px;
                font-family: Arial, Helvetica, sans-serif;
                font-weight: 550;
                user-select: none !important;
            }

            .caption-container {
                padding: 5px 0;
                color: #E7E9EA;
                font-family: Arial, Helvetica, sans-serif;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
            }

            #sidebar {
                display: none;
            }

            #data-container {
                padding-bottom: 60px;
            }

            .showData {
                display: block;
            }

            #mobile-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                display: flex;
                height: 59px;
                background-color: black;
                will-change: transform;
                padding: 0 8%;
                border-top: 0.5px solid rgb(47, 51, 54);
            }

            .button-list {
                justify-content: space-between;
                align-items: center;
                display: flex;
                width: 100%;
            }

            .mobile-page-button {
                color: #b5b5b5;
                display: grid;
                place-items: center;
                cursor: unset;
                height: 100%;
                padding: 13.5px 7px;
            }

            .mobile-page-icon {
                font-size: 19px;
            }

            .mobile-page-name {
                font-size: 11px;
                margin-top: 3px;
            }

            .mobile-is-here {
                color: #E7E9EA;
            }

            .card {
                width: 160px;
                background-color: #2a2a31;
                box-sizing: content-box;
                margin: 10px;
                border-radius: 6px;
                cursor: unset;
                user-select: none;
            }

            .end {
                .card {
                    width: 160px;
                    background-color: transparent;
                    height: 160px;
                    box-sizing: content-box;
                    margin: 10px;
                    border-radius: 6px;
                    cursor: unset;
                    user-select: none;
                }
            }


            .card:active {
                background-color: #212127;
            }

            .card-icon {
                font-size: 40px;
                color: #E7E9EA;
            }


            #navb {
                padding: 2em 14px;
            }

            .ic-click {
                cursor: unset !important;
            }

            .post-button {
                user-select: none !important;
                font-weight: 600;
                font-family: Arial, Helvetica, sans-serif;
                cursor: unset !important;
            }

            .ic-click:hover {
                background-color: transparent;
            }

            .ic-click:active {
                background-color: rgb(61, 61, 61);
            }

            #mobile-navb {
                padding: 2em 14px;
                display: flex;
            }

            .toast {
                display: flex;
                background-color: rgb(42, 42, 42);
                color: #E7E9EA;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 100;
                padding: 15px;
                box-shadow: 0px -4px 4px rgba(0, 0, 0, 0.4);
                user-select: none;
            }

            @keyframes rotate {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }


            @-webkit-keyframes rotate {
                from {
                    -webkit-transform: rotate(0deg);
                }

                to {
                    -webkit-transform: rotate(360deg);
                }
            }

            .loading {
                width: 50px;
                height: 50px;
                border: solid 5px #E7E9EA;
                border-radius: 50%;
                border-right-color: transparent;
                border-bottom-color: transparent;
                -webkit-transition: all 0.5s ease-in;
                -webkit-animation-name: rotate;
                -webkit-animation-duration: 1.0s;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;

                transition: all 0.5s ease-in;
                animation-name: rotate;
                animation-duration: 1.0s;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
            }

            #load_data {
                display: none;
                padding-top: 2vw;
                justify-content: center;
                height: 170px;
            }

            .user-information {
                margin: 0 3vw;
            }
        }

        @media only screen and (min-width: 765px) {




            body {
                display: flex;
                overflow: hidden;

            }

            button {
                cursor: pointer;
            }

            .read_more:hover {
                color: #0675bf;
            }

            #follow {
                padding: 0 17px;
                height: 40px;
                font-size: 17.5px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #0095F6;
                color: white;
                font-weight: 530;
                border-radius: 5px;
            }

            #has-been-followed {
                padding: 0 11px;
                height: 40px;
                font-size: 17.5px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #404040;
                color: #E7E9EA;
                font-weight: 530;
                border-radius: 5px;
            }

            #random-reply {
                padding: 0 11px;
                margin-left: 20px;
                height: 40px;
                font-size: 17.5px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #404040;
                color: white;
                font-weight: 530;
                border-radius: 5px;
            }


            #random-reply:hover {
                background-color: #303030;
            }

            #has-been-followed:hover {
                background-color: #303030;
            }

            #follow:hover {
                background-color: #0061a2;
            }


            .user-information {
                margin: 0 1.2vw;
            }

            #load_data {
                display: none;
                padding-top: 2.2vw;
                justify-content: center;
                height: 120px;
            }



            #main {
                height: 100vh;
                overflow: auto;
            }

            .open {
                cursor: pointer;
            }

            .open:hover {
                color: #1b8ad4;
            }


            .toast {
                display: flex;
                background-color: rgb(42, 42, 42);
                color: #E7E9EA;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                position: fixed;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 100;
                padding: 15px 30px;
                justify-content: center;
                border-radius: 6px;
                box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.4);
                user-select: none;
            }

            .icn {
                cursor: pointer;
                font-size: 24px;
                padding: 9px;
                border-radius: 50%;
                margin: 0 7px;
            }

            .icn:hover {
                background-color: #343434;
            }

            .time {
                color: #96999a;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                margin-left: 5px;
            }

            #empty-data {
                border-top: 1px solid rgb(47, 51, 54);
                padding-top: 30px;
                margin-top: 60px;
            }


            .post-container {
                padding: 10px 17px;
                width: 70%;
                background-color: #2a2a31;
                margin-top: 10px;
                border-radius: 6px;
            }

            .username-ctr {
                padding: 10px 0;
            }

            .user-name {
                color: #E7E9EA;
                font-size: 21px;
                font-family: Arial, Helvetica, sans-serif;
                font-weight: 550;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                user-select: none !important;
            }

            .caption-container {
                padding: 9px 0;
                color: #E7E9EA;
                font-size: 18px;
                font-family: Arial, Helvetica, sans-serif;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
            }

            .post-container::selection {
                background-color: #454545;
            }


            #empty-data {
                border-top: 1px solid rgb(25, 27, 29);
                padding-top: 30px;
            }

            #data-container {
                margin-top: 40px;
                place-items: center;

            }

            #mobile-navb {
                display: none;
            }

            #mobile-footer {
                display: none;
            }

            #pc-navb {
                display: flex;
                padding-left: 23px;
            }


            #main {
                overflow: auto;
                scrollbar-width: thin;
                width: 100%;

            }

            #data-container {
                padding: 20px;
            }

            .showData {
                display: grid;
                place-items: center;
            }

            .card {
                width: 170px;
                background-color: #2a2a31;
                box-sizing: content-box;
                margin: 10px;
                border-radius: 6px;
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
                user-select: none;
            }

            .card:hover {
                transform: scale(1.1);
            }

            .card:active {
                background-color: #212127;
            }

            .card-icon {
                font-size: 40px;
                color: #E7E9EA;
            }

            .end {
                width: 170px;
                height: 170px;
                background-color: transparent;
                box-sizing: content-box;
                margin: 10px;
                border-radius: 6px;
                cursor: pointer;
                transition: transform 0.2s ease-in-out;
                user-select: none;
            }




            #sidebar {
                width: 17vw;
                height: 100vh;
                background-color: rgb(0, 0, 0);
                z-index: 1;
                border-right: 1px solid rgb(47, 51, 54);
                overflow-y: auto;
                padding-top: 81px;
                user-select: none;
            }




            #main {
                overflow: auto;
                scrollbar-width: thin;
                width: 100%;
                padding-top: 75px;

            }

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 11.5px;
                margin: 0 5px;
                color: black;
                border-radius: 50%;
            }

            .page-button {
                padding: 10px 13px;
                margin: 7px 12px;
                font-family: Arial, Helvetica, sans-serif;
                font-weight: 570;
                display: flex;
                align-items: center;
                font-size: 20px;
                cursor: pointer;
            }

            .is-here {
                background-color: #2a2a31;
                border-radius: 9px;
            }

            .page-button:hover {
                background-color: #1c1c20;
                border-radius: 9px;
            }

            .is-here:hover {
                background-color: #2a2a31;
            }

            .page-icon {
                font-size: 23px;
            }

            .page-name {
                margin-left: 20px;
            }

            #page-button-container {
                border-bottom: 0.2px solid rgb(47, 51, 54);
                padding: 0 0 10px 0;
            }

            #copyright {
                color: #717171;
                text-align: center;
                margin: 17px 0;
                font-size: 14px;
            }

            .backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                z-index: 10;
            }

            .button-popup {
                display: none;
                position: fixed;
                border-radius: 9px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgb(42, 42, 42);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
                font-family: Arial, Helvetica, sans-serif;
                z-index: 15;
                user-select: none;
                max-width: 400px;
            }

            .info-container {
                padding: 17px 12px 12px 12px;
                color: #E7E9EA;
            }

            .info-message {
                color: #979797;
                margin: 7px 0;
                padding: 0 12px;
            }

            .button-ctr {
                border-top: 0.5px solid #3A3A3A;
                display: flex;
            }

            .popup-button {
                width: 49.9%;
                padding: 12px 0;
                color: #1D9BF0;
                font-size: 16px;
                font-weight: bold;
                white-space: nowrap;
                overflow: hidden;
            }

            .left-button {
                border-right: 0.5px solid #3A3A3A;
            }

            .right-button {
                border-left: 0.5px solid #3A3A3A;
            }

            .left-button:hover {
                background-color: #3A3A3A;
                border-radius: 0 0 0 9px;

            }

            .right-button:hover {
                background-color: #3A3A3A;
                border-radius: 0 0 9px 0
            }



            /* end */




            .post-button:hover {
                background-color: #0d6cab;
            }

            @keyframes rotate {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }


            @-webkit-keyframes rotate {
                from {
                    -webkit-transform: rotate(0deg);
                }

                to {
                    -webkit-transform: rotate(360deg);
                }
            }


            .loading {
                width: 60px;
                height: 60px;
                border: solid 7px #E7E9EA;
                border-radius: 50%;
                border-right-color: transparent;
                border-bottom-color: transparent;
                -webkit-transition: all 0.5s ease-in;
                -webkit-animation-name: rotate;
                -webkit-animation-duration: 1.0s;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;

                transition: all 0.5s ease-in;
                animation-name: rotate;
                animation-duration: 1.0s;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
            }
        }

        /* max width 1210 */
        @media screen and (max-width: 1210px) {
            #main {
                padding-top: 75px;
            }

            #sidebar {
                width: 77px;
            }

            #copyright {
                display: none;
            }

            .page-name {
                display: none;
            }

            .page-button {
                text-align: center;
                display: flex;
                justify-content: center;
            }
        }

        @media screen and (min-width: 1210px) {
            .page-icon {
                width: 29px;
            }
        }
    </style>
</head>

<body class="bg-black">
    <section id="sidebar">
        <ul id="page-button-container">
            <li>
                <a href="../" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-home"></i>
                    <p class="page-name">Beranda</p>
                </a>
            </li>
            <li>
                <a href="../post" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-pencil-alt"></i>
                    <p class="page-name">Posting</p>
                </a>
            </li>
            <li>
                <div id="isHere" onclick="window.location.href = `../profile/?n=@${decrypt(localStorage.getItem('rk_4t9'),71)}`" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-user"></i>
                    <p class="page-name">Profil</p>
                </div>
            </li>
            <li>
                <a href="../followed" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-asterisk"></i>
                    <p class="page-name">Status</p>
                </a>
            </li>
            <li>
                <a href="../messages" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-comment"></i>
                    <p class="page-name">Pesan</p>
                </a>
            </li>
            <li>
                <a href="../about" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-info-circle"></i>
                    <p class="page-name">Tentang</p>
                </a>
            </li>
        </ul>
        <p id="copyright"></p>
    </section>

    <section id="main">
        <nav id="pc-navb" class="bg-black">
            <span>

                <h1 class="title white font-bold">Anomuge</h1>
            </span>
            <span style="align-items: center;" class="flex">
                <button onclick="window.location.href='./settings'" id="edit">Edit</button>
                <i id="share-profile" style="font-size: 21.2px; margin-left: 5px; display: none;" class="ic-click fas fa-link"></i>

            </span>
        </nav>
        <nav id="mobile-navb" class="bg-black">
            <span id="navbar_n" style="align-items: center; display: none;">
                <i id="back" onclick="window.history.length > 1 ? window.history.back() : window.location.replace('../');" class="ic-click fas fa-arrow-left text-xl"></i>
                <h1 style="margin-left: 5px;" id="sender-name" class="font-bold text-xl">Profil</h1>
            </span>
            <span style="display: flex;align-items: center;">
                <button onclick="window.location.href='./settings'" id="editt">Edit</button>
                <i id="m-share-profile" style="font-size: 21.2px; margin-left: 5px; display: none;" class="ic-click fas fa-link"></i>
            </span>
        </nav>
        <section style="display: none;" id="profile-container">
            <span style="display: flex; align-items: center;">
                <h1 id="name"></h1><i id="verification" style="display: none;" class="verification fas fa-check"></i>
            </span>
            <p id="bio"></p>
            <div id="user-information-container">
                <div class="user-information">
                    <p id="followers" class="information-value"><?php echo format($followers) ?></p>
                    <p class="information-title">Pengikut</p>
                </div>
                <div class="user-information">
                    <p class="information-value"><?php echo format($amount_of_data) ?></p>
                    <p class="information-title">Kiriman</p>
                </div>
                <div class="user-information">
                    <p class="information-value"><?php echo format($posting) ?></p>
                    <p class="information-title">Postingan</p>
                </div>
            </div>
            <div style="display: none;" id="button-container" class="button-container">
                <button id="follow" type="submit" style="display: none;">Ikuti</button>
                <button id="has-been-followed" type="submit" style="display: none;">Mengikuti<i class="done fas fa-check"></i></button>
                <button style="display: none;" id="random-reply" type="submit">Balas acak</button>
            </div>
        </section>
        <section class="hideData" id="data-container">

        </section>
        <section id="load_data">
            <div class="load_data"></div>
        </section>
        <section id="loading">
            <div style="display: flex; justify-content: center; align-items: center; height: 80%; width: 100%;" class="loading-container">
                <div class="loading"></div>
            </div>
        </section>
        <section style="display: none;" id="empty-data" class="flex justify-center items-center select-none">
            <div class="inf inline-block text-center">
                <h1 class="paragraph desc m-5">Belum ada postingan</h1>

        </section>

        <div id="backdrop" class="backdrop"></div>
        <!-- horizontal -->
        <div id="button-popup" class="button-popup">
            <div class="info-container text-center">
                <h1 id="popupTitle" class="font-bold text-xl"></h1>
                <p id="msgg" class="info-message"></p>
            </div>
            <div class="button-ctr flex">
                <button id="leftButton" class="popup-button left-button"></button>
                <button id="rightButton" class="popup-button right-button"></button>
            </div>
        </div>
    </section>
    <div style="display: none;" class="toast" id="toast"></div>
    <footer id="mobile-footer">
        <ul class="button-list">
            <li onclick="window.location.href = '../'" class="mobile-page-button">
                <i class="mobile-page-icon fas fa-home"></i>
                <p class="mobile-page-name">Beranda</p>
            </li>
            <li onclick="window.location.href = '../followed'" class="mobile-page-button">
                <i class="mobile-page-icon fas fa-asterisk"></i>
                <p class="mobile-page-name">Status</p>
            </li>
            <li onclick="window.location.href = '../messages'" class="mobile-page-button">
                <i class="mobile-page-icon fas fa-comment"></i>
                <p class="mobile-page-name">Pesan</p>
            </li>
            <li onclick="window.location.href = `../profile/?n=@${decrypt(localStorage.getItem('rk_4t9'),71)}`" id="is-here" class="mobile-page-button">
                <i class="mobile-page-icon fas fa-user"></i>
                <p class="mobile-page-name">Profil</p>
            </li>
        </ul>
    </footer>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../sw.js')
                .then((reg) => {
                    console.log(reg.scope);
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    </script>

    <script>
        document.querySelector('html').setAttribute('lang', navigator.language || navigator.userLanguage);
    </script>

    <script type="text/javascript">
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
            document.body.style.userSelect = "none";
        }

        const copyright = document.getElementById("copyright");
        copyright.innerText = `© ${new Date().getFullYear()} Wahyuna`;

        function format(num) {
            if (num >= 1000000000) {
                return (num / 1000000000).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' Miliar';
            } else if (num >= 1000000) {
                return (num / 1000000).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' Juta';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' Ribu';
            } else {
                return num.toString();
            }
        }

        const main = document.getElementById("main");
        const name = document.getElementById("name");
        const bio = document.getElementById("bio");
        const dataContainer = document.getElementById("data-container");
        const emptyData = document.getElementById("empty-data");
        const toastt = document.getElementById("toast");
        const vrf = document.getElementById("verification")
        const isHere = document.getElementById("isHere");
        const is_here = document.getElementById("is-here");
        const mobileFooter = document.getElementById("mobile-footer");
        const back = document.getElementById("back");
        const senderName = document.getElementById("sender-name");
        const navbar_n = document.getElementById("navbar_n");
        const edit = document.getElementById("edit");
        const editt = document.getElementById("editt");
        const loading_section = document.getElementById("loading");
        const profile_section = document.getElementById("profile-container")
        const share_profile = document.getElementById("share-profile");
        const m_share_profile = document.getElementById("m-share-profile");
        const load_data = document.getElementById("load_data");
        const buttonContainer = document.getElementById("button-container");
        const follow = document.getElementById("follow");
        const has_been_followed = document.getElementById("has-been-followed");
        const followers = document.getElementById("followers");
        const random_reply = document.getElementById("random-reply");

        // popup_x
        const buttonPopup = document.getElementById("button-popup");
        const backdrop = document.getElementById("backdrop");
        const loadingPopup = document.getElementById("popup");
        const popupTitle = document.getElementById("popupTitle");
        const msgg = document.getElementById("msgg");
        const leftButton = document.getElementById("leftButton");
        const rightButton = document.getElementById("rightButton");

        random_reply.addEventListener("click", function() {
            window.location.href = "../random-reply/?username=<?php echo htmlspecialchars($username) ?>"
        })


        function popup_x(title, msg, leftButtonName, rightButtonName, leftButtonFunction, rightButtonFunction) {
            document.body.style.overflow = 'hidden';
            backdrop.style.display = 'block';
            buttonPopup.style.display = 'block';

            popupTitle.innerText = title;
            msgg.innerText = msg;
            leftButton.innerText = leftButtonName;
            rightButton.innerText = rightButtonName;
            leftButton.addEventListener("click", function(event) {
                backdrop.style.display = 'none';
                buttonPopup.style.display = 'none';
                leftButtonFunction();
                document.body.style.overflow = 'auto';
            })
            rightButton.addEventListener("click", function(event) {
                backdrop.style.display = 'none';
                buttonPopup.style.display = 'none';
                rightButtonFunction();
                document.body.style.overflow = 'auto';
            });
        }





        function toast(message) {
            toastt.textContent = message;
            toastt.style.display = "flex";
            setTimeout(function() {
                toastt.style.display = "none";
            }, 2000);
        }
        const chrt = (char, key) => /[a-zA-Z]/.test(char) ? String.fromCharCode((char.charCodeAt() - (/[A-Z]/.test(char) ? 65 : 97) + key + 26) % 26 + (/[A-Z]/.test(char) ? 65 : 97)) : char;
        const text_to_base64 = (text) => btoa(text);
        const base64_to_text = (base64) => atob(base64);
        const encrypt = (text, key) => text_to_base64([...text].map(char => chrt(char, key)).join(''));
        const decrypt = (text, key) => [...base64_to_text(text)].map(char => chrt(char, (26 - key) % 26)).join('');

        const ago = timestamp => {
            const t = new Date() - new Date(timestamp);
            const s = Math.floor(t / 1000);
            const m = Math.floor(s / 60);
            const h = Math.floor(m / 60);
            const d = Math.floor(h / 24);
            const w = Math.floor(d / 7);
            const mn = Math.floor(w / 4);
            const y = Math.floor(mn / 12);

            return t < 1000 ? 'baru saja' : s < 60 ? `${s} detik` : m < 60 ? `${m} menit` : h < 24 ? `${h} jam` : d < 7 ? `${d} hari` : w < 4 ? `${w} minggu` : mn < 12 ? `${mn} bulan` : `${y} tahun`;
        };

        function postCtr(name_data, caption_data, date_data, id_data, verification_data, user_id_data, reply_data) {
            const postContainer = document.createElement('div')
            postContainer.setAttribute("class", "post-container")
            postContainer.setAttribute("id", id_data)
            const profileCtr = document.createElement('div')
            profileCtr.style.display = "flex"
            profileCtr.style.alignItems = "center"
            profileCtr.style.justifyContent = "space-between"
            profileCtr.style.userSelect = "none"
            const usernameContainer = document.createElement('span')
            usernameContainer.setAttribute("class", "username-ctr")
            usernameContainer.style.display = "flex"
            usernameContainer.style.alignItems = "center"
            const user_name = document.createElement('p')
            user_name.setAttribute("class", "user-name")
            user_name.innerText = name_data
            usernameContainer.appendChild(user_name)

            const verification = document.createElement('i')
            verification.setAttribute("class", "verification fas fa-check")

            if (verification_data) {
                usernameContainer.appendChild(verification)
            }

            const time = document.createElement('p')
            time.setAttribute("class", "time")
            time.innerText = "• " + ago(date_data)
            setInterval(function() {
                time.innerText = "• " + ago(date_data)
            }, 1000)
            usernameContainer.appendChild(time)
            profileCtr.appendChild(usernameContainer)





            const captionContainer = document.createElement('div')
            captionContainer.setAttribute("class", "caption-container")
            const caption = document.createElement("p")
            caption.setAttribute("class", "caption")

            function random_clid(length) {
                var result = '';
                var strr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

                for (var i = 0; i < length; i++) {
                    result += strr.charAt(Math.floor(Math.random() * strr.length));
                }

                return result;
            }

            caption.innerHTML = '';

            caption_data.split(/\s+/).forEach(word => {
                // Cek URL
                const match = word.match(/\b(https?:\/\/)?([^\s,."]+(\.[^\s,."]+)+[^\s,.]*)\b/i);


                if (match) {
                    const [, prt, url] = match;
                    const link = document.createElement('a');
                    const open = `${(prt ? prt.toLowerCase() : 'http://') + url.toLowerCase()}${url.includes('?') ? '&' : '?'}anomuge_clid=${random_clid(25)}`;
                    link.setAttribute('href', open);

                    link.setAttribute('class', 'open');

                    if (!('manifest' in document.createElement('link'))) {
                        link.setAttribute('target', '_blank');
                    }

                    // salin link
                    link.addEventListener('contextmenu', function(event) {
                        event.preventDefault();
                        navigator.clipboard.writeText('http://' + this.textContent.trim()).then(() => toast("Link berhasil disalin")).catch(err => toast("Gagal menyalin link"));
                        return false;
                    });
                    link.appendChild(document.createTextNode(` ${url} `));

                    // link
                    caption.appendChild(link);
                } else {
                    // Jika bukan link, teks biasa
                    caption.appendChild(document.createTextNode(` ${word} `));
                }
            });

            let c_text = caption.innerHTML;

            const less = document.createElement('p');
            less.setAttribute('class', 'read_more');
            less.innerText = "Lebih sedikit";
            less.style.display = "none";

            if (c_text.length > 400) {
                const shortText = c_text.slice(0, 400) + "... ";
                caption.innerHTML = shortText;

                const read_more = document.createElement('span');
                read_more.setAttribute('class', 'read_more');
                read_more.innerText = "Baca selengkapnya";

                less.addEventListener('click', function(e) {
                    less.style.display = "none";
                    read_more.style.display = "block";
                    caption.innerHTML = shortText;
                    caption.appendChild(read_more);
                });

                read_more.addEventListener('click', function() {
                    read_more.style.display = "none";
                    less.style.display = "block";
                    caption.innerHTML = c_text;
                    caption.appendChild(less);
                });

                caption.appendChild(read_more);
            } else {
                caption.innerHTML = c_text;
            }

            caption.appendChild(less);



            const iconContainer = document.createElement('div')
            iconContainer.setAttribute("class", "icon-container")

            const reply = document.createElement("i")
            reply.setAttribute("class", "icn fas fa-reply")

            setInterval(function() {
                if (user_id_data == localStorage.getItem("z_j")) {
                    reply.style.display = "none"
                }
            }, 1)

            const copy = document.createElement("i")
            copy.setAttribute("class", "icn fas fa-link")


            reply.addEventListener("click", function() {
                window.location.href = "../reply/?id=" + id_data
            })

            copy.addEventListener("click", function() {
                navigator.clipboard.writeText("http://" + window.location.hostname + "/reply/?id=" + id_data)
                    .then(() => {
                        toast("Link berhasil disalin")
                    })
                    .catch(err => {
                        toast("Gagal menyalin link")
                    });
            })

            const others = document.createElement("i")
            others.setAttribute("class", "icn fas fa-angle-right")
            others.style.fontSize = "35px";

            if (user_id_data != localStorage.getItem("z_j")) {
                others.style.display = "none"
            }

            const cls = document.createElement("i")
            cls.setAttribute("class", "icn fas fa-angle-left")
            cls.style.fontSize = "35px";
            cls.style.display = "none"

            const delete_button = document.createElement("i")
            delete_button.setAttribute("class", "icn fas fa-trash")
            delete_button.style.fontSize = "21px";
            delete_button.style.display = "none"

            delete_button.addEventListener("click", function() {
                popup_x("Hapus status", "Yakin ingin menghapus status ini?", "Batal", "Ya", function() {
                    false
                }, function() {
                    //hapus
                    const data = {
                        token: localStorage.getItem("_0_n"),
                        post_id: id_data
                    };


                    const req = {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    };


                    fetch("../delete_post.php", req)
                        .then(ress => ress.text())
                        .then(res => {
                            toast("Status berhasil dihapus")
                            postContainer.style.display = "none"
                        })
                        .catch(error => {
                            toast("Gagal menghapus status")
                            console.error(error);
                        });
                })
            })

            others.addEventListener("click", function(e) {
                others.style.display = "none"
                cls.style.display = "block"
                delete_button.style.display = "block"
            })


            cls.addEventListener("click", function(e) {
                delete_button.style.display = "none"
                cls.style.display = "none"
                others.style.display = "block"

            })

            iconContainer.appendChild(reply)
            iconContainer.appendChild(copy)
            iconContainer.appendChild(others)
            iconContainer.appendChild(delete_button)
            iconContainer.appendChild(cls)
            postContainer.appendChild(profileCtr)
            captionContainer.appendChild(caption)
            captionContainer.appendChild(iconContainer)
            postContainer.appendChild(captionContainer)
            const info_container = document.createElement('div');
            const status_information = document.createElement('p');
            status_information.setAttribute('class', 'status_information');
            status_information.innerHTML = reply_data > 0 ? `<span style="font-weight: bold;">${format(reply_data)}</span> balasan` : reply_data === 0 ? "Belum ada balasan" : "error";
            info_container.appendChild(status_information)
            postContainer.appendChild(info_container);
            dataContainer.appendChild(postContainer)
        }


        let query_data = new URLSearchParams(window.location.search).get('n');
        if (query_data) {
            query_data = query_data[0] == '@' ? query_data.replace("@", "") : query_data
            fetch('../profile_be.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'username=' + encodeURIComponent(encrypt(query_data, 71)),
                })
                .then(results => results.json())
                .then(data => {
                    if (data.success) {


                        share_profile.addEventListener("click", function(e) {
                            e.preventDefault();
                            navigator.clipboard.writeText('https://' + window.location.hostname + "/profile/?n=@" + decrypt(data.user.username, 71)).then(() => toast("Link berhasil disalin")).catch(err => toast("Gagal menyalin link"));

                        })

                        m_share_profile.addEventListener("click", function(e) {
                            e.preventDefault();
                            navigator.clipboard.writeText('https://' + window.location.hostname + "/profile/?n=@" + decrypt(data.user.username, 71)).then(() => toast("Link berhasil disalin")).catch(err => toast("Gagal menyalin link"));

                        })


                        // cek profile
                        if (localStorage.getItem("_0_n")) {
                            const ran = (length) => Array.from({
                                length
                            }, () => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' [(Math.random() * 62) | 0]).join('');




                            let xhr = new XMLHttpRequest();
                            xhr.open('POST', '../check.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    let output = JSON.parse(xhr.responseText);
                                    localStorage.setItem('rk_4t9', output.username)
                                    // console.log(output)
                                    // console.log(data)


                                    if (output.success) {
                                        // jika id nya sama berati profile pribadi
                                        if (output.id == data.user.id) {
                                            isHere.classList.add("is-here")
                                            is_here.classList.add("mobile-is-here")
                                            back.style.display = "none"
                                            senderName.innerText = "Profil"
                                            localStorage.setItem("z_j", output.id)
                                            edit.style.display = "block"
                                            editt.style.display = "block"
                                            navbar_n.style.display = "flex"
                                            m_share_profile.style.display = "block"
                                            share_profile.style.display = "block"
                                            buttonContainer.style.display = "none"

                                        } else {
                                            navbar_n.style.display = "flex"
                                            m_share_profile.style.display = "block"
                                            share_profile.style.display = "block"


                                            // cek apakah sudah follow atau belum
                                            const datt = new FormData();
                                            datt.append('token', localStorage.getItem("_0_n"));
                                            datt.append('username', query_data);


                                            fetch('../have_followed.php', {
                                                    method: 'POST',
                                                    body: datt,
                                                })
                                                .then(r => r.json())
                                                .then(d => {
                                                    if (d.success) {
                                                        if (d.have_followed) {
                                                            follow.style.display = 'none';
                                                            has_been_followed.style.display = 'block';
                                                        } else {
                                                            has_been_followed.style.display = 'none';
                                                            follow.style.display = 'block';

                                                        }
                                                        buttonContainer.style.display = "flex"
                                                    } else {
                                                        console.error(d.error);
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error(error);
                                                });

                                            // bukan profil pribadi
                                            follow.addEventListener('click', function() {
                                                if (localStorage.getItem("_0_n")) {
                                                    follow.style.display = 'none';
                                                    has_been_followed.style.display = 'block';

                                                    // follow
                                                    async function followw(token, username) {
                                                        const dat = new FormData();
                                                        dat.append('token', token);
                                                        dat.append('username', username);
                                                        try {
                                                            const respn = await fetch('../follow.php', {
                                                                method: 'POST',
                                                                body: dat
                                                            });

                                                            if (respn.ok) {
                                                                const result = await respn.json();
                                                                if (result.status === 'success') {
                                                                    followers.innerText = result.number_of_followers
                                                                } else {
                                                                    console.error(result.message);
                                                                    has_been_followed.style.display = 'none';
                                                                    follow.style.display = 'block';
                                                                }
                                                            } else {
                                                                console.error('error');
                                                            }
                                                        } catch (error) {
                                                            console.error(error);
                                                        }
                                                    }


                                                    followw(localStorage.getItem("_0_n"), query_data);
                                                } else {
                                                    window.location.href = "../signin"
                                                }
                                            })

                                            has_been_followed.addEventListener('click', function() {
                                                if (localStorage.getItem("_0_n")) {
                                                    has_been_followed.style.display = 'none';
                                                    follow.style.display = 'block';

                                                    function stop_following(token, username) {
                                                        const xhr = new XMLHttpRequest();

                                                        // data
                                                        const datax = new URLSearchParams();
                                                        datax.append('token', token);
                                                        datax.append('username', username);

                                                        xhr.onreadystatechange = function() {
                                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                                if (xhr.status === 200) {
                                                                    const result = JSON.parse(xhr.responseText);
                                                                    if (result.status === 'success') {
                                                                        followers.innerText = result.number_of_followers;
                                                                    } else {
                                                                        console.error(result.message);
                                                                        follow.style.display = 'none';
                                                                        has_been_followed.style.display = 'block';
                                                                    }
                                                                } else {
                                                                    console.error(xhr.status);
                                                                }
                                                            }
                                                        };

                                                        xhr.open('POST', "../stop_following.php");
                                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                                        xhr.send(datax);
                                                    }

                                                    stop_following(localStorage.getItem("_0_n"), query_data);



                                                } else {
                                                    window.location.href = "../signin"
                                                }
                                            })

                                        }

                                    } else {
                                        // akun salah

                                        window.location.replace("../signin")
                                    }
                                }
                            };


                            xhr.send('token=' + encodeURIComponent(localStorage.getItem("_0_n")));
                        } else {
                            // tanpa akun
                            navbar_n.style.display = "flex"
                            follow.style.display = "block";
                            buttonContainer.style.display = "flex"

                            follow.addEventListener('click', function() {
                                window.location.href = "../signin"
                            })
                            has_been_followed.addEventListener('click', function() {
                                window.location.href = "../signin"
                            })
                        }
                        // akhir cek




                        let start_index = 0;
                        let end_of_data = 0;

                        // tampilkan data sesuai kebutuhan
                        const newData = async () => {
                            try {
                                const request_status_data = {
                                    username: encodeURIComponent(encrypt(query_data, 71)),
                                    start_index: start_index,
                                };

                                // console.log(request_status_data);

                                const ress = await fetch("../profile_data.php", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify(request_status_data),
                                });

                                if (!ress.ok) {
                                    throw new Error('error');
                                }

                                const data = await ress.json();

                                if (data.all > 0) {
                                    setTimeout(() => {
                                        random_reply.style.display = 'block';
                                        emptyData.style.display = 'none';
                                        loading_section.style.display = "none";
                                        document.body.style.overflow = 'auto';
                                        dataContainer.setAttribute("class", "showData");
                                        profile_section.style.display = 'grid';
                                        load_data.style.display = 'flex';

                                    }, 1);

                                    end_of_data = data.all;

                                    for (let i = 0; i < Object.keys(data.status).length; i++) {
                                        const statusKey = Object.keys(data.status)[i];
                                        const status = data.status[statusKey];
                                        postCtr(name_data, status.caption, status.date, status.id, data.user.verification, data.user.id, status.reply_count);
                                    }

                                    start_index += 12;
                                } else {
                                    clearInterval(view_data)
                                    setTimeout(function() {
                                        load_data.style.display = 'none';
                                    }, 200)

                                    setTimeout(() => {
                                        buttonContainer.style.width = "90%"
                                        follow.style.width = "70%";
                                        follow.style.maxWidth = "150px"
                                        has_been_followed.style.width = "100%";
                                        has_been_followed.style.maxWidth = "150px"
                                        loading_section.style.display = "none";
                                        dataContainer.style.display = 'none';
                                        document.body.style.overflow = 'auto';
                                        profile_section.style.display = 'grid';
                                        emptyData.style.display = 'flex';

                                    }, 1);
                                }
                            } catch (e) {
                                console.error(e);
                            }
                        };

                        // sedikit demi sedikit
                        let view_data = setInterval(() => {
                            if (start_index <= end_of_data) {
                                const dataContainerBottom = dataContainer.getBoundingClientRect().bottom;

                                if (dataContainerBottom < window.innerHeight) {
                                    newData();
                                }

                            } else {
                                // data habis
                                clearInterval(view_data)
                                setTimeout(function() {
                                    load_data.style.visibility = 'hidden';
                                }, 200)
                            }
                        }, 400);



                        let name_data = decrypt(data.user.username, 71)
                        senderName.innerText = decrypt(data.user.username, 71).length > 9 ? decrypt(data.user.username, 71).slice(0, 9) + "..." : decrypt(data.user.username, 71)
                        name.innerText = name_data
                        bio.innerText = data.user.bio.trim()
                        if (data.user.verification) {
                            vrf.style.display = 'block'
                        }

                        // data postingan
                        // if (Object.keys(data.status).length > 0) {

                        //     setTimeout(function() {

                        //         emptyData.style.display = 'none';
                        //         loading_section.style.display = "none";
                        //         document.body.style.overflow = 'auto';
                        //         dataContainer.setAttribute("class", "showData");
                        //         profile_section.style.display = 'grid'

                        //     }, 100);

                        //     for (let i = Object.keys(data.status).length - 1; i >= 0; i--) {
                        //         const k = Object.keys(data.status)[i];
                        //         const status = data.status[k];
                        //         //postCtr(name_data, status.caption, ago(status.date), status.id, data.user.verification, data.user.id);
                        //     }

                        // } else {

                        //     setTimeout(function() {
                        //         loading_section.style.display = "none"
                        //         dataContainer.style.display = 'none';
                        //         document.body.style.overflow = 'auto';
                        //         profile_section.style.display = 'grid'
                        //         emptyData.style.display = 'flex';
                        //     }, 100);
                        // }



                    } else {
                        window.location.replace("../")
                    }

                })
                .catch(error => {
                    console.error(error);
                    window.location.replace("../")
                });
        }
    </script>
</body>

</html>
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


$messages = "../databases/messages.json";
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id)) {
    die("id tidak valid");
}

$content = file_get_contents($messages);
$data = json_decode($content, true);

// cari data dengan id
$res = null;
foreach ($data as $obj) {
    if ($obj['id'] == $id) {
        $res = $obj;
        break;
    }
}

// cek username
$res = null;
foreach ($data as $obj) {
    if ($obj['id'] == $id) {
        $res = $obj;
        break;
    }
}

// Cek apakah data sudah ditemukan
if ($res) {
    $users = "../databases/users.json";
    $u_cntn = file_get_contents($users);
    $users_data = json_decode($u_cntn, true);

    $user_data = null;
    foreach ($users_data as $user) {
        if ($user['id'] == $res['sender_id']) {
            $user_data = $user;
            break;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $res['caption']; ?> - Anomuge</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="description" content="Kirimi saya pesan anonim, dan tunggu balasannya.">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icon.png">
    <meta property="og:title" content="<?php echo $res['caption']; ?>">
    <meta property="og:description" content="Kirimi saya pesan anonim, dan tunggu balasannya.">
    <meta property="og:image" content="../assets/anomuge.png">
    <link rel="manifest" href="../manifest.json">


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap');

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

        ::selection {
            background-color: #5f5f5f;
        }

        .open {
            color: #1D9BF0;
            cursor: default;
            border-radius: 2px;
        }

        .open:active {
            background-color: #053758;

        }







        #reply::-webkit-scrollbar-thumb {
            background-color: #4b4b4b;
        }

        #reply::-webkit-scrollbar-track {
            background-color: transparent;
        }

        #loading {
            display: block;
            height: 92vh;
        }


        #main {
            display: flex;
            justify-content: center;
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
            display: flex;
            user-select: none;
            align-items: center;
            z-index: 5;
            color: #E7E9EA;
            will-change: transform;
        }


        .bubble {
            background-color: #2a2a31;
            border-radius: 6px;
            margin: 35px auto;
            width: 100%;
            max-width: 600px;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }


        #pseudonym-box-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 6px;
            width: 90%;
            height: 45px;
            background-color: #2a2a31;
            padding: 0 10px;

        }

        #pseudonym-box {
            width: 100%;
            background-color: transparent;
            font-size: 18.5px;
            color: #E7E9EA;
            outline: none;
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

        .profile-container {
            padding: 12px;
            border-bottom: 1px solid #5d6166;
        }

        .profile-picture {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            user-select: none;
            display: none;
        }

        .post-data {
            height: 2.5em;
            width: 2.5em;
            cursor: unset;
            background-color: #E7E9EA;
            padding: 4px 5px 4px 6px;
            background-color: transparent;
            border-radius: 70%;
        }

        .post-data:active {
            background-color: rgb(61, 61, 61);
        }

        .post-data-disabled {
            height: 2.5em;
            width: 2.5em;
            cursor: unset;
            padding: 4px 5px 4px 6px;
            background-color: transparent;
            border-radius: 70%;
            color: #757575;
        }

        .save {
            font-size: 21px;
            cursor: unset;
            color: #E7E9EA;
            padding: 7px 9px;
            background-color: transparent;
            border-radius: 70%;
            display: block;
        }

        .save:active {
            background-color: rgb(71, 71, 71);
        }

        .save-disabled {
            font-size: 21px;
            cursor: unset;
            padding: 4px 5px 4px 6px;
            background-color: transparent;
            border-radius: 70%;
            color: #757575;
            display: none;
        }

        #pc,
        #mobile {
            padding: 0 12px;
        }

        #reply {
            padding: 7px;
            background-color: transparent;
            outline: none;
            width: 100%;
            height: 100%;
            resize: none !important;
            color: #E7E9EA;
            font-size: 19px;
            line-height: 1.6rem;
            text-decoration: none;
            transition: opacity 0.6s ease-in-out;
        }

        #reply::placeholder {
            color: #929292;
        }

        #reply::selection {
            background-color: rgb(78, 78, 78);
            color: white;
        }

        #pseudonym-container {
            width: 100%;
            min-height: 47px;
            text-align: center;
            display: flex;
            justify-content: center;
            padding: 1px 12px 0 12px;
            user-select: none;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        .pseudonym {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #a7aeb6;
            font-size: 17px;
        }

        #pseudonym {
            font-weight: 600;
            color: #E7E9EA;
        }

        #data-container {
            max-width: 600px;
        }

        .user-information {
            margin: 0 0 0 12px;
            user-select: none;
        }

        h1.username {
            font-weight: bold;
            font-size: 1.2rem;
        }

        p.posting-date {
            color: #949aa1;
        }


        .caption-container {
            padding: 20px 25px;

        }


        .message {
            font-size: 19px;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6rem;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        .input-container {
            display: flex;
            background-color: rgb(31, 32, 37);
            border-radius: 0 0 6px 6px;
            padding: 12px;
        }

        .message::selection {
            background-color: rgb(81, 81, 81);
            color: rgb(255, 255, 255);
        }

        .input-container::selection {
            background-color: rgb(68, 68, 68);
            color: rgb(255, 255, 255);
        }





        /*pc device*/
        @media only screen and (min-width: 765px) {

            body {
                display: flex;
                overflow: hidden;
            }

            #profile-name {
                cursor: pointer;
            }


            #main {
                height: 100vh;
                overflow: auto;
                padding-top: 7vh;
            }

            #data-container {
                width: 80%;
                margin-top: 70px;
                max-width: 600px;
            }


            #main {
                overflow: auto;
                scrollbar-width: thin;
                width: 100%;

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

            #pc-navb {
                padding-left: 23px;
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

            #mobile-navb {
                display: none;

            }

            #page-button-container {
                border-bottom: 0.2px solid rgb(47, 51, 54);
                padding: 0 0 10px 0;
            }

            #copyright {
                color: #717171;
                text-align: center;
                margin: 17px 0;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
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

            .button-container {
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

            /* pupup button y */

            .button-popup-y {
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
                max-width: 400px;
                transition: opacity 0.4s ease-in-out;
            }



            .info-container {
                padding: 19px 12px 12px 12px;
                color: #E7E9EA;
            }


            .button-container-y {
                border-top: 0.5px solid #3A3A3A;
            }

            .popup-button {
                width: 100%;
                padding: 12.5px 0;
                color: #1D9BF0;
                font-size: 16px;
                font-weight: bold;
                white-space: nowrap;
                overflow: hidden;
                cursor: unset;
            }

            .button-a {
                border-bottom: 0.5px solid #3A3A3A;

            }


            .button-a:hover {
                background-color: #3A3A3A;

            }

            .button-b:hover {
                background-color: #3A3A3A;
                border-radius: 0 0 9px 9px;
            }

            /* end */

            #change-pseudonym {
                cursor: pointer;
            }

            #change-pseudonym:hover {
                color: rgb(164, 164, 164);
            }




            .ic-click {
                font-size: 24px;
                cursor: pointer;
                padding: 8px 9px;
                background-color: transparent;
                border-radius: 70%;
            }

            .ic-click:hover {
                background-color: rgb(61, 61, 61);
            }

            .ic-click-2 {
                height: 2.5em;
                width: 2.5em;
                cursor: pointer;
                padding: 4px 5px 4px 6px;
                background-color: transparent;
                border-radius: 70%;
            }

            .ic-click-2:hover {
                background-color: rgb(61, 61, 61);
            }

            .post-data {
                height: 2.5em;
                width: 2.5em;
                cursor: pointer;
                background-color: #E7E9EA;
                padding: 4px 5px 4px 6px;
                background-color: transparent;
                border-radius: 70%;
            }

            .post-data:hover {
                background-color: rgb(61, 61, 61);
            }

            .post-data-disabled {
                height: 2.5em;
                width: 2.5em;
                cursor: unset;
                padding: 4px 5px 4px 6px;
                background-color: transparent;
                border-radius: 70%;
                color: #757575;
            }

            .save {
                font-size: 21px;
                cursor: pointer;
                color: #E7E9EA;
                padding: 7px 9px;
                background-color: transparent;
                border-radius: 70%;
                display: block;
            }

            .save:hover {
                background-color: rgb(71, 71, 71);
            }

            .save-disabled {
                font-size: 21px;
                cursor: unset;
                padding: 4px 5px 4px 6px;
                background-color: transparent;
                border-radius: 70%;
                color: #757575;
                display: none;
            }



            .container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 75vw;
                margin: 0 auto;
                height: 100%;
                padding: 0 12px;
                background-color: #414141;
                border-radius: 15px;
                color: #E7E9EA;
                cursor: unset;
                user-select: none;
            }

            .post-container {
                margin-top: 17px;

            }

            #pc {
                display: block;
            }

            #mobile {
                display: none;
            }


            #post-button {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 40vw;
                height: 50px;
                border-radius: 6px;
                margin-top: 10px;
                padding: 12px;
                background-color: #1D9BF0;
                color: black;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 19px;
                font-weight: 600;
            }

            /*popup */
            .popup {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                width: 24vw;
                height: 15vw;
                transform: translate(-50%, -50%);
                padding: 19px;
                background-color: rgb(42, 42, 42);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
                border-radius: 7px;
                z-index: 15;
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

            /* Loading */

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

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 9.5px;
                margin: 2px 6px 0 6px;
                color: black;
                border-radius: 50%;
            }

            .bubble {
                min-width: 40vw;
            }

            .open {
                cursor: pointer;
            }


            .i {
                margin-top: 12%;
            }

            .create_a_status {
                width: 80%;
                max-width: 200px;
                background-color: white;
                padding: 7px;
                color: black;
                font-size: 17px;
                border-radius: 20px;
                font-weight: 550;
                font-family: Arial, Helvetica, sans-serif;
                user-select: none;
            }

            .create_a_status:hover {
                background-color: #979797;
            }

            .sg {
                color: #adb3b6;
                font-family: Arial, Helvetica, sans-serif;
                text-align: center;
                margin-top: 20px;
                font-size: 15px;
                user-select: none;
                width: 300px;
            }
        }

        /*mobile device*/
        @media only screen and (max-width: 765px) {

            body {
                overflow: auto;
                height: 100vh;
            }

            #main {
                min-height: 90vh;
                overflow: hidden;
                padding-top: 30%;
                /*Firefox */
                scrollbar-width: thin;
                scrollbar-color: transparent transparent;

            }


            .i {
                margin-top: 30%;
            }

            .create_a_status {
                width: 80%;
                max-width: 300px;
                background-color: white;
                padding: 7px;
                color: black;
                font-size: 17px;
                border-radius: 20px;
                font-weight: 550;
                font-family: Arial, Helvetica, sans-serif;
                user-select: none;
                cursor: unset;
            }

            .create_a_status:active {
                background-color: #979797;
            }

            .sg {
                color: #adb3b6;
                font-family: Arial, Helvetica, sans-serif;
                text-align: center;
                margin-top: 20px;
                font-size: 15px;
                user-select: none;
                width: 300px;
            }


            /* Chrome dan Safari */
            #main::-webkit-scrollbar {
                width: 0;
            }

            /* Firefox */
            #main::-moz-scrollbar {
                display: none;
            }


            #sidebar {
                display: none;
            }

            .bubble {
                width: 100%;
            }

            #mobile-navb {
                padding: 2em 14px;
                height: 59.5px;
            }

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 10px;
                margin: 0 6px;
                color: black;
                border-radius: 50%;
            }



            #data-container {
                margin-top: 110px;
                width: 90vw;
            }

            .post-container {
                display: block;
                margin-top: 17px;
                padding: 0 19px;
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

            .button-container {
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

            /* vertical */

            /* pupup button y */

            .button-popup-y {
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

            .button-container-y {
                border-top: 0.5px solid #3A3A3A;
            }

            .popup-button {
                width: 100%;
                padding: 12.5px 0;
                color: #1D9BF0;
                font-size: 16px;
                font-weight: bold;
                white-space: nowrap;
                overflow: hidden;
                cursor: unset;
            }

            .button-a {
                border-bottom: 0.5px solid #3A3A3A;

            }


            .button-a:active {
                background-color: #3A3A3A;

            }

            .button-b:active {
                background-color: #3A3A3A;
                border-radius: 0 0 9px 9px;
            }

            /* end */


            .ic-click {
                font-size: 24px;
                cursor: unset;
                padding: 8px 9px;
                background-color: transparent;
                border-radius: 70%;
            }

            .ic-click:active {
                background-color: rgb(61, 61, 61);
            }

            .ic-click-2 {
                height: 2.5em;
                width: 2.5em;
                cursor: unset;
                padding: 4px 5px 4px 6px;
                background-color: transparent;
                border-radius: 70%;
            }

            .ic-click-2:active {
                background-color: rgb(61, 61, 61);
            }



            #pc-navb {
                display: none;

            }


            #post-button {
                display: none;

            }

            #pc {
                display: none;
            }

            #mobile {
                display: block;
            }


            /*popup */
            .popup {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                width: 50%;
                height: 17%;
                transform: translate(-50%, -50%);
                padding: 19px;
                background-color: rgb(42, 42, 42);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
                border-radius: 6px;
                z-index: 15;
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

            /* Loading */

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
        }

        /* max width 1210 */
        @media screen and (max-width: 1210px) {

            #main {
                padding: 7vh 30px 0 30px;
            }

            #sidebar {
                width: 77px;
            }

            .page-name {
                display: none;
            }

            #copyright {
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

        /* lebih kecil dari 500 */
        @media screen and (max-width: 500px) {
            #main {
                padding: 0 7px;
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
                <a href="../profile" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-user"></i>
                    <p class="page-name">Profil</p>
                </a>
            </li>
            <li>
                <a href="../followed" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-asterisk"></i>
                    <p class="page-name">Status</p>
                </a>
            </li>
            <li>
                <a href="../messages" class="page-button flex white  is-here" oncontextmenu="return false;">
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
        <nav id="mobile-navb">
            <span style="align-items: center;" class="flex">
                <i onclick="window.history.back()" class="ic-click fas fa-arrow-left text-xl"></i>
                <h1 id="sender" style="margin-left: 5px; font-family: Arial, Helvetica, sans-serif;" class="font-bold text-xl"><?php echo (strlen(decrypt($user_data["username"], 71)) > 9) ? substr(decrypt($user_data["username"], 71), 0, 9) . "..." : decrypt($user_data["username"], 71); ?></h1>
            </span>
            <span style="align-items: center;" class="flex">
                <i style="margin-right:3px;" onclick="window.location.href='../messages'" class="ic-click fas fa-comment"></i>
                <svg id="post-data-on-mobile" class="post-data-disabled" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M8.1 39.1q-.75.3-1.425-.125T6 37.75V28.9q0-.55.325-.95.325-.4.825-.5L21.1 24 7.15 20.45q-.5-.1-.825-.5Q6 19.55 6 19v-8.75q0-.8.675-1.225Q7.35 8.6 8.1 8.9l32.6 13.7q.9.4.9 1.4 0 1-.9 1.4Z" />
                </svg>
            </span>
        </nav>
        <nav id="pc-navb">
            <span style="align-items: center;" class="flex">
                <h1 style="font-family: Poppins, Arial, Helvetica, sans-serif; font-size: 23px;" class="white font-bold">
                    Anomuge</h1>
            </span>
            <span style="align-items: center;" class="flex">
                <i style="margin-right:5px;" onclick="window.location.href='../messages'" class="ic-click fas fa-comment"></i>
                <svg id="post-data-on-desktop" class="post-data-disabled" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M8.1 39.1q-.75.3-1.425-.125T6 37.75V28.9q0-.55.325-.95.325-.4.825-.5L21.1 24 7.15 20.45q-.5-.1-.825-.5Q6 19.55 6 19v-8.75q0-.8.675-1.225Q7.35 8.6 8.1 8.9l32.6 13.7q.9.4.9 1.4 0 1-.9 1.4Z" />
                </svg>
            </span>
        </nav>
        <section style="display: none;" id="data-container">
            <section id="pseudonym-container" class="text-center">
                <p id="data-information" class="pseudonym">Nama samaran anda <span style="margin:0 6px;" id="pseudonym"></span>
                    <i id="change-pseudonym" class="ml-1 text-xl white fas fa-pencil-alt"></i>
                </p>
                <div style="display: none;" id="pseudonym-box-container" class="shadow">
                    <input type="text" name="username" id="pseudonym-box" placeholder="Nama samaran" autocomplete="off" autofocus>
                    <i id="save" class="save-disabled fas fa-save"></i>

                </div>

            </section>
            <section class="post-container flex justify-center">
                <div class="bubble shadow">
                    <div style="justify-content: space-between;" class="profile-container flex">
                        <div class="profile">
                            <img class="profile-picture" alt="icon">
                            <div class="user-information">
                                <span style="display: flex; align-items:center;">
                                    <h1 id="profile-name" class="username white"></h1>
                                    <i id="verification" style="display: none;" class="verification fas fa-check"></i>
                                </span>

                                <p id="posting-date" class="posting-date"></p>
                            </div>
                        </div>

                    </div>
                    <div class="caption-container">
                        <p id="caption-data" class="message white"></p>
                    </div>

                    <div class="input-container bg-black">
                        <textarea name="text" id="reply" oninput="this.value=this.value.charAt(0).toUpperCase()+this.value.slice(1);sizee(this)" placeholder="Balasan anda" autofocus></textarea>
                    </div>
                </div>
            </section>
            <div id="i" style="display: none; place-items: center;" class="i">
                <button id="create_a_status" class="create_a_status" type="submit">Buat status</button>
                <p class="sg">Buat status anda sendiri dan biarkan orang lain membalasnya secara anonim</p>
            </div>
        </section>

        <section id="loading">
            <div style="display: flex; justify-content: center; align-items: center; height: 80%; width: 100%;" class="loading-container">
                <div class="loading"></div>
            </div>
        </section>


        <div id="popup" class="popup">
            <div style="display: flex; justify-content: center; align-items: center; height: 100%; width: 100%;" class="loading-container">
                <div class="loading"></div>
            </div>
        </div>
        <div id="backdrop" class="backdrop"></div>
        <!-- horizontal -->
        <div id="button-popup" class="button-popup">
            <div class="info-container text-center">
                <h1 id="popupTitle" class="font-bold text-xl"></h1>
                <p id="msgg" class="info-message"></p>
            </div>
            <div class="button-container flex">
                <button id="leftButton" class="popup-button left-button"></button>
                <button id="rightButton" class="popup-button right-button"></button>
            </div>
        </div>
        <!-- vertical -->
        <div id="button-popup-y" class="button-popup-y">
            <div class="info-container text-center">
                <h1 id="popupTitle-y" class="font-bold text-xl"></h1>
                <p id="msgg-y" class="info-message"></p>
            </div>
            <div class="button-container-y">
                <button id="button_a" class="popup-button button-a"></button>
                <button id="button_b" class="popup-button button-b"></button>
            </div>
        </div>
    </section>
    <?php
    // buat anonymous id
    function create_id($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomStringResults = '';
        for ($i = 0; $i < $length; $i++) {
            $randomStringResults .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomStringResults;
    }

    function random_anonymous_id($length, $previous_data)
    {
        do {
            $anonymousId = create_id($length);
        } while (in_array($anonymousId, $previous_data));

        return $anonymousId;
    }

    $file = '../databases/messages.json';
    $data = file_get_contents($file);
    $data_ = json_decode($data, true);
    $previous_data = array_column($data_, 'anonymousId');
    $a_id = random_anonymous_id(20, $previous_data);
    ?>

    <?php echo '<script>const id_data = "' . (isset($_GET['id']) ? $_GET['id'] : '') . '";</script>'; ?>


    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../sw.js')
                .then((reg) => {
                    // console.log(reg.scope);
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
        if (!localStorage.getItem("9_nn")) {
            const anonymousID = "<?php echo $a_id; ?>"
            localStorage.setItem('9_nn', anonymousID)
        }

        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
            document.body.style.userSelect = "none";
        }



        // element
        const main = document.getElementById("main")
        const postButtonOnMobile = document.getElementById("post-data-on-mobile");
        const postButtonOnDesktop = document.getElementById("post-data-on-desktop")
        const reply = document.getElementById("reply");
        const pseudonymBox = document.getElementById("pseudonym-box");
        const pseoudonymBoxContainer = document.getElementById("pseudonym-box-container");
        const save = document.getElementById("save");
        const dataInformation = document.getElementById("data-information");
        const pseoudonym = document.getElementById("pseudonym");
        const changePseudonym = document.getElementById("change-pseudonym");
        const captionData = document.getElementById("caption-data");
        const profile_name = document.getElementById("profile-name");
        const posting_date = document.getElementById("posting-date");
        const backdrop = document.getElementById("backdrop");
        const loadingPopup = document.getElementById("popup");
        const buttonPopupY = document.getElementById("button-popup-y");
        const popupTitleY = document.getElementById("popupTitle-y");
        const msggY = document.getElementById("msgg-y");
        const button_a = document.getElementById("button_a");
        const button_b = document.getElementById("button_b");
        const verification = document.getElementById("verification");
        const sender = document.getElementById("sender");
        const loading_section = document.getElementById("loading");
        const dataContainer = document.getElementById("data-container");
        const create_a_status = document.getElementById("create_a_status");
        const new_user_information = document.getElementById("i")

        create_a_status.addEventListener("click", function(e) {
            window.location.href = "../post"
        })

        const copyright = document.getElementById("copyright");
        copyright.innerText = `© ${new Date().getFullYear()} Wahyuna`;

        if (!localStorage.getItem("_0_n")) {
            new_user_information.style.display = "grid";

        }



        const chrt = (char, key) => /[a-zA-Z]/.test(char) ? String.fromCharCode((char.charCodeAt() - (/[A-Z]/.test(char) ? 65 : 97) + key + 26) % 26 + (/[A-Z]/.test(char) ? 65 : 97)) : char;
        const text_to_base64 = (text) => btoa(text);
        const base64_to_text = (base64) => atob(base64);
        const encrypt = (text, key) => text_to_base64([...text].map(char => chrt(char, key)).join(''));
        const decrypt = (text, key) => [...base64_to_text(text)].map(char => chrt(char, (26 - key) % 26)).join('');




        // reply on focus 
        function rep() {
            if (localStorage.getItem("x_n")) {
                pseoudonymBoxContainer.style.display = "none"
                dataInformation.style.display = "block"
            } else {
                pseudonymBox.focus()
            }
        }

        reply.addEventListener("focus", function() {
            rep()
        })

        function show_loading() {
            loadingPopup.style.display = 'block';
            backdrop.style.display = 'block';
            document.body.classList.add('no-scroll');
        }

        function hide_loading() {
            loadingPopup.style.display = 'none';
            backdrop.style.display = 'none';
            document.body.classList.remove('no-scroll');
        }

        // vertical
        function popup_y(title, msg, a_buttonName, b_buttonName, a_buttonFunction, b_buttonFunction) {
            document.body.style.overflow = 'hidden';
            backdrop.style.display = 'block';
            buttonPopupY.style.display = 'block';

            popupTitleY.innerText = title;
            msggY.innerText = msg;
            button_a.innerText = a_buttonName;
            button_b.innerText = b_buttonName;
            button_a.addEventListener("click", function(event) {
                backdrop.style.display = 'none';
                buttonPopupY.style.display = 'none';
                a_buttonFunction();
                document.body.style.overflow = 'auto';
            })
            button_b.addEventListener("click", function(event) {
                backdrop.style.display = 'none';
                buttonPopupY.style.display = 'none';
                b_buttonFunction();
                document.body.style.overflow = 'auto';
            });
        }



        all_data = null;



        const ago = timestamp => {
            const t = new Date() - new Date(timestamp);
            const s = Math.floor(t / 1000);
            const m = Math.floor(s / 60);
            const h = Math.floor(m / 60);
            const d = Math.floor(h / 24);
            const w = Math.floor(d / 7);
            const mn = Math.floor(w / 4);
            const y = Math.floor(mn / 12);

            return t < 1000 ? 'baru saja' : s < 60 ? `${s} detik yang lalu` : m < 60 ? `${m} menit yang lalu` : h < 24 ? `${h} jam yang lalu` : d < 7 ? `${d} hari yang lalu` : w < 4 ? `${w} minggu yang lalu` : mn < 12 ? `${mn} bulan yang lalu` : `${y} tahun yang lalu`;
        };




        function sizee(e) {
            e.style.height = 'auto';
            e.style.height = (e.scrollHeight) + 'px';

            //tinggi 50%
            const maxHeight = Math.floor((window.innerHeight || document.documentElement.clientHeight) * 0.4);

            // max height
            if (e.scrollHeight > maxHeight) {
                e.style.height = maxHeight + 'px';
            }

            main.scrollTop = main.scrollHeight
        }

        document.addEventListener("DOMContentLoaded", function() {
            // pseoudonym on input 
            pseudonymBox.addEventListener("input", function() {
                if (pseudonymBox.value.trim().length > 0) {
                    save.classList.remove("save-disabled")
                    save.classList.add("save");
                } else {
                    save.classList.remove("save");
                    save.classList.add("save-disabled");
                }
            })




            // reply on input 
            reply.addEventListener("input", () => {
                if (reply.value.trim().length > 0 && localStorage.getItem("x_n")) {
                    postButtonOnDesktop.classList.remove("post-data-disabled");
                    postButtonOnMobile.classList.remove("post-data-disabled");
                    postButtonOnDesktop.classList.add("post-data");
                    postButtonOnMobile.classList.add("post-data")
                } else {
                    postButtonOnDesktop.classList.remove("post-data");
                    postButtonOnMobile.classList.remove("post-data");
                    postButtonOnDesktop.classList.add("post-data-disabled");
                    postButtonOnMobile.classList.add("post-data-disabled");


                }
            });

            pseudonymBox.addEventListener("input", () => {
                // aturan pseudonym
                pseudonymBox.value = pseudonymBox.value.slice(0, 35);
                pseudonymBox.value = pseudonymBox.value.replace(/\b\w/g, (x) => x.toUpperCase()).replaceAll("ℹ", "i").replace(/[^\p{L}\p{N}\s\u0600-\u06FF\uAC00-\uD7A3\u3040-\u309F\u30A0-\u30FF\u4E00-\u9FFF]/gu, '').replaceAll("  ", " ");
                pseudonymBox.value = pseudonymBox.value.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

            })
        });

        // ambil data postingan
        fetch('../get_post_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id_data}`
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.sender_id && data.profile.id) {
                    profile_name.addEventListener("click", function() {
                        window.location.href = "../profile/?n=@" + decrypt(data.profile.username, 71).trim();
                    })




                    document.body.style.overflow = 'auto';
                    sender.innerText = decrypt(data.profile.username, 71).length > 9 ? decrypt(data.profile.username, 71).slice(0, 9) + "..." : decrypt(data.profile.username, 71)

                    // pendeteksian link
                    function random_clid(length) {
                        var result = '';
                        var strr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

                        for (var i = 0; i < length; i++) {
                            result += strr.charAt(Math.floor(Math.random() * strr.length));
                        }

                        return result;
                    }

                    captionData.innerHTML = data.caption.replace(/(?:^|\s)(https?:\/\/)?(?![.]{3})([^\s,.]+(\.[^\s,.]+)+[^\s,]*)(?:$|\s|,)/ig, (_, prt, url) => {
                        if (url.toLowerCase() !== '...') {
                            return `<a href="${(prt ? prt.toLowerCase() : 'http://') + url.toLowerCase()}${url.includes('?') ? '&' : '?'}anomuge_clid=${random_clid(25)}" class="open" ${'manifest' in document.createElement('link') ? '' : 'target="_blank"'} oncontextmenu="navigator.clipboard.writeText(this.href).then(() => true).catch(err => false); return false;">${url}</a>`;
                        } else {
                            return _;
                        }
                    });




                    profile_name.innerText = decrypt(data.profile.username, 71).trim();
                    if (data.profile.verification) {
                        verification.style.display = "block"
                    }
                    // awal 
                    posting_date.innerText = ago(data.date)
                    // interval setiap 1 detik
                    setInterval(function() {
                        posting_date.innerText = ago(data.date)
                    }, 1000)

                    setTimeout(function() {
                        loading_section.style.display = "none";
                        dataContainer.style.display = "block";
                    }, 100)







                    // jika nama anonim sudah ada 
                    if (localStorage.getItem("x_n")) {
                        pseoudonym.innerText = decrypt(localStorage.getItem("x_n"), 71).trim();
                        pseoudonymBoxContainer.style.display = "none"
                        dataInformation.style.display = "block"

                    } else {
                        dataInformation.style.display = "none"
                        pseoudonymBoxContainer.style.display = "flex"
                    }

                    // simpan nama samaran

                    save.addEventListener("click", function() {
                        localStorage.setItem("x_n", encrypt(pseudonymBox.value.trim(), 71))
                        pseoudonym.innerText = pseudonymBox.value.trim();
                        pseoudonymBoxContainer.style.display = "none"
                        dataInformation.style.display = "block"
                        save.classList.remove("save");
                        save.classList.add("save-disabled");
                        pseudonymBox.value = ""
                        reply.focus()


                        // tombol send
                        if (reply.value.trim().length > 0 && localStorage.getItem("x_n")) {
                            postButtonOnDesktop.classList.remove("post-data-disabled");
                            postButtonOnMobile.classList.remove("post-data-disabled");
                            postButtonOnDesktop.classList.add("post-data");
                            postButtonOnMobile.classList.add("post-data")
                        } else {
                            postButtonOnDesktop.classList.remove("post-data");
                            postButtonOnMobile.classList.remove("post-data");
                            postButtonOnDesktop.classList.add("post-data-disabled");
                            postButtonOnMobile.classList.add("post-data-disabled");
                        }
                    });

                    // ganti nama samaran
                    changePseudonym.addEventListener("click", function() {
                        dataInformation.style.display = "none"
                        pseoudonymBoxContainer.style.display = "flex"
                        pseudonymBox.focus()
                    })






                    function postData() {
                        if (reply.value.trim() && localStorage.getItem("x_n")) {
                            const reply_data = {
                                sendto: data.profile.id,
                                replyto: data.id,
                                anonymousId: localStorage.getItem("9_nn"),
                                pseudonym: localStorage.getItem('x_n'),
                                username: localStorage.getItem('rk_4t9') || "",
                                message: reply.value.trim(),
                                caption: data.caption.trim(),
                            };

                            // Kirim data ke server
                            fetch('../reply_be.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify(reply_data),
                                })
                                .then(res => {
                                    if (!res.ok) {
                                        throw new Error(res.status);
                                    }
                                    return res.json();
                                })
                                .then(output => {
                                    if (output.status) {
                                        show_loading()
                                        setTimeout(function() {
                                            hide_loading()
                                            setTimeout(function() {

                                                reply.value = '';
                                                popup_y("Balasan anda telah terkirim ke " + decrypt(data.profile.username, 71).trim(), `Silahkan cek di obrolan untuk melihat balasan selanjutnya dari ${decrypt(data.profile.username,71)}.`, "Lihat obrolan", "Nanti", function() {
                                                    window.location.replace("../messages")
                                                }, function() {
                                                    0
                                                })

                                            }, 120)

                                        }, 300)
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        }
                    }


                    postButtonOnDesktop.addEventListener('click', postData);
                    postButtonOnMobile.addEventListener('click', postData);
                } else {
                    window.location.replace("../")
                }
            })
            .catch(error => {
                console.error(error);
                //window.location.reload()
            });
    </script>
</body>

</html>
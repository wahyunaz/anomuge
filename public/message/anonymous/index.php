<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Message - Anomuge</title>
    <link rel="stylesheet" href="../../style.css">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/icon.png">
    <meta property="og:image" content="../../assets/icon.png">
    <link rel="manifest" href="../../manifest.json">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap');

        * {
            font-family: Arial, Helvetica, sans-serif;
            padding: 0;
            margin: 0;
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

        ::selection {
            background-color: #5f5f5f;
        }

        /* #main::-webkit-scrollbar {
            display: none;
        } */



        #main {
            background-color: black;
        }

        #loading {
            display: block;
            height: 92vh;
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

        .open {
            color: #1D9BF0;
            cursor: default;
            border-radius: 2px;
        }

        .open:active {
            background-color: #053758;

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

        #data-container {
            display: grid;
            place-items: center;
        }

        .psoudonym-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: center;
            color: #949aa1;
            margin: 50px 0 0 0;
            user-select: none;
            word-wrap: break-word;
            word-wrap: break-word;
            white-space: normal;
        }

        .psoudonym {
            margin: 0 0 0 7px;
            color: #E7E9EA;
            font-weight: 500;
        }


        .bubble {
            background-color: #2a2a31;
            border-radius: 6px;
            margin: 35px auto;
            width: 100%;
            max-width: 600px;
            word-wrap: break-word;
            white-space: normal;
        }

        .user-information {
            margin: 0 12px;
            user-select: none;
        }

        h1.username {
            font-weight: bold;
            font-size: 1.2rem;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        p.posting-date {
            color: #949aa1;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }


        .his-message-container {
            padding: 20px 25px;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;

        }

        .my-his-message-container {
            padding: 9px 25px;
            margin: 0 15px;
            border-left: 4px solid #1D9BF0;

            border-radius: 9px;
            border: 1px solid #5d6166;
        }

        #my-message-information {
            color: #1D9BF0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: 510;
            user-select: none;
        }

        #my-message {
            margin: 3px 0 0 0;
        }


        .message {
            font-size: 19px;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6rem;
            word-wrap: break-word;
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

        .profile-container {
            padding: 12px;
        }

        .profile-picture {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            user-select: none;
            display: none;
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

        #empty-data {
            margin-top: 12%;
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


        @media only screen and (max-width: 765px) {
            body {
                overflow: hidden;
            }

            #main {
                min-height: 90vh;
                overflow: hidden;
                /*Firefox */
                scrollbar-width: thin;
                scrollbar-color: transparent transparent;

            }


            /* Chrome dan Safari */
            #main::-webkit-scrollbar {
                width: 0;
            }

            /* Firefox */
            #main::-moz-scrollbar {
                display: none;
            }

            #main {
                padding: 0 27px;
            }

            #sidebar {
                display: none;
            }


            .bubble {
                min-width: 60vw;
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


            #mobile-navb {
                padding: 2em 14px;
                display: flex;
            }

            #pc-navb {
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

            .button-popup {
                display: none;
                position: fixed;
                border-radius: 9px;
                width: 80%;
                top: 50%;
                word-wrap: break-word;
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


            .popup-button:active {
                background-color: #3A3A3A;
                border-radius: 0 0 9px 9px;
            }

            /* Loading */

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

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 10px;
                margin: 0 6px;
                color: black;
                border-radius: 50%;
            }


            /* end */
        }

        @media only screen and (min-width: 765px) {

            body {
                display: flex;
                overflow: hidden;

            }


            #main {
                overflow: auto;
                scrollbar-width: thin;
                width: 100%;
                height: 100vh;

            }

            #profile-ctr {
                cursor: pointer;
            }


            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 9.5px;
                margin: 2px 6px 0 6px;
                color: black;
                border-radius: 50%;
            }

            #pc-navb {
                display: flex;
                padding-left: 23px;
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

            #page-button-container {
                border-bottom: 0.2px solid rgb(47, 51, 54);
                padding: 0 0 10px 0;
            }

            .open {
                cursor: pointer;
            }

            .open:hover {
                color: #1b8ad4;
            }

            #copyright {
                color: #717171;
                text-align: center;
                margin: 17px 0;
                font-size: 14px;
            }

            #mobile-navb {
                display: none;
            }

            #data-container {
                padding: 20px;
            }

            .bubble {
                min-width: 40vw;
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



            .post-button:hover {
                background-color: #0d6cab;
            }

            .button-popup {
                display: none;
                position: fixed;
                border-radius: 9px;
                width: 80%;
                top: 50%;
                word-wrap: break-word;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgb(42, 42, 42);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
                font-family: Arial, Helvetica, sans-serif;
                z-index: 15;
                user-select: none;
                max-width: 350px;
                animation: fadeIn 0.3s ease-out;
            }



            .info-container {
                padding: 19px 12px 12px 12px;
                color: #E7E9EA;
            }

            .info-message {
                color: #979797;
                margin: 7px 0;
                padding: 0 12px;
            }

            .button-container {
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



            .popup-button:hover {
                background-color: #3A3A3A;
                border-radius: 0 0 9px 9px;
            }

            /* Loading */

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

            .page-name {
                display: none;
            }

            #page-button {
                text-align: center;
                display: flex;
                justify-content: center;
            }

            #copyright {
                display: none;
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
                <a href="../../" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-home"></i>
                    <p class="page-name">Beranda</p>
                </a>
            </li>
            <li>
                <a href="../../post" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-pencil-alt"></i>
                    <p class="page-name">Posting</p>
                </a>
            </li>
            <li>
                <div onclick="window.location.href = `../../profile/?n=@${decrypt(localStorage.getItem('rk_4t9'),71)}`" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-user"></i>
                    <p class="page-name">Profil</p>
                </div>
            </li>
            <li>
                <a href="../../followed" class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-asterisk"></i>
                    <p class="page-name">Status</p>
                </a>
            </li>
            <li>
                <a href="../../messages" class="page-button flex white is-here" oncontextmenu="return false;">
                    <i class="page-icon fas fa-comment"></i>
                    <p class="page-name">Pesan</p>
                </a>
            </li>
            <li>
                <a href="../../about" class="page-button flex white" oncontextmenu="return false;">
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
                <svg id="post-data-on-desktop" class="post-data-disabled" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M8.1 39.1q-.75.3-1.425-.125T6 37.75V28.9q0-.55.325-.95.325-.4.825-.5L21.1 24 7.15 20.45q-.5-.1-.825-.5Q6 19.55 6 19v-8.75q0-.8.675-1.225Q7.35 8.6 8.1 8.9l32.6 13.7q.9.4.9 1.4 0 1-.9 1.4Z" />
                </svg>
            </span>
        </nav>
        <nav id="mobile-navb" class="bg-black">
            <span class="flex" style="align-items: center;">
                <i class="ic-click fas fa-arrow-left" onclick="history.back()"></i>

                <h1 style="margin-left: 5px;" id="sender-name" class="font-bold text-xl"></h1>
            </span>
            <span style="align-items: center;" class="flex">
                <svg id="post-data-on-mobile" class="post-data-disabled" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M8.1 39.1q-.75.3-1.425-.125T6 37.75V28.9q0-.55.325-.95.325-.4.825-.5L21.1 24 7.15 20.45q-.5-.1-.825-.5Q6 19.55 6 19v-8.75q0-.8.675-1.225Q7.35 8.6 8.1 8.9l32.6 13.7q.9.4.9 1.4 0 1-.9 1.4Z" />
                </svg>
            </span>
        </nav>
        <section style="display: none;" id="data-container">
            <p class="psoudonym-container">Anda sebagai <span id="pseoudonym" class="psoudonym"></span></p>
            <div class="bubble shadow">
                <div style="justify-content: space-between;" class="profile-container flex">
                    <div id="profile-ctr" class="profile">
                        <img class="profile-picture">
                        <div class="user-information">
                            <span style="display: flex; align-items:center">
                                <h1 id="profile-name" class="username white"></h1><i id="verification" style="display: none;" class="verification fas fa-check"></i>
                            </span>

                            <p id="posting-date" class="posting-date"></p>
                        </div>
                    </div>

                </div>
                <div class="my-his-message-container">
                    <p id="my-message-information"></p>
                    <p id="my-message" class="message white"></p>
                </div>
                <div class="his-message-container">
                    <p id="message-him" class="message white"></p>
                </div>

                <div class="input-container bg-black">
                    <textarea name="text" id="reply" oninput="this.value=this.value.charAt(0).toUpperCase()+this.value.slice(1);sizee(this)" placeholder="Balasan anda" autofocus></textarea>
                </div>
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

        <!-- vertical -->
        <div id="button-popup" class="button-popup">
            <div class="info-container text-center">
                <h1 id="popupTitle" class="font-bold text-xl"></h1>
                <p id="msgg" class="info-message"></p>
            </div>
            <div class="button-container">
                <button id="popup-button" class="popup-button"></button>
            </div>
        </div>
    </section>


    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../../sw.js')
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

        const main = document.getElementById("main")
        const reply = document.getElementById("reply");
        const postButtonOnDesktop = document.getElementById("post-data-on-desktop");
        const postButtonOnMobile = document.getElementById("post-data-on-mobile");
        const buttonPopup = document.getElementById("button-popup");
        const popupTitle = document.getElementById("popupTitle");
        const msgg = document.getElementById("msgg");
        const backdrop = document.getElementById("backdrop");
        const popupButton = document.getElementById("popup-button");
        const loading_component = document.getElementById("popup")
        const loading_section = document.getElementById("loading");
        const dataContainer = document.getElementById("data-container");

        const profile_name = document.getElementById("profile-name");
        const posting_date = document.getElementById("posting-date");
        const my_message = document.getElementById("my-message");
        const message_him = document.getElementById("message-him");
        const senderName = document.getElementById("sender-name");
        const myMessageInformation = document.getElementById("my-message-information");
        const verification = document.getElementById("verification");
        const profileCtr = document.getElementById("profile-ctr");
        const pseoudonym = document.getElementById("pseoudonym");

        const copyright = document.getElementById("copyright");
        copyright.innerText = `© ${new Date().getFullYear()} Wahyuna`;




        const chrt = (char, key) => /[a-zA-Z]/.test(char) ? String.fromCharCode((char.charCodeAt() - (/[A-Z]/.test(char) ? 65 : 97) + key + 26) % 26 + (/[A-Z]/.test(char) ? 65 : 97)) : char;
        const text_to_base64 = (text) => btoa(text);
        const base64_to_text = (base64) => atob(base64);
        const encrypt = (text, key) => text_to_base64([...text].map(char => chrt(char, key)).join(''));
        const decrypt = (text, key) => [...base64_to_text(text)].map(char => chrt(char, (26 - key) % 26)).join('');





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

        // reply on input 
        reply.addEventListener("input", () => {
            if (reply.value.trim().length > 0) {
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

        // vertical
        function popup(title, msg, buttonName, buttonFunction) {
            document.body.style.overflow = 'hidden';
            backdrop.style.display = 'block';
            buttonPopup.style.display = 'block';

            popupTitle.innerText = title;
            msgg.innerText = msg;
            popupButton.innerText = buttonName;
            popupButton.addEventListener("click", function(event) {
                backdrop.style.display = 'none';
                buttonPopup.style.display = 'none';
                buttonFunction();
                document.body.style.overflow = 'auto';
            })
        }

        function closeThePopup() {
            // tutup poupup
            setTimeout(function() {
                document.body.style.overflow = 'auto';
                backdrop.style.display = 'none';
                buttonPopup.style.display = 'none';
            }, 90);
        }



        function loading() {
            loading_component.style.display = 'block'
            backdrop.style.display = 'block';
        }

        function close_loading() {
            loading_component.style.display = 'none'
            backdrop.style.display = 'none';
        }


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


        let id_data = new URLSearchParams(window.location.search).get('id');


        if (id_data && localStorage.getItem("9_nn")) {
            const data = {
                id: id_data,
                anonymous_user: localStorage.getItem("9_nn")
            };

            fetch('../../reply_to_anonymous.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(resl => resl.json())
                .then(res => {
                    if (res.success) {
                        console.log(res)
                        if (res.data.profile.verification) {
                            verification.style.display = "block"
                        }
                        if (res.data.send_to_anonymous_user == localStorage.getItem("9_nn")) {
                            pseoudonym.innerText = res.data.his_pseudonym ? decrypt(res.data.his_pseudonym, 71) : decrypt(localStorage.getItem("x_n"), 71)

                            document.title = `Balasan dari ${decrypt(res.data.profile.username, 71)} - Anomuge`


                            senderName.innerText = decrypt(res.data.profile.username, 71).length > 9 ? decrypt(res.data.profile.username, 71).slice(0, 9) + "..." : decrypt(res.data.profile.username, 71)
                            profile_name.innerText = decrypt(res.data.profile.username, 71)
                            posting_date.innerText = ago(res.data.date)
                            setInterval(function() {
                                posting_date.innerText = ago(res.data.date)
                            }, 1000)
                            myMessageInformation.innerText = `Anda${res.data.caption?' - Status':''}`

                            // pendeteksian libk

                            function random_clid(length) {
                                var result = '';
                                var strr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

                                for (var i = 0; i < length; i++) {
                                    result += strr.charAt(Math.floor(Math.random() * strr.length));
                                }

                                return result;
                            }

                            my_message.innerHTML = res.data.message_him.replace(/(?:^|\s)(https?:\/\/)?(?![.]{3})([^\s,.]+(\.[^\s,.]+)+[^\s,]*)(?:$|\s|,)/ig, (_, prt, url) => {
                                if (url.toLowerCase() !== '...') {
                                    return `<a href="${(prt ? prt.toLowerCase() : 'http://') + url.toLowerCase()}${url.includes('?') ? '&' : '?'}anomuge_clid=${random_clid(25)}" class="open" ${'manifest' in document.createElement('link') ? '' : 'target="_blank"'} oncontextmenu="navigator.clipboard.writeText(this.href).then(() => true).catch(err => false); return false;">${url}</a>`;
                                } else {
                                    return _;
                                }
                            });

                            message_him.innerHTML = res.data.my_message.replace(/(?:^|\s)(https?:\/\/)?(?![.]{3})([^\s,.]+(\.[^\s,.]+)+[^\s,]*)(?:$|\s|,)/ig, (_, prt, url) => {
                                if (url.toLowerCase() !== '...') {
                                    return `<a href="${(prt ? prt.toLowerCase() : 'http://') + url.toLowerCase()}${url.includes('?') ? '&' : '?'}anomuge_clid=${random_clid(25)}" class="open" ${'manifest' in document.createElement('link') ? '' : 'target="_blank"'} oncontextmenu="navigator.clipboard.writeText(this.href).then(() => true).catch(err => false); return false;">${url}</a>`;
                                } else {
                                    return _;
                                }
                            });

                            profileCtr.addEventListener("click", function() {
                                window.location.href = "../../profile/?n=@" + decrypt(res.data.profile.username, 71).toLowerCase()
                            })

                            setTimeout(function() {
                                loading_section.style.display = "none";
                                dataContainer.style.display = "block";
                                document.body.style.overflow = 'auto';
                            }, 100)




                            function sendMessage() {
                                loading();
                                var data_from_anonymous = {
                                    sendto: res.data.profile.id,
                                    replyto: res.data.id,
                                    anonymousId: localStorage.getItem("9_nn"),
                                    pseudonym: res.data.his_pseudonym ? res.data.his_pseudonym : localStorage.getItem("x_n"),
                                    username: localStorage.getItem('rk_4t9') || "",
                                    message_him: reply.value.trim(), // message him sebagai pesan saya
                                    my_message: res.data.my_message
                                };

                                // kirim
                                fetch('../../anonymous_user_reply.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify(data_from_anonymous),
                                    })
                                    .then(resp => resp.json())
                                    .then(results => {
                                        setTimeout(function() {
                                            close_loading();
                                            reply.value = ""
                                            setTimeout(function() {
                                                if (results.status) {


                                                    popup("Balasan telah terkirim", "Pesan balasan anda telah terkirim ke " + decrypt(res.data.profile.username, 71), "Oke", function() {

                                                        closeThePopup()
                                                        window.history.back();
                                                    });

                                                } else {
                                                    popup("Balasan gagal dikirim", "Pesan balasan anda gagal dikirim ke " + decrypt(res.data.profile.username, 71), "Oke", function() {

                                                        closeThePopup()
                                                    });
                                                }
                                            }, 120)
                                        }, 300)
                                    })
                                    .catch((error) => {
                                        console.error(error);
                                    });

                            }

                            postButtonOnDesktop.addEventListener('click', function() {
                                sendMessage();
                            })

                            postButtonOnMobile.addEventListener('click', function() {
                                sendMessage();
                            })

                        } else {
                            window.history.back();
                        }
                    } else {
                        console.error(res.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        } else {
            window.history.back();

        }








        // end
    </script>
</body>

</html>
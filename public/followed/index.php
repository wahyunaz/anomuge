<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Status - Anomuge</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta name="description" content="Kirimi mereka pesan anonim">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/icon.png">
    <meta property="og:title" content="Anomuge - People">
    <meta property="og:description" content="Kirimi mereka pesan anonim">
    <meta property="og:image" content="../assets/icon.png">
    <link rel="manifest" href="../manifest.json">
    <style>
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

        ::selection {
            background-color: #5f5f5f;
        }

        .paragraph {
            color: #afafaf;
        }

        .read_more {
            color: #1D9BF0;
            font-family: Arial, Helvetica, sans-serif;
            user-select: none;
        }


        .sug {
            color: #E7E9EA;
            font-size: 20px;
            font-family: Arial, Poppins, 'Helvetica Neue', Helvetica, sans-serif;
            font-weight: 550;
            margin: 0 20px 20px 20px;
        }

        .open {
            color: #1D9BF0;
            cursor: default;
            border-radius: 2px;
        }

        .open:active {
            background-color: #053758;

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



        .bioo {
            font-size: 17px;
            padding: 15px 0 20px 0;
            color: #E7E9EA;
            font-family: Arial, Helvetica, sans-serif;
            word-wrap: break-word;
            user-select: none;
        }

        #has-been-followed {
            padding: 6px 17px;
            font-size: 17px;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #424242;
            color: #E7E9EA;
            font-weight: 530;
            border-radius: 5px;
            display: none;
            user-select: none;
        }


        .done {
            color: white;
            font-size: 14px;
            margin-left: 4px;
        }


        #loading {
            display: block;
            height: 92vh;
        }

        #mobile-footer {
            display: none;
            user-select: none;
        }

        #p-container {
            padding: 10px 0;
            margin: 20px 0;
            overflow: auto;
            white-space: nowrap;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .hideData {
            display: none;
        }

        .announcement-container {
            padding: 0.1px;
            height: 25px;
        }

        .announcement {
            font-size: 14px;
            background-color: #1D9BF0;
            border-radius: 6px 0;
            padding: 2px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 520;
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
            display: grid;
            margin-top: 10px;
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



        @media only screen and (max-width: 765px) {

            body {
                overflow: hidden;
            }

            button {
                cursor: unset;
            }

            #main {
                min-height: 90vh;
                overflow: hidden;
                /*Firefox */
                scrollbar-width: thin;
                scrollbar-color: transparent transparent;

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

            #has-been-followed {
                padding: 4px 9px;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #424242;
                color: #E7E9EA;
                font-weight: 530;
                border-radius: 5px;
                display: none;
                user-select: none;
            }

            #has-been-followed {
                padding: 6px 9px;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #424242;
                color: #E7E9EA;
                font-weight: 530;
                border-radius: 5px;
                display: none;
                user-select: none;
            }

            #follow-button {
                padding: 4px 17px;
                color: #1c1c20;
                font-size: 17px;
                font-weight: 550;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #1D9BF0;
                border-radius: 5px;
                user-select: none;
            }

            #follow-button:active {
                background-color: #1173b4;
            }

            #has-been-followed:active {
                background-color: #3e3e3e;
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

            #data-container {
                padding-bottom: 60px;
            }

            #people-card {
                width: 40%;
                padding: 20px 15px;
                display: grid;
                place-items: center;
                background-color: #2a2a31;
                border-radius: 6px;
                margin: 0 7px;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                text-align: center;
                padding: 15px;
                display: grid;
                place-items: center;
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

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 10px;
                margin: 0 5px;
                color: black;
                border-radius: 50%;
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

            .icon-container {
                display: flex;
                align-items: center;
                margin-top: 10px;
                font-size: 19px;
                padding: 10px 0;
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

            #pc-navb {
                display: none;
            }

            #mobile-navb {
                padding: 2em 14px;
                display: flex;
            }

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 10px;
                margin: 0 6px;
                color: black;
                border-radius: 50%;
            }



            .user-container {
                width: 100vw;
                padding: 17px 19px;
                background-color: transparent;
                display: flex;
                align-items: center;
                user-select: none;
                cursor: unset;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                border-bottom: 0.5px solid rgb(47, 51, 54);
            }

            .showData {
                display: block;
            }

            .username {
                color: #E7E9EA;
                font-size: 19px;
                font-family: Arial, Helvetica, sans-serif;
                font-weight: 550;
            }

            .bio {
                color: #96999a;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                margin-top: 5px;
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
                justify-content: center;
                height: 170px;
            }


            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 10px;
                margin: 0 6px;
                color: black;
                border-radius: 50%;
            }

            .user-container {
                width: 100vw;
                padding: 17px 19px;
                background-color: transparent;
                display: flex;
                align-items: center;
                user-select: none;
                cursor: unset;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                border-bottom: 0.5px solid rgb(47, 51, 54);
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

            .read_more:active {
                color: #0675bf;
            }





        }

        @media only screen and (min-width: 765px) {

            body {
                display: flex;
                overflow: hidden;

            }

            #main {
                overflow-x: hidden !important;
                height: 100vh;
            }

            button {
                cursor: pointer;
            }

            #empty-data {
                place-items: center;
            }

            .read_more:hover {
                color: #0675bf;
            }

            .open {
                cursor: pointer;
            }

            .open:hover {
                color: #1b8ad4;
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

            .sug {
                margin-bottom: 30px;
            }

            #pl-container {
                display: grid;
                place-items: center;
                text-align: center;
            }

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 9.7px;
                margin: 1px 6px 0 6px;
                color: black;
                border-radius: 50%;
            }

            .user-container {
                display: flex;
                padding: 15px 20px;
                background-color: #2a2a31;
                width: 65%;
                justify-content: space-between;
                border-radius: 6px;
                user-select: none;
                cursor: pointer;
                overflow-wrap: break-word;
                word-break: break-word;
                align-items: center;
                white-space: normal;
                margin: 5px 0;
            }

            #people-card {

                width: 24vw;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                text-align: center;
                padding: 20px 15px;
                display: grid;
                place-items: center;
                background-color: #2a2a31;
                border-radius: 6px;
                margin: 0 7px;
                max-width: 220px;
            }

            #follow-button {
                padding: 6px 17px;
                color: #1c1c20;
                font-size: 17px;
                font-weight: 550;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #1D9BF0;
                border-radius: 5px;
                user-select: none;
            }

            #follow-button:hover {
                background-color: #1173b4;
            }

            #has-been-followed:hover {
                background-color: #3a3a3a;
            }


            #mobile-navb {
                display: none;
            }

            #pc-navb {
                display: flex;
                padding-left: 23px;
            }

            #mobile-footer {
                display: none;
            }

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 9.7px;
                margin: 1px 6px 0 6px;
                color: black;
                border-radius: 50%;
            }







            #main {
                overflow: auto;
                scrollbar-width: thin;
                width: 100%;

            }

            .showData {
                display: grid;
                place-items: center;
            }

            #data-container {
                padding: 20px;
                padding-bottom: 80px;
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
                cursor: pointer;
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

            .verification {
                background-color: #1D9BF0;
                padding: 3.5px;
                font-size: 11.5px;
                margin: 0 5px;
                color: black;
                border-radius: 50%;
            }

            .icon-container {
                display: flex;
                align-items: center;
                margin-top: 10px;
                font-size: 19px;
                padding: 10px 0;
            }

            .status_information {
                color: #E7E9EA;
                margin: 0 10px 10px 0;
                user-select: none !important;
                font-family: Arial, Helvetica, sans-serif;
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

            .user-container {
                display: flex;
                padding: 15px 20px;
                background-color: #2a2a31;
                width: 65%;
                align-items: center;
                border-radius: 6px;
                justify-content: space-between;
                user-select: none;
                cursor: pointer;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
                margin: 5px 0;
            }

            .username {
                color: #E7E9EA;
                font-size: 19px;
                font-family: Arial, Helvetica, sans-serif;
                font-weight: 550;

            }

            .bio {
                color: #96999a;
                font-size: 17px;
                font-family: Arial, Helvetica, sans-serif;
                margin-top: 3px;
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

            #load_data {
                display: none;
                padding-top: 2.2vw;
                justify-content: center;
                height: 120px;
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

            .read_more:hover {
                color: #0675bf;
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


        @media screen and (max-width: 360px) {
            .card {
                width: 140px;
            }
        }

        @media screen and (max-width: 326px) {
            .card {
                width: 90%;
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
                <div onclick="window.location.href = `../profile/?n=@${decrypt(localStorage.getItem('rk_4t9'),71)}`"
                    class="page-button flex white" oncontextmenu="return false;">
                    <i class="page-icon fas fa-user"></i>
                    <p class="page-name">Profil</p>
                </div>
            </li>
            <li>
                <a href="./" class="page-button flex white is-here" oncontextmenu="return false;">
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
        </nav>
        <nav id="mobile-navb" class="bg-black">
            <span class="flex">

                <h1 style="margin-left: 5px;" id="sender-name" class="font-bold text-xl">Status</h1>
            </span>
        </nav>

        <section id="data-container" class="hideData">

        </section>
        <section id="load_data">
            <div class="load_data"></div>
        </section>
        <section id="loading">
            <div style="display: flex; justify-content: center; align-items: center; height: 80%; width: 100%;"
                class="loading-container">
                <div class="loading"></div>
            </div>
        </section>
        <section style="display: none;" id="empty-data" class="select-none">
            <h2 class="sug">Tidak ada status, Ikuti orang lain untuk melihat statusnya</h2>

        </section>
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

        <div style="display: none;" class="toast" id="toast"></div>


    </section>
    <footer id="mobile-footer">
        <ul class="button-list">
            <li onclick="window.location.href = '../'" class="mobile-page-button">
                <i class="mobile-page-icon fas fa-home"></i>
                <p class="mobile-page-name">Beranda</p>
            </li>
            <li class="mobile-page-button mobile-is-here">
                <i class="mobile-page-icon fas fa-asterisk"></i>
                <p class="mobile-page-name">Status</p>
            </li>
            <li onclick="window.location.href = '../messages'" class="mobile-page-button">
                <i class="mobile-page-icon fas fa-comment"></i>
                <p class="mobile-page-name">Pesan</p>
            </li>
            <li onclick="window.location.href = `../profile/?n=@${decrypt(localStorage.getItem('rk_4t9'),71)}`"
                class="mobile-page-button">
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

    <script>document.querySelector('html').setAttribute('lang', navigator.language || navigator.userLanguage);</script>


    <script type="text/javascript">

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


        const emptyData = document.getElementById("empty-data");
        const dataContainer = document.getElementById("data-container");
        const loading_section = document.getElementById("loading");
        const copyright = document.getElementById("copyright");
        copyright.innerText = `© ${new Date().getFullYear()} Wahyuna`;
        const load_data = document.getElementById("load_data");
        const toastt = document.getElementById("toast");

        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
            document.body.style.userSelect = "none";
        }

        function toast(message) {
            toastt.textContent = message;
            toastt.style.display = "flex";
            setTimeout(function () {
                toastt.style.display = "none";
            }, 2000);
        }

        const buttonPopup = document.getElementById("button-popup");
        const backdrop = document.getElementById("backdrop");
        const loadingPopup = document.getElementById("popup");
        const popupTitle = document.getElementById("popupTitle");
        const msgg = document.getElementById("msgg");
        const leftButton = document.getElementById("leftButton");
        const rightButton = document.getElementById("rightButton");



        function popup_x(title, msg, leftButtonName, rightButtonName, leftButtonFunction, rightButtonFunction) {
            document.body.style.overflow = 'hidden';
            backdrop.style.display = 'block';
            buttonPopup.style.display = 'block';

            popupTitle.innerText = title;
            msgg.innerText = msg;
            leftButton.innerText = leftButtonName;
            rightButton.innerText = rightButtonName;
            leftButton.addEventListener("click", function (event) {
                backdrop.style.display = 'none';
                buttonPopup.style.display = 'none';
                leftButtonFunction();
                document.body.style.overflow = 'auto';
            })
            rightButton.addEventListener("click", function (event) {
                backdrop.style.display = 'none';
                buttonPopup.style.display = 'none';
                rightButtonFunction();
                document.body.style.overflow = 'auto';
            });
        }





        const chrt = (char, key) => /[a-zA-Z]/.test(char) ? String.fromCharCode((char.charCodeAt() - (/[A-Z]/.test(char) ? 65 : 97) + key + 26) % 26 + (/[A-Z]/.test(char) ? 65 : 97)) : char;
        const text_to_base64 = (text) => btoa(text);
        const base64_to_text = (base64) => atob(base64);
        const encrypt = (text, key) => text_to_base64([...text].map(char => chrt(char, key)).join(''));
        const decrypt = (text, key) => [...base64_to_text(text)].map(char => chrt(char, (26 - key) % 26)).join('');


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
                        true
                    } else {
                        console.error(result.message);

                    }
                } else {
                    console.error('error');

                }
            } catch (error) {
                console.error(error);

            }
        }

        function stop_following(token, username) {
            const xhr = new XMLHttpRequest();

            // data
            const datax = new URLSearchParams();
            datax.append('token', token);
            datax.append('username', username);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const result = JSON.parse(xhr.responseText);
                        if (result.status === 'success') {
                            true
                        } else {
                            console.error(result.message);

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

            usernameContainer.addEventListener('click', function () {
                window.location.href = "../profile/?n=@" + name_data
            })
            usernameContainer.appendChild(user_name)

            const verification = document.createElement('i')
            verification.setAttribute("class", "verification fas fa-check")

            if (verification_data) {
                usernameContainer.appendChild(verification)
            }

            const time = document.createElement('p')
            time.setAttribute("class", "time")
            time.innerText = "• " + ago(date_data)
            setInterval(function () {
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
                    link.addEventListener('contextmenu', function (event) {
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

                less.addEventListener('click', function (e) {
                    less.style.display = "none";
                    read_more.style.display = "block";
                    caption.innerHTML = shortText;
                    caption.appendChild(read_more);
                });

                read_more.addEventListener('click', function () {
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

            setInterval(function () {
                if (user_id_data == localStorage.getItem("z_j")) {
                    reply.style.display = "none"
                }
            }, 1)

            const copy = document.createElement("i")
            copy.setAttribute("class", "icn fas fa-link")


            reply.addEventListener("click", function () {
                window.location.href = "../reply/?id=" + id_data
            })

            copy.addEventListener("click", function () {
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



            delete_button.addEventListener("click", function () {
                popup_x("Hapus status", "Yakin ingin menghapus status ini?", "Batal", "Ya", function () {
                    false
                }, function () {
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

            others.addEventListener("click", function (e) {
                others.style.display = "none"
                cls.style.display = "block"
                delete_button.style.display = "block"
            })


            cls.addEventListener("click", function (e) {
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



        // orang acak
        function container_for_people(data) {
            const pContainer = document.createElement('div');
            pContainer.setAttribute('id', 'p-container');

            for (let i = 0; i < data.length; i++) {
                const card = document.createElement('div');
                card.setAttribute('id', "people-card")

                const usernameContainer = document.createElement('div');
                usernameContainer.style.display = "flex";
                usernameContainer.style.alignItems = "center";
                usernameContainer.style.height = "20px";
                const username = document.createElement('p');
                username.setAttribute('class', "user-name");
                username.innerText = decrypt(data[i].username, 71)

                usernameContainer.addEventListener('click', function () {
                    window.location.href = "../profile/?n=@" + decrypt(data[i].username, 71)
                })

                const verification = document.createElement('i')
                verification.setAttribute("class", "verification fas fa-check")


                usernameContainer.appendChild(username);
                if (data[i].verification) {
                    username.style.marginLeft = "6px"
                    usernameContainer.appendChild(verification)
                }
                card.appendChild(usernameContainer);

                const bio = document.createElement("p");
                bio.setAttribute("class", "bioo")
                bio.innerText = data[i].bio

                card.appendChild(bio);

                const follow_button = document.createElement("button");
                follow_button.setAttribute("id", "follow-button");
                follow_button.textContent = "Ikuti"
                card.appendChild(follow_button);



                const unfollow_button = document.createElement("button");
                unfollow_button.setAttribute("id", "has-been-followed");
                unfollow_button.innerHTML = "Mengikuti <i class='done fas fa-check'></i>"


                follow_button.addEventListener("click", function (e) {
                    follow_button.style.display = "none"
                    unfollow_button.style.display = "block"



                    followw(localStorage.getItem("_0_n"), decrypt(data[i].username, 71));
                })

                unfollow_button.addEventListener("click", function (e) {
                    unfollow_button.style.display = "none"
                    follow_button.style.display = "block"


                    if (localStorage.getItem("_0_n")) {



                        stop_following(localStorage.getItem("_0_n"), decrypt(data[i].username, 71));
                    }
                })

                card.appendChild(unfollow_button);


                pContainer.appendChild(card);


            }
            if (data.length) {
                dataContainer.appendChild(pContainer);
            }
        }



        function user(name_data, verification_data, bio_data) {
            const userContainer = document.createElement("div");
            userContainer.setAttribute("class", "user-container")
            userContainer.style.justifyContent = "space-between";
            userContainer.addEventListener("click", function () {
                window.location.href = "../profile/?n=" + name_data
            })

            const usernameContainer = document.createElement("div");
            usernameContainer.style.display = "block";
            const usernameCtr = document.createElement("div");
            usernameCtr.style.display = "flex";
            usernameCtr.style.alignItems = "center";
            const username = document.createElement("p");
            username.setAttribute("class", "username")
            username.innerText = name_data.trim()

            const verification = document.createElement('i')
            verification.setAttribute("class", "verification fas fa-check")


            usernameCtr.appendChild(username)
            if (verification_data) {
                usernameCtr.appendChild(verification)
            }
            usernameContainer.appendChild(usernameCtr);

            const bio = document.createElement('p')
            bio.setAttribute("class", "bio")
            bio.innerText = bio_data.trim()
            usernameContainer.appendChild(bio)
            userContainer.appendChild(usernameContainer);

            const follow_b = document.createElement("button");
            follow_b.setAttribute("id", "follow-button");
            follow_b.style.fontSize = "15px";
            follow_b.style.padding = "6px 14px";

            follow_b.style.alignItems = "center";
            follow_b.textContent = "Ikuti"


            const unfollow_button = document.createElement("button");
            unfollow_button.setAttribute("id", "has-been-followed");
            unfollow_button.style.fontSize = "15px";
            unfollow_button.style.padding = "6px 14px";

            unfollow_button.innerHTML = "Mengikuti <i class='done fas fa-check'></i>"

            follow_b.addEventListener("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                follow_b.style.display = "none";
                unfollow_button.style.display = "block";
                followw(localStorage.getItem("_0_n"), name_data.trim());
            })

            unfollow_button.addEventListener("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                unfollow_button.style.display = "none";
                follow_b.style.display = "block";
                stop_following(localStorage.getItem("_0_n"), name_data.trim());
            })
            userContainer.appendChild(follow_b)
            userContainer.appendChild(unfollow_button)


            emptyData.appendChild(userContainer)
        }


        if (localStorage.getItem("_0_n")) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../check.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let output = JSON.parse(xhr.responseText);
                    localStorage.setItem("z_j", output.id);

                    if (output.success) {

                        let start_index = 0;
                        let end_of_data = 0;
                        let data_exists = true;

                        async function showData(si) {
                            try {
                                const post = {
                                    token: output.token,
                                    start_index: si
                                };

                                const res = await fetch('../followed_post.php', {
                                    method: 'POST',
                                    body: JSON.stringify(post),
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    cache: 'no-store'
                                });

                                if (!res.ok) {
                                    throw new Error(res.status);
                                }

                                const results = await res.json();
                                start_index += 22;
                                end_of_data = results.index_complete;

                                if (end_of_data > 0) {
                                    setTimeout(function () {
                                        emptyData.style.display = 'none';
                                        document.body.style.overflow = 'auto';
                                        loading_section.style.display = 'none';
                                        dataContainer.setAttribute("class", "showData");
                                        load_data.style.display = 'flex';
                                    }, 50);

                                    let rand = Math.floor(Math.random() * results.status.length)
                                    results.status.sort(() => Math.random() - 0.5);

                                    for (let i = 0; i < results.status.length; i++) {
                                        const dat = results.status[i];
                                        postCtr(decrypt(dat.username, 71), dat.caption, dat.date, dat.id, dat.verification, dat.sender_id, dat.total_reply);
                                        if (results.follow_other_people) {
                                            if (i == rand) {
                                                container_for_people(results.follow_other_people)
                                            }
                                        }

                                    }
                                } else {
                                    setTimeout(function () {
                                        loading_section.style.display = 'none';
                                        document.body.style.overflow = 'auto';
                                        dataContainer.setAttribute("class", "hideData");
                                        emptyData.style.display = 'grid';
                                        data_exists = false

                                        for (let i = 0; i < results.follow.length; i++) {
                                            user(decrypt(results.follow[i].username, 71), results.follow[i].verification, results.follow[i].bio)
                                        }
                                    }, 50);
                                }
                            } catch (error) {
                                console.error(error);
                            }
                        }

                        let view_data = setInterval(() => {
                            if (start_index <= end_of_data) {
                                const rect = dataContainer.getBoundingClientRect();

                                if (rect.bottom <= window.innerHeight) {
                                    if (data_exists) {
                                        showData(start_index);
                                    }
                                }
                            } else {
                                clearInterval(view_data);
                                setTimeout(function () {
                                    load_data.style.visibility = 'hidden';
                                }, 200);
                            }
                        }, 400);


                    } else {
                        // akun salah
                        window.location.replace("../signin");
                    }
                }
            };

            // Kirim
            xhr.send('token=' + encodeURIComponent(localStorage.getItem("_0_n")));
        } else {
            window.location.replace("../signin");
        }

    </script>
</body>

</html>
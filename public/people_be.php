<?php

$file = file_get_contents('databases/users.json');
$users = json_decode($file, true);
shuffle($users);

$random_user = array_slice($users, 0, 11);

$data = array_map(function ($user) {
    return [
        "id" => $user["id"],
        "username" => $user["username"],
        "name" => $user["name"],
        "verification" => $user["verification"],
        "verification_reason" => $user["verification_reason"],
        "bio" => $user["bio"],
        "userAgent" => $user["userAgent"],
        "created" => $user["created"],
        "os" => $user["os"],
        "profile_picture" => $user["profile_picture"],
        "cover_photo" => $user["cover_photo"],
    ];
}, $random_user);

$json = json_encode($data, JSON_PRETTY_PRINT);

// kompress
header('Content-Encoding: gzip');
header('Content-Type: application/json');


$res = gzencode($json, 9);
header('Content-Length: ' . strlen($res));
echo $res;

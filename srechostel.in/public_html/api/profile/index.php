<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/is-watch-man.php";
//session_start();
if(isset($_GET['auth_token_id'])){
    header("Content-Type: image/jpg");
    $encrypted = urldecode($_GET['auth_token_id']);
    $encrypted = str_replace("sk", "+", $encrypted);
    $encrypted = base64_decode($encrypted);
    $method = "AES-256-CBC";
    $key = "secret";
    $iv = substr($encrypted, 0, openssl_cipher_iv_length($method));
    $encrypted = substr($encrypted, openssl_cipher_iv_length($method));
    $rollNo = openssl_decrypt($encrypted, $method, $key, 0, $iv);
    if(file_exists($_SERVER['DOCUMENT_ROOT']."/../profile-photos/".$rollNo.'.jpg')) {
        include_once $_SERVER['DOCUMENT_ROOT']."/../profile-photos/".$rollNo.'.jpg';
    } else {
        include_once $_SERVER['DOCUMENT_ROOT']."/../profile-photos/dummy-profile.jpg";
    }
}
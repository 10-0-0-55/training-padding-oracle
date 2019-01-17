<?php
$flag = $_ENV['flag'];
session_start();

$cipher = "aes-128-cbc";
if(!isset($_COOKIE['enc_flag'])){
    //generate everyting;
    $key = openssl_random_pseudo_bytes(16);
    $iv_len = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_len);
    $_SESSION['key'] = $key;
    $enc = openssl_encrypt($flag, $cipher, $key, 0, $iv);
    //store
    setcookie("enc_flag", $enc);
    setcookie("iv", $iv);
}
else{
    $enc_flag = $_COOKIE['enc_flag'];
    $iv = $_COOKIE['iv'];
    $key = $_SESSION['key'];
    $plain = openssl_decrypt($enc_flag, $cipher, $key, 0, $iv);
    if($plain === false){
        echo "nonono hacker";
    }
    if($plain == $flag){
        echo "yes! that is the encrypted flag";
    }
}
show_source(__FILE__);
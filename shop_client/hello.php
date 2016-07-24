<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/24
 * Time: 11:09
 */
include "global.php";

$data = file_get_contents('http://192.168.0.102/demos/shop_server/hello.php?client_id='.CLIENT_UID);


$data = json_decode($data, true);


if ($data['code'] != ERROR_CODE_SUCCESS){

    echo 'shop_server/hello.php request failed : ' , $data['code'] ; // log
    exit();

}




$pub_key = file_get_contents('./pub_key.pem');
$crypted = base64_decode($data['data']);
$decrypted = '' ;


$flag = openssl_public_decrypt($crypted, $decrypted, $pub_key);


if (!$flag){
    echo '解密失败';
    exit();
}



$keydata = json_decode($decrypted, true);


$key = $keydata['key'];
$kid = $keydata['kid'];

include 'send.php' ;
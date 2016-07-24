<?php


$order = array(
    'oid' => 1 ,
    'price' => 100
);


$order_json = json_encode($order);


// 加密数据   对称加密
$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_NOFB, '');
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td));

mcrypt_generic_init($td, $key, $iv);
$encrypted = mcrypt_generic($td, $order_json);

mcrypt_generic_deinit($td);


// 加密数据    非对称加密

$ret_order['iv'] = base64_encode($iv) ;
$ret_order['kid'] = $kid;
$ret_order['data'] = base64_encode($encrypted);


$ret_order = json_encode($ret_order);
$crypted = '' ;
$flag = openssl_public_encrypt($ret_order, $crypted, $pub_key) ;

if (!$flag){
    echo 'public key encrypt error';
    exit();
}


// post 提交数据到server

$ret = array();
$ret['client_id'] = CLIENT_UID;
$ret['data'] = base64_encode($crypted) ;


$url = 'http://192.168.0.102/demos/shop_server/recv.php' ;

$request = curl_init($url);
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1) ;
curl_setopt($request, CURLOPT_POST, 1) ;
curl_setopt($request, CURLOPT_POSTFIELDS, $ret) ;

if (curl_errno($request)){
    echo 'curl error : '.curl_error($request);
    curl_close($request);
    exit();
}


$server_ret = curl_exec($request);

if (curl_errno($request)){
    echo 'curl error : '.curl_error($request);
    curl_close($request);
    exit();
}



curl_close($request);
echo 'success : ' . $server_ret ;





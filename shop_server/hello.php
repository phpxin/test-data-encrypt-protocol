<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/24
 * Time: 10:38
 *
 *
 * 步骤1：接受客户端hello请求
 */

include 'global.php' ;



$cid = intval(trim($_GET['client_id'])) ;


$sql = 'select keypath from server_client where id=:id limit 1';

$statement = $db->prepare($sql);


$statement->bindValue(':id', $cid, PDO::PARAM_INT) ;


$flag = $statement->execute();

if(!$flag || $statement->rowCount() <= 0){
    echo json_encode(array('code'=>ERROR_CODE_UID_NOT_FOUND));
    exit;
}

$client_info = $statement->fetch(PDO::FETCH_ASSOC);


//生成key


$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_NOFB, '');

//$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td));
//echo 'iv is ' , $iv , PHP_EOL ;

$ks = mcrypt_enc_get_key_size($td);


$key = substr(md5(rand()), 0, $ks);
$addtime = time();

$losetime = $addtime + (5*60) ;


$sql = 'insert into server_keystore(`value`,`addtime`,`losetime`) values(:keyvalue,:addtime,:losetime)' ;

$statement = $db->prepare($sql);
$statement->bindValue(':keyvalue', $key, PDO::PARAM_STR);
$statement->bindValue(':addtime', $addtime, PDO::PARAM_INT);
$statement->bindValue(':losetime', $losetime, PDO::PARAM_INT);

$flag = $statement->execute();

if (!$flag){
    echo json_encode(array('code'=>ERROR_CODE_DB_ERR));
    exit;
}

$insert_id = $db->lastInsertId();

if (!$insert_id){
    echo json_encode(array('code'=>ERROR_CODE_DB_INSERT_ERR));
    exit;
}


//把key发送到客户端
$_data['key'] = $key ;
$_data['kid'] = $insert_id ;

$data = json_encode($_data) ;

$rsa_private_key = file_get_contents('./rsakeys/'.$client_info['keypath']);

$crypted = '' ;
$flag = openssl_private_encrypt($data, $crypted, $rsa_private_key) ;

if (!$flag){
    echo json_encode(array('code'=>ERROR_CODE_KEY_ENCODE_ERR));
    exit();
}

$ret = array('code'=>ERROR_CODE_SUCCESS, 'data'=>base64_encode($crypted)) ;



echo json_encode($ret) ;
exit();
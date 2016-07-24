<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/24
 * Time: 10:39
 */

include 'global.php' ;

file_put_contents('./log.php', var_export($_POST, true).PHP_EOL);


$cid = intval(trim($_POST['client_id']));
$data = trim($_POST['data']);

$data = base64_decode($data) ;
//file_put_contents('./log.php', var_export($data, true).PHP_EOL, FILE_APPEND);
//$ret_order['iv'] = base64_encode($iv) ;
//$ret_order['kid'] = $kid;
//$ret_order['data'] = base64_encode($encrypted);


$sql = 'select keypath from server_client where id=:id limit 1';

$statement = $db->prepare($sql);


$statement->bindValue(':id', $cid, PDO::PARAM_INT) ;


$flag = $statement->execute();

if(!$flag || $statement->rowCount() <= 0){
    echo json_encode(array('code'=>ERROR_CODE_UID_NOT_FOUND));
    exit;
}

$client_info = $statement->fetch(PDO::FETCH_ASSOC);



$rsa_private_key = file_get_contents('./rsakeys/'.$client_info['keypath']);

$decrypted = '' ;
//$flag = openssl_private_encrypt($data, $crypted, $rsa_private_key) ;
$flag = openssl_private_decrypt($data, $decrypted, $rsa_private_key);

if (!$flag){
    echo json_encode(array('code'=>ERROR_CODE_KEY_ENCODE_ERR));
    exit();
}





$order_encrypt_data = json_decode($decrypted, true) ;

$iv = base64_decode($order_encrypt_data['iv']);
$kid = $order_encrypt_data['kid'];
$prepare_data = base64_decode($order_encrypt_data['data']);    ///    对称加密后的数据

file_put_contents('./log.php', var_export($kid, true).PHP_EOL, FILE_APPEND);
// 对称加密 - 解密

$sql = "select `value`,`losetime`,`status` from server_keystore where id=:kid limit 1";
$statement = $db->prepare($sql);
$statement->bindValue(':kid', $kid, PDO::PARAM_INT);
$flag = $statement->execute();

if (!$flag || $statement->rowCount()<=0){
    echo json_encode(array('code'=>ERROR_CODE_KEY_NOT_FOUND));
    exit();
}

$keyinfo = $statement->fetch(PDO::FETCH_ASSOC);
file_put_contents('./log.php', var_export($keyinfo, true).PHP_EOL, FILE_APPEND);
if ($keyinfo['losetime'] < time()){
    echo json_encode(array('code'=>ERROR_CODE_KEY_TIMEOUT));
    exit();
}

if ($keyinfo['status'] != KEY_STATUS_CREATE){
    echo json_encode(array('code'=>ERROR_CODE_KEY_INVALID));
    exit();
}




$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_NOFB, '');
mcrypt_generic_init($td, $keyinfo['value'], $iv);
$decrypted = mdecrypt_generic($td, $prepare_data);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);


file_put_contents('./log.php', var_export($decrypted, true).PHP_EOL, FILE_APPEND);


$order = json_decode($decrypted, true);

$db->beginTransaction();
$tflag = true;
try{

    $sql ="insert into server_order(`price`, `addtime`, `keyid`, `status`, `oid`) values(:price, :addtime, :keyid, :status, :oid)" ;

    $statement = $db->prepare($sql) ;

    $statement->bindValue(":price", $order['price'], PDO::PARAM_STR) ;
    $statement->bindValue(":addtime", time(), PDO::PARAM_INT);
    $statement->bindValue(":keyid", $kid, PDO::PARAM_INT) ;
    $statement->bindValue(":status", ORDER_STATUS_DONE, PDO::PARAM_INT) ;
    $statement->bindValue(":oid", $order['oid'], PDO::PARAM_INT) ;


    $flag = $statement->execute();


    $errno = $statement->errorCode() ;
    if (intval($errno)){
        throw new Exception('插入失败', ERROR_CODE_DB_INSERT_ERR) ;
    }


    
    if (!$flag){
        throw new Exception('插入失败', ERROR_CODE_DB_INSERT_ERR) ;
    }
    $insert_id = $db->lastInsertId();
    if (!$insert_id){
        throw new Exception('插入失败', ERROR_CODE_DB_INSERT_ERR) ;
    }

    // 修改key状态

    $sql = "update server_keystore set status=:status where id=:kid" ;

    $statement = $db->prepare($sql);
    $statement->bindValue(":status", KEY_STATUS_USED, PDO::PARAM_INT) ;
    $statement->bindValue(":kid", $kid, PDO::PARAM_INT) ;

    $flag = $statement->execute() ;

    $errno = $statement->errorCode() ;
    if (intval($errno)){
        throw new Exception('更新失败', ERROR_CODE_DB_UPDATE_ERR) ;
    }

    if (!$flag || $statement->rowCount()<=0){
        throw new Exception('更新失败', ERROR_CODE_DB_UPDATE_ERR) ;
    }

    $db->commit();

}catch(Exception $e){
    $db->rollBack() ;
    $tflag = false ;
    $ret['code'] = $e->getCode();
}


if (!$tflag){
    echo json_encode($ret) ;
    exit();
}


echo json_encode(array('code'=>ERROR_CODE_SUCCESS)) ;
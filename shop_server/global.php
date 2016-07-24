<?php

error_reporting(E_ALL-E_NOTICE);

$db = new PDO('mysql:host=192.168.0.109;dbname=shoptest','root','lixinxin');

$db->query('set names utf8');





define('SERVER_STATUS_CREATE', 0) ;
define('SERVER_STATUS_FINISH', 1) ;
define('SERVER_STATUS_ERROR', 2) ;




define('ERROR_CODE_SUCCESS', 0) ;
define('ERROR_CODE_UID_NOT_FOUND', 10001) ;
define('ERROR_CODE_DB_ERR', 10002) ;
define('ERROR_CODE_DB_INSERT_ERR', 10003) ;
define('ERROR_CODE_KEY_ENCODE_ERR', 10004) ;
define('ERROR_CODE_KEY_NOT_FOUND', 10005) ;
define('ERROR_CODE_KEY_TIMEOUT', 10006) ;
define('ERROR_CODE_KEY_INVALID', 10007) ;
define('ERROR_CODE_DB_UPDATE_ERR', 10008) ;


define('KEY_STATUS_CREATE', 1) ;
define('KEY_STATUS_USED', 2);


define('ORDER_STATUS_DONE', 1);
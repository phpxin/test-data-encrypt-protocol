<?php

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


define('CLIENT_UID',  1) ; /// 商户号




<?php
/****** qrz start ******/
use M1\Env\Parser;

$env = Parser::parse(file_get_contents('.env'));
/****** qrz end ******/

define('DOMAINTYPE','off');
define('CH','exam_');
define('CDO','');
define('CP','/');
define('CRT',180);
define('CS',md5(base64_encode($_SERVER['HTTP_HOST'])));
define('HE','utf-8');
define('PN',10);
define('TIME',time());
define('USEWX',FALSE);
if(dirname($_SERVER['SCRIPT_NAME']))
define('WP','http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']));
else
define('WP','http://'.$_SERVER['SERVER_NAME'].'/');

/****** qrz start ******/
define('DB', $env['DB_NAME'] ? $env['DB_NAME'] : 'phpems');//MYSQL数据库名
define('DH', $env['DB_HOST'] ? $env['DB_HOST'] : 'localhost');//MYSQL主机名，不用改
define('DU', $env['DB_USER'] ? $env['DB_USER'] : 'root');//MYSQL数据库用户名
define('DP', $env['DB_PWD'] ? $env['DB_PWD'] : '');//MYSQL数据库用户密码
define('DTH','x2_');//系统表前缀，不用改
/****** qrz end ******/

define('WXAPPID','wx0f2a632abf082e60');
define('WXAPPSECRET','3368f73a6f517b37c7e8f0cee2c86341');
define('WXMCHID','1369875702');
define('WXKEY','guotongshangchengweixinzhifu2016');

?>
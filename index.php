<?php
date_default_timezone_set('Asia/Shanghai');

require_once __DIR__ . '/vendor/autoload.php';

session_start();
set_time_limit(0);
$t1 = microtime();
define("PE_VERSION",'4.1');
require "lib/init.cls.php";

$ginkgo = new ginkgo;
$ginkgo->run();

?>
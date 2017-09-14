<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/13
 * Time: 22:18
 */
require "../vendor/autoload.php";

define('ROOT', dirname(__DIR__));

$options = require "./config/config.php";

$easemob = new \liyaojian\Easemob\App\Easemob($options);

$time = 2017091415;
$path = ROOT . "/cache/";
try {
    $res = $easemob->saveMessageHistory($time, $path);
    foreach ($res as $k => $v) {
        print_r(readgz($path.$v));
    }
} catch (\liyaojian\Easemob\App\EasemobError $e) {
    echo $e->getCode().' | '.$e->getMessage().' | '.$e->getTraceAsString();
}


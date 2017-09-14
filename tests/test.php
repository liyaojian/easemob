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

$easemob = new \liyaojian\Easemob\Handler\Easemob($options);

$time = 2017091415;
$path = ROOT . "/cache/";
try {
    $res = $easemob->saveMessageHistory($time, $path);
    $array = [];
    foreach ($res as $k => $v) {
        $array = array_merge($array,readgz($path.$v));
    }
    print_r($array);
} catch (\liyaojian\Easemob\Handler\EasemobError $e) {
    echo $e->getCode().' | '.$e->getMessage().' | '.$e->getTraceAsString();
}


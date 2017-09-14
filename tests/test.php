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

$time = 2017091416;
$path = ROOT . "/cache/";
try {
//    $res = $easemob->saveMessageHistory($time, $path);
//    $array = [];
//    foreach ($res as $k => $v) {
//        $array = array_merge($array,readgz($path.$v));
//    }
    $array = readgz($path . $time . '-1.gz');
    foreach ($array as $key => $value) {
        if ($value['payload']['bodies'][0]['type'] == 'img') {
            $easemob->downloadFile($value['payload']['bodies'][0]['url'], $path, $value['payload']['bodies'][0]['filename']);
        }
        if ($value['payload']['bodies'][0]['type'] == 'audio') {
            $easemob->downloadFile($value['payload']['bodies'][0]['url'], $path, $value['payload']['bodies'][0]['filename'] . '.amr');
        }
    }
} catch (\liyaojian\Easemob\Handler\EasemobError $e) {
    echo $e->getCode() . ' | ' . $e->getMessage() . ' | ' . $e->getTraceAsString();
}


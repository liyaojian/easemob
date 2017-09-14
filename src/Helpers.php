<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/13
 * Time: 22:44
 */
function readgz($file)
{
    $string = '';
    $zd = gzopen($file, "r");
    while (!gzeof($zd)) { //逐行读取
        $string .= gzread($zd, 10000);
    }
    gzclose($zd);

    $string = preg_replace('/\n|\r\n/', ',', $string);
    $json = '[' . substr($string, 0, -1) . ']';
    $array = json_decode($json,true);
    if (!$array){
        throw new \liyaojian\Easemob\Handler\EasemobError(json_last_error_msg(),json_last_error());
    }
    return $array;
}
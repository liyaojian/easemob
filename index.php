<?php
/**
 * Created by PhpStorm.
 * User: AMC19
 * Date: 2017/9/11
 * Time: 15:58
 */
require "./vendor/autoload.php";

$options = [
    'domain_name' => 'https://a1.easemob.com',
    'org_name' => 'gaoguanjia',
    'app_name' => 'gaoguanjiatest',
    'client_id' => 'YXA6090KMHvUEeWuifd0k07l-g',
    'client_secret' => 'YXA6ZLdyaq-YXHS_FyGidU6f4MSvuGU',
    'token_cache_time' => '100',
];

$easemob = new \liyaojian\Easemob\App\Easemob($options);

$time = 2017091317;
$file = "./downfile/".$time.'.gz';
//try {
//    $easemob->exportMessageHistory($time, $file);
//    //处理下载的文件
//    ungz($file);
//} catch (\Exception $e) {
//    echo $e->getMessage();
//}
ungz($file);

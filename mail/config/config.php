<?php
/**
 * Created by PhpStorm
 * FileName: config.php
 * User: JianJia.Zhou
 * DateTime: 2018/5/14 14:12
 * @description
 */
$qq_mail_config = [
    'account' => '2794385247@qq.com',
    'auth_key' => 'ikdoopzdavdjddfe',
    'host' => 'smtp.qq.com',
    'channel' => 'ssl',
    'port' => 445
];

$log_config = [
    'path' => '../logs/',
    'level' => [
        'EMERGENCY'=>1, //严重错误: 导致系统崩溃无法使用
        'ERROR'=>2,   //一般错误: 一般性错误
        'WARNING'=>3,  //警告性错误: 需要发出警告的错误
        'NORMAL'=>4,  //正常
    ]
];
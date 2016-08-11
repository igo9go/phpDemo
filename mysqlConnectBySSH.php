<?php

//find /yourdir \( -mmin -2 -a -mmin +1 \) -type f -exec rm {} \;
/**
 * 通过ssh连接远程mysql数据库
 * 主要执行SSH命令建立一个连接端口
 */
define("LIVE_TIME",3600);

if (!file_exists('./logfile')) {
    shell_exec("ssh -f -L 127.0.0.1:3307:127.0.0.1:3306 username@userIp sleep 3600 >> logfile");
}

if ((time() - filectime('./logfile')) > LIVE_TIME ) {
    unlink('./logfile');
}
/**
 * 连接3307端口即可
 */
$db = mysqli_connect("127.0.0.1", "root", "root", "data", 3307);

$result = mysqli_query($db,'select * from data limit 1');

$data = mysqli_fetch_all($result,MYSQLI_ASSOC);


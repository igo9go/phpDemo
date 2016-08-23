<?php

$pdo = new PDO("mysql:host=localhost;dbname=admin","root","");

if($pdo -> exec("insert into db_demo(name,content) values('title','content')")){
    echo "插入成功！";
    echo $pdo -> lastinsertid();
}

$rs = $pdo -> query("select * from test");
while($row = $rs -> fetch(PDO::FETCH_CLASS)){
    print_r($row);
}


/*
PDO中常用的函数及其解释如下。
PDO::query()主要是用于有记录结果返回的操作，特别是SELECT操作
PDO::exec()主要是针对没有结果集合返回的操作，如INSERT、UPDATE等操作
PDO::lastInsertId() 返回上次插入操作，主键列类型是自增的最后的自增ID
PDOStatement::fetch()是用来获取一条记录
PDOStatement::fetchAll()是获取所有记录集到一个中
*/




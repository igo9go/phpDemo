<?php

/**
 *一,在php5版本之前，一般是用php的mysql函数去驱动mysql数据库的，比如mysql_query()的函数，属于面向过程
 *二,在php5版本以后，增加了mysqli的函数功能，某种意义上讲，它是mysql系统函数的增强版，更稳定更高效更安全
 *三,mysql与mysqli的区别：
 * 1、mysql是非持继连接函数，mysql每次链接都会打开一个连接的进程。
 * 2、mysqli是永远连接函数，mysqli多次运行mysqli将使用同一连接进程,从而减少了服务器的开销。mysqli封装了诸如事务等一些高级操作，
 * 同时封装了DB操作过*程中的很多   可用的方法。
 */

/* Connect to a MySQL server  连接数据库服务器 */
$link = mysqli_connect(
    'localhost',  /* The host to connect to 连接MySQL地址 */
    'user',      /* The user to connect as 连接MySQL用户名 */
    'password',  /* The password to use 连接MySQL密码 */
    'dbname');    /* The default database to query 连接数据库名称*/

if (!$link) {
    printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
    exit;
}

/* Send a query to the server 向服务器发送查询请求*/
if ($result = mysqli_query($link, 'SELECT Name, Population FROM City ORDER BY Population DESC LIMIT 5')) {

    print("Very large cities are: ");

    /* Fetch the results of the query 返回查询的结果 */
    while ($row = mysqli_fetch_assoc($result)) {
        printf("%s (%s) ", $row['Name'], $row['Population']);
    }

    /* Destroy the result set and free the memory used for it 结束查询释放内存 */
    mysqli_free_result($result);
}

/* Close the connection 关闭连接*/
mysqli_close($link);






/*
mysqli一些常用的函数
mysqli_affected_rows()	返回前一个 Mysql 操作的受影响行数。
mysqli_autocommit()	打开或关闭自动提交数据库修改功能。
mysqli_change_user()	更改指定数据库连接的用户。
mysqli_character_set_name()	返回数据库连接的默认字符集。
mysqli_close()	关闭先前打开的数据库连接。
mysqli_commit()	提交当前事务。
mysqli_connect_errno()	返回最后一次连接调用的错误代码。
mysqli_connect_error()	返回上一次连接错误的错误描述。
mysqli_connect()	打开到 Mysql 服务器的新连接。
mysqli_data_seek()	调整结果指针到结果集中的一个任意行。
mysqli_debug()	执行调试操作。
mysqli_dump_debug_info()	转储调试信息到日志中。
mysqli_errno()	返回最近的函数调用产生的错误代码。
mysqli_error_list()	返回最近的函数调用产生的错误列表。
mysqli_error()	返回字符串描述的最近一次函数调用产生的错误代码。
mysqli_fetch_all()	抓取所有的结果行并且以关联数据，数值索引数组，或者两者皆有的方式返回结果集。
mysqli_fetch_array()	以一个关联数组，数值索引数组，或者两者皆有的方式抓取一行结果。
mysqli_fetch_assoc()	以一个关联数组方式抓取一行结果。
mysqli_fetch_field_direct()	以对象返回结果集中单字段的元数据。
mysqli_fetch_field()	以对象返回结果集中的下一个字段。
mysqli_fetch_fields()	返回代表结果集中字段的对象数组。
mysqli_fetch_lengths()	返回结果集中当前行的列长度。
mysqli_fetch_object()	以对象返回结果集的当前行。
mysqli_fetch_row()	从结果集中抓取一行并以枚举数组的形式返回它。
mysqli_field_count()	返回最近一次查询获取到的列的数目。
mysqli_field_seek()	设置字段指针到特定的字段开始位置。
mysqli_field_tell()	返回字段指针的位置。
mysqli_free_result()	释放与某个结果集相关的内存。
mysqli_get_charset()	返回字符集对象。
mysqli_get_client_info()	返回字符串类型的 Mysql 客户端版本信息。
mysqli_get_client_stats()	返回每个客户端进程的统计信息。
mysqli_get_client_version()	返回整型的 Mysql 客户端版本信息。
mysqli_get_connection_stats()	返回客户端连接的统计信息。
mysqli_get_host_info()	返回 MySQL 服务器主机名和连接类型。
mysqli_get_proto_info()	返回 MySQL 协议版本。
mysqli_get_server_info()	返回 MySQL 服务器版本。
mysqli_get_server_version()	返回整型的 MySQL 服务器版本信息。
mysqli_info()	返回最近一次执行的查询的检索信息。
mysqli_init()	初始化 mysqli 并且返回一个由 mysqli_real_connect() 使用的资源类型。
mysqli_insert_id()	返回最后一次查询中使用的自动生成 id。
mysqli_more_results()	检查一个多语句查询是否还有其他查询结果集。
mysqli_multi_query()	在数据库上执行一个或多个查询。
mysqli_next_result()	从 mysqli_multi_query() 中准备下一个结果集。
mysqli_num_fields()	返回结果集中的字段数。
mysqli_num_rows()	返回结果集中的行数。
mysqli_options()	设置选项。
mysqli_ping()	Ping 一个服务器连接，或者如果那个连接断了尝试重连。
mysqli_query()	在数据库上执行查询。
mysqli_real_connect()	打开一个到 Mysql 服务端的新连接。
mysqli_real_escape_string()	转义在 SQL 语句中使用的字符串中的特殊字符。
mysqli_real_query()	执行 SQL 查询。
mysqli_refresh()	刷新表或缓存，或者重置复制服务器信息。
mysqli_rollback()	回滚当前事务。
mysqli_select_db()	改变连接的默认数据库。
mysqli_set_charset()	设置默认客户端字符集。
mysqli_ssl_set()	使用 SSL 建立安装连接。
mysqli_stat()	返回当前系统状态。

*/
?>
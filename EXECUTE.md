###CONTENT
1. PHP中调用外部命令介绍
2. 关于安全问题
3. 关于超时问题
4. 关于PHP运行linux环境中命令出现的问题


####一、PHP中调用外部命令介绍
<pre>
在PHP中调用外部命令，可以用，1>调用专门函数、2>反引号、3>popen()函数打开进程，三种方法来实现：
</pre>


##### 方法一：用PHP提供的专门函数（四个）：
PHP提供4个专门的执行外部命令的函数：exec(), system(), passthru(), shell_exec()

1. exec()
	- 原型: string exec ( string $command [, array &$output [, int &$return_var ］ )
	- 说明: exec执行系统外部命令时不会输出结果，而是返回结果的最后一行。如果想得到结果，可以使用第二个参数，让其输出到指定的数组。此数组一个记录代表输出的一行。即如果输出结果有20行，则这个数组就有20条记录，所以如果需要反复输出调用不同系统外部命令的结果，最好在输出每一条系统外部命令结果时清空这个数组unset($output)，以防混乱。第三个参数用来取得命令执行的状态码，通常执行成功都是返回0。

`
<?php
	 exec("dir",$output);
	 print_r($output);
 ?>
`

 
2. system()
  	- 原型: string system ( string $command [, int &$return_var ] )
	- 说明: system和exec的区别在于，system在执行系统外部命令时，它执行给定的命令，输出和返回结果。第二个参数是可选的，用来得到命令执行后的状态码。
	
`
<?php
	system("pwd",$result);
	print $result;//输出命令的结果状态码
?>
`
 
3. passthru()
	- 原型: void passthru ( string $command [, int &$return_var ] )
	- 说明: passthru与system的区别，passthru直接将结果输出到游览器，不返回任何值，且其可以输出二进制，比如图像数据。第二个参数可选，是状态码。


`<?php
header("Content-type:image/gif");
passthru("/usr/bin/ppm2tiff  /usr/share/tk8.4/demos/images/teapot.ppm");
?>
`



 
4. shell_exec()
	- 原型: string shell_exec ( string $cmd )
	- 说明: 直接执行命令$cmd
	
`
<?php
$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";
?>
`
 
##### 方法二：反撇号
<pre>
原型: 反撇号`（和~在同一个键）执行系统外部命令
说明: 在使用这种方法执行系统外部命令时，要确保shell_exec函数可用，否则是无法使用这种反撇号执行系统外部命令的。
</pre>

`
<?php
	echo `dir`;
?>
`
 
##### 方法三：用popen()函数打开进程 

	- 原型: resource popen ( string $command , string $mode )
	- 说明: 能够和命令进行交互。之前介绍的方法只能简单地执行命令，却不能与命令交互。有时须向命令输入一些东西，如在增加系统用户时，要调用su来把当前用户换到root用户，而su命令必须要在命令行上输入root的密码。这种情况下，用之前提到的方法显然是不行的。
	- popen( )函数打开一个进程管道来执行给定的命令，返回一个文件句柄，可以对它读和写。返回值和fopen()函数一样，返回一个文件指针。除非使用的是单一的模式打开(读or写)，否则必须使用pclose()函数关闭。该指针可以被fgets(),fgetss(),fwrite()调用。出错时，返回FALSE。


`<?php
error_reporting(E_ALL);
 
$handle = popen('/path/to/executable 2>&1', 'r');
echo "'$handle'; " . gettype($handle) . "\n";
$read = fread($handle, 2096);
echo $read;
pclose($handle);
?>
`

#### 二、关于安全问题：
<pre>

由于PHP基本是用于WEB程序开发的，所以安全性成了人们考虑的一个重要方面。
于是PHP的设计者们给PHP加了一个门：安全模式。
在php.ini中的设置safe_mode = On
如果运行在安全模式下，那么PHP脚本中将受到如下四个方面的限制：
	执行外部命令
	在打开文件时有些限制
	连接MySQL数据库
	基于HTTP的认证

在安全模式下，只有在特定目录中的外部程序才可以被执行，对其它程序的调用将被拒绝。这个目录可以在php.ini文件中用safe_mode_exec_dir指令，或在编译PHP 是加上–with-exec-dir选项来指定，默认是/usr/local/php/bin。

　当你使用这些函数来执行系统命令时，可以使用escapeshellcmd()和escapeshellarg()函数阻止用户恶意在系统上执行命令，escapeshellcmd()针对的是执行的系统命令，而escapeshellarg()针对的是执行系统命令的参数。这两个参数有点类似addslashes()的功能。
　</pre>

#### 三、关于超时问题

<pre>
当执行命令的返回结果非常庞大时，可以需要考虑将返回结果输出至其他文件，再另行读取文件，这样可以显著提高程序执行的效率。
如果要执行的命令要花费很长的时间，那么应该把这个命令放到系统的后台去运行。但在默认情况下，象system()等函数要等到这个命令运行完才返回（实际上是在等命令的输出结果），这肯定会引起PHP脚本的超时。解决的办法是把命令的输出重定向到另外一个文件或流中，如：
</pre>


`<?php
system("/usr/local/bin/order_proc  >  /tmp/abc ");
?>
`


但我调用的DOS命令需要几分钟的时间，而且为了批处理不能简单的把结果写入文件了事，要顺序执行以下的程序
PHP设置了调用系统命令的时间限制，如果调用命令超时，虽然这个命令还是会被执行完，但PHP没有得到返回值，被终止了（最可恨的是，不显示任何错误）
修改php.ini并重启Apache以允许系统命令运行更长的时间
max_execution_time = 600

#### 四、关于PHP运行linux环境中命令出现的问题

<pre>
php一般是以apache用户身份去执行的，也可能是www用户，把apache加入到存储你文件的父文件夹属组里去，然后改该父文件夹权限为775，这样属组成员就有写的权限，而apache属于这个组就可以改写该目录下所有文件的权限。
例如：chown www:www dirName
这样dirName目录才能被php所控制
注意：改apache/php的运行用户方法不安全

另外即使文件或目录已经是www，php的安全设置也都照顾到，一些自己安装linux的命令仍然可能无法运行，例如我曾经安装的ffmpeg软件，原因就是linux的运行权限问题，即使ffmpeg有www权限设置，但由于ffmpeg所依赖的库文件是不允许www用户运行，所以php运行此程序仍然会报127或126错误，通过 ldd 命令可以查看ffmpeg命令依赖的库情况。
这个时候就必须对ffmpeg的依赖库经行设置。具体方法属于linux管理中的话题，这里不就讨论了。
</pre>
  

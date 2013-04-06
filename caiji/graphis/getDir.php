<?php
/*
 * 1.run getDir.php 此文件放到网站跟目录，执行 数据库连接密码不同哦。
 * 2.run getFilePath.php
 * 3.run updatePageLink.php  
 */
include_once("conn.php");
header("Content-Type: text/html; charset=GBK");
set_time_limit(0);


function dirtree($path="./data/attachment/forum/rosi") {
	$d = dir($path);
	while(false !== ($v = $d->read())) {
		if($v == "." || $v == "..")
		continue;
		//    $file = $d->path."/".$v;
		//    echo "$v";
		//    if(is_dir($file))
		//     echo "$v";
		$sql="INSERT INTO `caiji_graphis`.`pagelink` (`id`, `title`, `downloadPageLink`, `count`) VALUES (NULL, '".iconv("GBK", "UTF-8",$v)."', '', '');";
		mysql_query($sql);
	}
	$d->close();
}


dirtree("F:/xunlei7/xunlei7");
?>



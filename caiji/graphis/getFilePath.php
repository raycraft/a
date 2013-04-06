<?php
/**
 * Created on 2013-3-4
 * Enter description here ...
 *
 */
//include_once("conn.php");
include_once("conn.php");
header("Content-Type: text/html; charset=GB2312");
set_time_limit(0);
if($_GET[id]>443&& $_GET[id]){
	die("downLoad finished!");
}
$id = $_GET[id];
$sql2="select * from pagelink where id='$_GET[id]'";
$q2=mysql_query($sql2);
$row = mysql_fetch_array($q2);
echo "<pre>";
//print_r($row);
if($row[title]){
	//$path = "/home/wwwroot/data/attachment/forum/rosi/".$row[title];
	$path = "F:/xunlei7/xunlei7/".$row[title];
	globDir(iconv("UTF-8", "gb2312",$path),$id);
}

$id ++;
echo "<script>location.href='getFilePath.php?id=".$id."'</script>";


//-------------------------------------------------------
function globDir($path,$id=''){
	$current_dir = opendir($path);
	while(($file = readdir($current_dir)) !== false) {
		if($file == '.' || $file == '..') {
			continue;
		} else if(is_dir($sub_dir)) {
			echo 'Directory ' . $file . ':<br>';
			traverse($sub_dir);
		} else {
			$pos1 = strpos($file, '.jpg');
			$pos2 = strpos($file, '.JPG');
			$pos3 = strpos($file, 'gra');
			if($pos1 !== false || $pos2 !== false && $pos3 == true){
				$count ++;
				$newPath = substr($path,40);
				$newPath = "data/attachment/forum/rosi/".$newPath;
				$newPath = preg_replace('/\[/i','%5b',$newPath);
				$newPath = preg_replace('/\]/i','%5d',$newPath);
				$newPath = preg_replace('/\ /i','%20',$newPath);
				$newPath = preg_replace('/\+/i','%%%',$newPath);
				$pagelink .= "【用户=graphis】[img]".iconv("gb2312", "UTF-8",$newPath)."/".iconv("gb2312", "UTF-8",$file)."[/img]|||";
			}
		}
	}

	$pagelink = substr($pagelink, 0, -3);
	$sql="UPDATE  `caiji_graphis`.`pagelink` SET  `downloadPageLink` =  '".$pagelink."',`count` =  '".$count."' WHERE  `pagelink`.`id` =".$id.";";
	mysql_query($sql);
	$count = 0;
	$pagelink = '';
}

?>
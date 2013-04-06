<?php
/*
 *发布
 *
 *
 */
include_once("conn.php");
header("Content-Type: text/html; charset=utf-8");
set_time_limit(0);
if($_GET[id]>403&& $_GET[id]){
	die("downLoad finished!");
}
$id = $_GET[id];
$sql2="select * from pagelink where id='$_GET[id]'";
$q2=mysql_query($sql2);
$row = mysql_fetch_array($q2);
echo "<pre>";
//print_r($row);
if($row[title]){
	$pos = strpos($row[title], "ROSI365");
	if($pos !== false){
		$row[title] = substr($row[title],13);
	}
	
	//$title = substr($row[title], 47);
	
	$login_url        =    'http://www.gaofeiji.com/locoy_exec.php?action=newthread';
	//$login_url        =    'http://localhost/origin/locoy_exec.php?action=newthread';
	$post_fields    =    "fid=37&subject=".$row[title]."&message=".$row[downloadPageLink]."";

	$ch = curl_init($login_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
	$contents=curl_exec($ch);
	//print_r($contents);
	curl_close($ch);
}
$id ++;
echo "<script>location.href='updatePageLink.php?id=".$id."'</script>";



?>
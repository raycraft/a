<?php
/**
 * Created on 2013-1-24
 * Enter description here ...
 *
 */
mysql_connect("localhost","root","root",true);
mysql_select_db("dz_dz25");  //这个要换的
mysql_query("set names 'UTF8'");
header("Content-Type: text/html; charset=utf-8");
//$sql="select * from pre_forum_thread where tid='$_GET[id]'";
//$q=mysql_query($sql);
//$row = mysql_fetch_array($q);
//print_r($row);

$tid =$_GET[id];
$sql2="select * from pre_forum_post where tid='$tid' AND `first` = 1";
$q2=mysql_query($sql2);
$row2 = mysql_fetch_array($q2);
//echo "<pre />";
//print_r($row2);
$pid = $row2[pid];
$fid = $row2[fid];
$arr = array("[img]" => "", "[/img]" => "","[align=center]" => "","[/align]" => "","+" => "%%%");
$message = strtr($row2[message],$arr);
$message = "http://www.gaofeiji.com/".$message;
$login_url = "http://www.gaofeiji.com/forum.php?mod=ajax&action=setthreadcover&tid=".$tid."&pid=".$pid."&fid=".$fid."&imgurl=".$message."";
//echo strip_tags($login_url);
//$ch = curl_init($login_url);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//$contents=curl_exec($ch);
////print_r($contents);
//curl_close($ch);
//header("location:".$login_url."");
sleep(1);
echo "<script>location.href='".$login_url."'</script>";
//echo "<script>location.href='http://localhost/caiji/tumblr/setthreadcover.php?id=".$_GET[id]."'</script>";
?>
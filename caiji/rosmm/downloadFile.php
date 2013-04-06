<?php
/*
 *
 *
 *
 */
include_once("conn.php");
header("Content-Type: text/html; charset=gbk");
set_time_limit(0);
if($_GET[id]>51&& $_GET[id]){
	die("downLoad finished!");
}
$id = $_GET[id];
$sql2="select * from pagelink_list where id='$_GET[id]'";
$q2=mysql_query($sql2);
$row = mysql_fetch_array($q2);
echo "<pre>";
//print_r($row);
if($row[pageLink]){
	//========ï¿½Ö½ï¿½urlï¿½ï¿½ï¿½Ä¼ï¿½Ä¿Â¼==========
	$arr =explode("/", $row[pageLink]);
	//print_r($arr);
	$fileNumDir = explode(".", $arr[5]);
	$filepath = $arr[2].$arr[3].$arr[4]."/".$fileNumDir[0];
	//echo $filepath;
	//	echo "<br>";
	!is_dir($filepath)?@mkdir ($filepath, 0777, true) :null;
	//==========ï¿½ï¿½ï¿½Øµï¿½Ò»ï¿½ï¿½Ò³ï¿½ï¿½=======
	downloadCurrentPage($row[pageLink],$filepath);
	//=======ï¿½ï¿½Ò»Ò³ï¿½ï¿½ï¿½Ü¹ï¿½Ò³ï¿½ï¿½==========
	$ch = curl_init($row[pageLink]);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec($ch);
	//print_r($contents);
	curl_close($ch);
	$preg1 = "#<\/li>\s+<li><a\shref=\"(\d+)\_(\d+).htm\">Î²Ò³<\/a><\/li>#iUs";
	preg_match($preg1,$contents,$arr1);
	//print_r($arr1);

	for ($i = 2; $i <=$arr1[2]; $i++) {
		$nextPageLink = "http://www.rosmm.com/rosimm/".$arr[2]."/".$arr[3]."/".$arr[4]."/".$arr1[1]."_".$i.".htm";
		//echo $nextPageLink;
		//echo "<br />";
		//==========ÏÂÔØ===========
		downloadCurrentPage($nextPageLink,$filepath);
	}
}
$id ++;
echo "<script>location.href='downloadFile.php?id=".$id."'</script>";

/*
 *
 * $url ÒªÏÂÔØµÄÎÄ¼þµØÖ·
 * $filepath ÎÄ¼þÄ¿Â¼
 *
 */
function  downloadCurrentPage($url,$filepath){
	//opendir("./".$filepath."/");
	//Êý¾Ý¿â»ñÈ¡Ö®Ç°µÄphotoPageLinkList
	$sql="select * from pagelink_list where id='$_GET[id]'";
	$q=mysql_query($sql);
	$row = mysql_fetch_array($q);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec($ch);
	$preg = "#<a\shref=\"http://(.*)\"\starget#iUs";
	preg_match_all($preg,$contents,$arr);
	//print_r($arr);
	$photoPageLinkList = $row[photoPageLinkList];
	$fileDirList = $row[fileDirList];
	for ($i = 0; $i < count($arr[1]); $i++) {
		$explodeArr =explode("/", $arr[1][$i]);
		//print_r($explodeArr);
		//echo "<hr />";
		downloadDistantFile($arr[1][$i],$filepath."/".$explodeArr[6]);
		$photoPageLinkList .= $arr[1][$i]."|";
		$fileDirList .= $filepath."/".$explodeArr[6]."|";
	}
	$sql="UPDATE  `caiji_rosmm`.`pagelink_list` SET  `fileDirList` =  '".$fileDirList."',`photoPageLinkList` =  '".$photoPageLinkList."' WHERE  `pagelink_list`.`id` =".$_GET[id].";";
	mysql_query($sql);
}

function downloadDistantFile($url, $dest)
{

	$options = array(
	CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'wb+'),
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_URL => $url,
	CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
	);

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$return = curl_exec($ch);

	if ($return === false)
	{
		return curl_error($ch);
	}
	else
	{
		return true;
	}
}








//function    getfile($url,$target){
//	$ch = curl_init();
//	curl_setopt($ch, CURLOPT_URL, $url);
//	//$this_header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//	//curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
//	//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//	//curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//	$imageData = curl_exec($ch);
//	curl_close($ch);
//	$tp = @fopen($target, 'w',true);
//	fwrite($tp, $imageData);
//	fclose($tp);
//}

?>
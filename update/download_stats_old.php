<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>STANLEY CUP - HockeyArena.net Tournament</title>
<link rel="stylesheet" href="http://stanleycup.crash.sk/css/style_v19.css" type="text/css" media="screen" title="default">
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>

</head>
<body>
<div class="text"><br /><br />

<?php


echo "<center>stats downloaded<p></center>";



//$file = "teams.txt";
	

include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");



if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "playoff".$current_season;} else {$schedule = "schedule".$current_season;}


$schedule = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/$schedule.txt";

include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);
$today = date("d.m.Y");
$tmp_date = explode (".",$yesterday);
$update_yes = $tmp_date[0].".".$tmp_date[1].".".$tmp_date[2];


echo "<center><form name=\"write_schedule\" method=\"post\"><textarea type=\"text\" class=\"list\" name=\"write_schedule\" cols=\"100\" rows=\"40\"/>";

//$f = fopen($schedule,"r");
//	while(!feof($f)) {
//		$tmp = explode("|",fgets($f,2000));
//		if (trim($tmp[0]) != "") {
//			if($tmp[6] < 10) {$month = "0".$tmp[6];} else {$month = $tmp[6];}
//			$update_date = $tmp[5].".".$month.".".$tmp[7];
//			if($update_date == $update_yes) {
//			$team_long_1 = $tmp[1];
//			$team_long_2 = $tmp[2];
//			$team_id_1 = $tmp[3];
//			$team_id_2 = $tmp[4];
//			$team_short_1 = $tmp[8];
//			$team_short_2 = $tmp[9];
//			$group = $tmp[0];
//			
$id_match = "18033596";
			include("update_settings.php");
			$link = "$prefix/index.php?p=public_match_info.php&match_id=$id_match";
			
			
			
			curl_setopt($ch, CURLOPT_URL, $link);
			$result = curl_exec ($ch);
			curl_close ($ch); 
			$read = $result;
			
			
			// this gets rid of most of the CSS in the page
			$read = preg_replace("/<head>(.*)<\/select>/ism","",$read);
			$read = preg_replace("/footer(.*)<\/html>/ism","",$read);
			$read = preg_replace("/<!DOCTYPE(.*)<table width=\"700\"><tr><td valign=\"top\">/ism","",$read);
			$read_total = preg_replace("/<table width=\"500\">(.*)/ism","",$read);
			$read_team1 = preg_replace("/<\/table>(.*)/ism","",$read_total);
			$read_team2 = preg_replace("/(.*)<table width=\"355\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">/ism","",$read_total);
			$read_team1 = preg_replace("/<table width=\"355\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">/","",$read_team1);
			$read_team_name1 = preg_replace("/<tr class=\"ysptblthbody1\" align=\"right\">(.*)/ism","",$read_total);
			$read_team_name1 = strip_tags($read_team_name1);
			$read_team_name1 = trim($read_team_name1);
			$read_team_name1 = str_replace ("\\n","",$read_team_name1);
			$read_team_name2 = preg_replace("/<tr class=\"ysptblthbody1\" align=\"right\">(.*)/ism","",$read_team2);
			$read_team_name2 = strip_tags($read_team_name2);
			$read_team_name2 = trim($read_team_name2);
			$read_team_name2 = str_replace ("\\n","",$read_team_name2);
			$read_goalies_team1 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team1);
			$read_goalies_team1 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team1);
			$read_goalies_team1 = preg_replace("/(.*)<tr class=\"sr1\" align=\"right\">/ism","",$read_goalies_team1);
			$read_goalies_team1 = preg_replace("/<tr class=\"sr2\" align=\"right\">/ism","",$read_goalies_team1);
			$read_goalies_team1 = str_replace("id=","|",$read_goalies_team1);
			$read_goalies_team1 = str_replace("\">","\">|",$read_goalies_team1);
			$read_goalies_team1 = strip_tags($read_goalies_team1);
			$read_goalies_team1 = str_replace("                ","",$read_goalies_team1);
			$read_goalies_team1 = trim($read_goalies_team1);
			$read_goalies_team1 = str_replace("            \n","-",$read_goalies_team1);
			$read_goalies_team1 = str_replace(" |","",$read_goalies_team1);
			$read_goalies_team1 = str_replace("\n","",$read_goalies_team1);
			$read_goalies_team1 = str_replace("--","|".$read_team_name1."\n",$read_goalies_team1);
			
			
			$read_goalies_team2 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team2);
			$read_goalies_team2 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team2);
			$read_goalies_team2 = preg_replace("/(.*)<tr class=\"sr1\" align=\"right\">/ism","",$read_goalies_team2);
			$read_goalies_team2 = preg_replace("/<tr class=\"sr2\" align=\"right\">/ism","",$read_goalies_team2);
			$read_goalies_team2 = str_replace("id=","|",$read_goalies_team2);
			$read_goalies_team2 = str_replace("\">","\">|",$read_goalies_team2);
			$read_goalies_team2 = strip_tags($read_goalies_team2);
			//$read = strip_tags($read);
			
			echo $read_team_name1;
			echo "\n*************************************\n";
			echo $read_team_name2;
			echo "\n*************************************\n";
			echo $read_goalies_team1;
			echo "\n*************************************\n";
			echo $read_goalies_team2;
			echo "\n*************************************\n";
			echo $read_team1;
			echo "\n*************************************\n";
			echo $read_team2;
echo "</textarea>";



?>
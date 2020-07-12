

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>STANLEY CUP - HockeyArena.net Tournament</title>

<link rel="stylesheet" href="http://stanleycup.crash.sk/css/design_v3c.css" type="text/css" media="screen" title="default">
<meta http-equiv='Content-Type' content='text/html; charset=Utf-8'>

</head>
<body>
<div class="text"><br /><br />

<?php


echo "<center>stats downloaded<p></center>";



$upload_dir = ($_SERVER['DOCUMENT_ROOT']);


$cookie_file = "tmp/cookie/cookie.txt";
if (!file_exists($cookie_file)) {$fp_cookie_file = FOpen ($cookie_file, "w"); FClose ($fp_cookie_file);}

//prefix = "http://beta.hockeyarena.net/en";
$prefix = "http://www.hockeyarena.net/en";

$user_id = "Trsto"; 

$user_password = "sl765150he";
$my_team = "12576";


$url = "$prefix/index.php?p=security_log.php";



$LOGINURL = "$url";
$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (affgrabber)";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$LOGINURL);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($ch, CURLOPT_VERBOSE, 1); 
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_COOKIEFILE, "$cookie_file");
curl_setopt($ch, CURLOPT_COOKIEJAR, "$cookie_file");
$result = curl_exec ($ch);
curl_close ($ch);

// post the login data 

$LOGINURL = "$url";
$POSTFIELDS = "&nick=". $user_id ."&password=". $user_password;

// debugging
//echo $LOGINURL.$POSTFIELDS;

// not sure if this isneeded...


$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$LOGINURL);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTFIELDS); 
curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1); 
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANYSAFE); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// uncommenting the two below will give you debugging info...
//    curl_setopt($ch, CURLOPT_HEADER, 1);
//    curl_setopt($ch, CURLOPT_VERBOSE, 1); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

//$file = "teams.txt";
	

//include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");



//if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "playoff".$current_season;} else {$schedule = "schedule".$current_season;}
//
//
//$schedule = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/$schedule.txt";
//
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
//$yesterday = date("d.m.Y", $tmp_yesterday);
//$today = date("d.m.Y");
//$tmp_date = explode (".",$yesterday);
//$update_yes = $tmp_date[0].".".$tmp_date[1].".".$tmp_date[2];
//



//$f = fopen($schedule,"r");
//	while(!feof($f)) {
//		$tmp = explode("|",fgets($f,2000));
//		if (trim($tmp[0]) != "") {
//			
//			$update_date = $tmp[5].".".$tmp[6].".".$tmp[7];
//			
//			if($update_date == $update_yes) {
//			$id_match = trim($tmp[13]);
//
//			include("update_settings.php");
			$link = "$prefix/index.php?p=public_match_info.php&match_id=20907519";
			
			curl_setopt($ch, CURLOPT_URL, $link);
			$result = curl_exec ($ch);
			curl_close ($ch); 
			$read = $result;
			
			
			// this gets rid of most of the CSS in the page
			$read = preg_replace("/<head>(.*)<\/select>/ism","",$read);
			$read = preg_replace("/(.*)<\/ul>/ism","",$read);
            $read = preg_replace("/(.*)<div id=\"page\">/ism", "", $read);
			
			$readgame = $read;
			//$read = preg_replace("/<div(.*)<table width=\"100%\"><tr><td align=\'center\' valign=\"top\">/ism","",$read);
            
            
            
            //this displays current data
			echo "<form name=\"write_data_stats\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_data_stats\" cols=\"100\" rows=\"25\" >";
            echo $read;
            echo "</textarea><br />";
            echo $read;
            
			/*$read_total = preg_replace("/<table width=\"500\">(.*)/ism","",$read);

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
			$read_goalies_team1 = str_replace("<a href=\"index.php?p=public_player_info.inc&","",$read_goalies_team1);
			$read_goalies_team1 = strip_tags($read_goalies_team1);
			$read_goalies_team1 = str_replace("\">|","|",$read_goalies_team1);
			$read_goalies_team1 = str_replace("                ","",$read_goalies_team1);
			$read_goalies_team1 = trim($read_goalies_team1);
			$read_goalies_team1 = str_replace("            \n",";-",$read_goalies_team1);
			$read_goalies_team1 = str_replace(" |","",$read_goalies_team1);
			$read_goalies_team1 = str_replace("\n","",$read_goalies_team1);
			$read_goalies_team1 = str_replace(";-;-;","|".$read_team_name1."-|goalie\n",$read_goalies_team1);
			$read_goalies_team1 = str_replace("-|","|",$read_goalies_team1);
			$read_goalies_team1 = str_replace("&nbsp;","",$read_goalies_team1);
			$read_goalies_team1 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_goalies_team1); //iba toto funguje!!!
			$read_team1 = preg_replace("/(.*)<tr class=\"ysptblthbody1\" align=\"right\">/ism","",$read_team1);
			$read_team1 = str_replace("id=","|",$read_team1);
			$read_team1 = str_replace("\">","\">|",$read_team1);
			$read_team1 = str_replace("<a href=\"index.php?p=public_player_info.inc&","|",$read_team1);
			$read_team1 = strip_tags($read_team1);
			$read_team1 = str_replace("\">","",$read_team1);
			$read_team1 = str_replace("                ",";-",$read_team1);
			$read_team1 = str_replace(";-|","|",$read_team1);
			$read_team1 = str_replace("|;-;-","",$read_team1);
			$read_team1 = trim($read_team1);
			$read_team1 = str_replace("||","--",$read_team1);
			$read_team1 = str_replace("\n","",$read_team1);
			$read_team1 = str_replace("--","\n",$read_team1);
			$read_team1 = str_replace("                           ","|".$read_team_name1,$read_team1);
			$read_team1 = str_replace("&nbsp;","",$read_team1);
			$read_team1 = str_replace("|||".$read_team_name1,"\n---",$read_team1);
			$read_team1 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_team1);//iba toto funguje!!!
            
//			//
//			
			
			$read_goalies_team2 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team2);
			$read_goalies_team2 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team2);
			$read_goalies_team2 = preg_replace("/(.*)<tr class=\"sr1\" align=\"right\">/ism","",$read_goalies_team2);
			$read_goalies_team2 = preg_replace("/<tr class=\"sr2\" align=\"right\">/ism","",$read_goalies_team2);
			$read_goalies_team2 = str_replace("id=","|",$read_goalies_team2);
			$read_goalies_team2 = str_replace("\">","\">|",$read_goalies_team2);
			$read_goalies_team2 = str_replace("<a href=\"index.php?p=public_player_info.inc&","",$read_goalies_team2);
			$read_goalies_team2 = strip_tags($read_goalies_team2);
			$read_goalies_team2 = str_replace("\">|","|",$read_goalies_team2);
			$read_goalies_team2 = str_replace("                ","",$read_goalies_team2);
			$read_goalies_team2 = trim($read_goalies_team2);
			$read_goalies_team2 = str_replace("            \n",";-",$read_goalies_team2);
			$read_goalies_team2 = str_replace(" |","",$read_goalies_team2);
			$read_goalies_team2 = str_replace("\n","",$read_goalies_team2);
			$read_goalies_team2 = str_replace(";-;-;","|".$read_team_name2."-|goalie\n",$read_goalies_team2);
			$read_goalies_team2 = str_replace("-|","|",$read_goalies_team2);
			$read_goalies_team2 = str_replace("&nbsp;","",$read_goalies_team2);
			$read_goalies_team2 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_goalies_team2);//iba toto funguje!!!
			$read_team2 = preg_replace("/(.*)<tr class=\"ysptblthbody1\" align=\"right\">/ism","",$read_team2);
			$read_team2 = str_replace("id=","|",$read_team2);
			$read_team2 = str_replace("\">","\">|",$read_team2);
			$read_team2 = str_replace("<a href=\"index.php?p=public_player_info.inc&","|",$read_team2);
			$read_team2 = strip_tags($read_team2);
			$read_team2 = str_replace("\">","",$read_team2);
			$read_team2 = str_replace("                ",";-",$read_team2);
			$read_team2 = str_replace(";-|","|",$read_team2);
			$read_team2 = str_replace("|;-;-","",$read_team2);
			$read_team2 = trim($read_team2);
			$read_team2 = str_replace("||","--",$read_team2);
			$read_team2 = str_replace("\n","",$read_team2);
			$read_team2 = str_replace("--","\n",$read_team2);
			$read_team2 = str_replace("                           ","|".$read_team_name2,$read_team2);
			$read_team2 = str_replace("&nbsp;","",$read_team2);
			$read_team2 = str_replace("|||".$read_team_name2,"\n---",$read_team2);
			$read_team2 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_team2);//iba toto funguje!!!*/
			//$read_team2 = iconv('Utf-8', 'Windows-1250', $read_team2);
			
			//$read = strip_tags($read);
			
			//echo $read_team_name1;
			
			//echo $read_team_name2;
			
/*			$data_read[] = $read;
			
			$data_goalies2[] = $read_goalies_team2;
			
			$data_team1[] = $read_team1;
			
			$data_team2[] = $read_team2;*/
//			}
//		}
//	}
	
/*
echo "<form name=\"write_data_stats\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_data_stats\" cols=\"100\" rows=\"25\" >";
foreach ($data_read as $read_) {
	echo $read."\n";
}*/
/*foreach ($data_team2 as $read_team2) {
	echo $read_team2."\n";
}*/
/*echo "</textarea>";
echo "<br /><textarea readonly=\"readonly\" class=\"list\" name=\"write_data_stats_goalies\" cols=\"100\" rows=\"15\" >";*/
/*foreach ($data_goalies1 as $read_goalies_team1) {
	echo $read_goalies_team1."\n";
}
foreach ($data_goalies2 as $read_goalies_team2) {
	echo $read_goalies_team2."\n";
}*/
/*echo "</textarea>";*/
//echo $readgame;

/*echo "\n<br /><input type=\"hidden\" name=\"ok1\" value=\"ok\">\n<br />write data --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form><br />";

*/
?>
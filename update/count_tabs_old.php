<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>STANLEY CUP - HockeyArena.net Tournament</title>
<link rel="stylesheet" href="http://stanleycup.crash.sk/css/style_v19.css" type="text/css" media="screen" title="default">
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1250" >
</head>
<body>
<div class="text">


<?php
include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");

if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "playoff".$current_season;} else {$schedule = "schedule".$current_season;}
$tab_file = ($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/standings/standings".$current_season.".txt");

$schedule = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/$schedule.txt";
$team_list = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams.txt";

//spocita body
echo "<center><br /><br /><form name=\"write_tabs\" method=\"post\"><input type=\"hidden\" class=\"list\" name=\"write_tabs\" value= \"";
$f = fopen($team_list,"r");
while(!feof($f)) {
	$tmp_team = explode("|",fgets($f,2000));
	if (trim($tmp_team[0]) !== "") {
		$f_schedule = fopen($schedule,"r");
		$win = 0; $tie = 0; $loss = 0; $scored = 0; $allowed = 0;	
		while(!feof($f_schedule)) {
			$tmp_schedule = explode("|",fgets($f_schedule,2000));
			if($tmp_team[0] == $tmp_schedule[8]) {
				if($tmp_schedule[10] !== "?") {
					if ($tmp_schedule[10] > $tmp_schedule[11]) {$win = $win + 1;}
					if($tmp_schedule[10] == $tmp_schedule[11]) {$tie = $tie + 1;}
					if ($tmp_schedule[10] < $tmp_schedule[11]) {$loss = $loss + 1;}
					$scored = $scored + $tmp_schedule[10];
					$allowed = $allowed + $tmp_schedule[11];
				}
			}
			if($tmp_team[0] == $tmp_schedule[9]) {if($tmp_schedule[10] !== "?") {
					if ($tmp_schedule[11] > $tmp_schedule[10]) {$win = $win + 1;}
					if ($tmp_schedule[11] == $tmp_schedule[10]) {$tie = $tie + 1;}
					if ($tmp_schedule[11] < $tmp_schedule[10]) {$loss = $loss + 1;}
					$scored = $scored + $tmp_schedule[11];
					$allowed = $allowed + $tmp_schedule[10];
				}
			}
		}
		if($tmp_team[11] == 1) {$conf = "east";}
		if($tmp_team[11] == 0) {$conf = "west";}
		$points = $win * 2 + $tie; $score = $scored - $allowed;
		$write = "$points|$tmp_team[0]|$tmp_team[1]|$tmp_team[2]|$tmp_team[3]|$conf|$win|$tie|$loss|$scored|$allowed|$score--";
		echo $write;
	}
}Fclose($f);


echo "\"></input>\n<br /><input type=\"hidden\" name=\"ok1\" value=\"ok\">\ncalculate points --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form><br />";



include("update_date.php");
//	$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	$yesterday = date("d.m.Y", $tmp_yesterday);	

//zapise tmp tabulku s bodmi
if ($ok1 == "ok") {
	$write_tabs = str_replace("--","\n",$write_tabs);

	$file_tmp_points = "tmp/tmp_count_standings_$yesterday.txt";
			$write = StripSlashes($write_tabs."\n");
			$fp = FOpen ($file_tmp_points, "w");
			FWrite ($fp, $data.$write_tabs);
			FClose ($fp);



$file_tmp_points = "tmp/tmp_count_standings_$yesterday.txt";



//sort divizie
$f = fopen($file_tmp_points,"r");
while(!feof($f)) {
	$tmp_points = explode("|",fgets($f,2000));
	if (trim($tmp_points[0]) !== "") {
		if($tmp_points[3] == "atlantic") {
			if($tmp_points[0] < 10) {$points = "0".$tmp_points[0];} else {$points = $tmp_points[0];}
			if($tmp_points[6] < 10) {$win = "0".$tmp_points[6];} else {$win = $tmp_points[0];}
			$score = $tmp_points[9] - $tmp_points[10] + 2000;
			if(($tmp_points[9] < 10)) {$scored = "00".$tmp_points[9];} elseif(($tmp_points[9] < 100)&&($tmp_points[9] > 10)) {$scored = "0".$tmp_points[9];} else {$scored = $tmp_points[9];}
			$row_at = $points."|".$win."|".$score."|".$scored."||".$tmp_points[0]."|".$tmp_points[1]."|".$tmp_points[2]."|".$tmp_points[3]."|".$tmp_points[4]."|".$tmp_points[5]."|".$tmp_points[6]."|".$tmp_points[7]."|".$tmp_points[8]."|".$tmp_points[9]."|".$tmp_points[10];
			$sort_at[] = $row_at;
		}
	}
}fclose($f);
arsort($sort_at);
$z = 1;
		foreach ($sort_at as $row_at){
			$at[$z]=$row_at."|".$z; $z++;
	}

$f = fopen($file_tmp_points,"r");
while(!feof($f)) {
	$tmp_points = explode("|",fgets($f,2000));
	if (trim($tmp_points[0]) !== "") {
		if($tmp_points[3] == "pacific") {
			if($tmp_points[0] < 10) {$points = "0".$tmp_points[0];} else {$points = $tmp_points[0];}
			if($tmp_points[6] < 10) {$win = "0".$tmp_points[6];} else {$win = $tmp_points[0];}
			$score = $tmp_points[9] - $tmp_points[10] + 2000;
			if(($tmp_points[9] < 10)) {$scored = "00".$tmp_points[9];} elseif(($tmp_points[9] < 100)&&($tmp_points[9] > 10)) {$scored = "0".$tmp_points[9];} else {$scored = $tmp_points[9];}
			$row_pa = $points."|".$win."|".$score."|".$scored."||".$tmp_points[0]."|".$tmp_points[1]."|".$tmp_points[2]."|".$tmp_points[3]."|".$tmp_points[4]."|".$tmp_points[5]."|".$tmp_points[6]."|".$tmp_points[7]."|".$tmp_points[8]."|".$tmp_points[9]."|".$tmp_points[10];
			$sort_pa[] = $row_pa;
		}
	}
}fclose($f);
arsort($sort_pa);
$z = 1;
		foreach ($sort_pa as $row_pa){
			$pa[$z]=$row_pa."|".$z; $z++;
	}

$f = fopen($file_tmp_points,"r");
while(!feof($f)) {
	$tmp_points = explode("|",fgets($f,2000));
	if (trim($tmp_points[0]) !== "") {
		if($tmp_points[3] == "central") {
			if($tmp_points[0] < 10) {$points = "0".$tmp_points[0];} else {$points = $tmp_points[0];}
			if($tmp_points[6] < 10) {$win = "0".$tmp_points[6];} else {$win = $tmp_points[0];}
			$score = $tmp_points[9] - $tmp_points[10] + 2000;
			if(($tmp_points[9] < 10)) {$scored = "00".$tmp_points[9];} elseif(($tmp_points[9] < 100)&&($tmp_points[9] > 10)) {$scored = "0".$tmp_points[9];} else {$scored = $tmp_points[9];}
			$row_ce = $points."|".$win."|".$score."|".$scored."||".$tmp_points[0]."|".$tmp_points[1]."|".$tmp_points[2]."|".$tmp_points[3]."|".$tmp_points[4]."|".$tmp_points[5]."|".$tmp_points[6]."|".$tmp_points[7]."|".$tmp_points[8]."|".$tmp_points[9]."|".$tmp_points[10];
			$sort_ce[] = $row_ce;
		}
	}
}fclose($f);
arsort($sort_ce);
$z = 1;
		foreach ($sort_ce as $row_ce){
			$ce[$z]=$row_ce."|".$z; $z++;
	}
	
$f = fopen($file_tmp_points,"r");
while(!feof($f)) {
	$tmp_points = explode("|",fgets($f,2000));
	if (trim($tmp_points[0]) !== "") {
		if($tmp_points[3] == "southeast") {
			if($tmp_points[0] < 10) {$points = "0".$tmp_points[0];} else {$points = $tmp_points[0];}
			if($tmp_points[6] < 10) {$win = "0".$tmp_points[6];} else {$win = $tmp_points[0];}
			$score = $tmp_points[9] - $tmp_points[10] + 2000;
			if(($tmp_points[9] < 10)) {$scored = "00".$tmp_points[9];} elseif(($tmp_points[9] < 100)&&($tmp_points[9] > 10)) {$scored = "0".$tmp_points[9];} else {$scored = $tmp_points[9];}
			$row_se = $points."|".$win."|".$score."|".$scored."||".$tmp_points[0]."|".$tmp_points[1]."|".$tmp_points[2]."|".$tmp_points[3]."|".$tmp_points[4]."|".$tmp_points[5]."|".$tmp_points[6]."|".$tmp_points[7]."|".$tmp_points[8]."|".$tmp_points[9]."|".$tmp_points[10];
			$sort_se[] = $row_se;
		}
	}
}fclose($f);
arsort($sort_se);
$z = 1;
		foreach ($sort_se as $row_se){
			$se[$z]=$row_se."|".$z; $z++;
	}
	
$f = fopen($file_tmp_points,"r");
while(!feof($f)) {
	$tmp_points = explode("|",fgets($f,2000));
	if (trim($tmp_points[0]) !== "") {
		if($tmp_points[3] == "northwest") {
			if($tmp_points[0] < 10) {$points = "0".$tmp_points[0];} else {$points = $tmp_points[0];}
			if($tmp_points[6] < 10) {$win = "0".$tmp_points[6];} else {$win = $tmp_points[0];}
			$score = $tmp_points[9] - $tmp_points[10] + 2000;
			if(($tmp_points[9] < 10)) {$scored = "00".$tmp_points[9];} elseif(($tmp_points[9] < 100)&&($tmp_points[9] > 10)) {$scored = "0".$tmp_points[9];} else {$scored = $tmp_points[9];}
			$row_nw = $points."|".$win."|".$score."|".$scored."||".$tmp_points[0]."|".$tmp_points[1]."|".$tmp_points[2]."|".$tmp_points[3]."|".$tmp_points[4]."|".$tmp_points[5]."|".$tmp_points[6]."|".$tmp_points[7]."|".$tmp_points[8]."|".$tmp_points[9]."|".$tmp_points[10];
			$sort_nw[] = $row_nw;
		}
	}
}fclose($f);
arsort($sort_nw);
$z = 1;
		foreach ($sort_nw as $row_nw){
			$nw[$z]=$row_nw."|".$z; $z++;
	}
	
$f = fopen($file_tmp_points,"r");
while(!feof($f)) {
	$tmp_points = explode("|",fgets($f,2000));
	if (trim($tmp_points[0]) !== "") {
		if($tmp_points[3] == "northeast") {
			if($tmp_points[0] < 10) {$points = "0".$tmp_points[0];} else {$points = $tmp_points[0];}
			if($tmp_points[6] < 10) {$win = "0".$tmp_points[6];} else {$win = $tmp_points[0];}
			$score = $tmp_points[9] - $tmp_points[10] + 2000;
			if(($tmp_points[9] < 10)) {$scored = "00".$tmp_points[9];} elseif(($tmp_points[9] < 100)&&($tmp_points[9] > 10)) {$scored = "0".$tmp_points[9];} else {$scored = $tmp_points[9];}
			$row_ne = $points."|".$win."|".$score."|".$scored."||".$tmp_points[0]."|".$tmp_points[1]."|".$tmp_points[2]."|".$tmp_points[3]."|".$tmp_points[4]."|".$tmp_points[5]."|".$tmp_points[6]."|".$tmp_points[7]."|".$tmp_points[8]."|".$tmp_points[9]."|".$tmp_points[10];
			$sort_ne[] = $row_ne;
		}
	}
}fclose($f);
arsort($sort_ne);
$z = 1;
		foreach ($sort_ne as $row_ne){
			$ne[$z]=$row_ne."|".$z; $z++;
	}
	echo "<br /><br />";



//sort konferencie
echo "<center><form name=\"write_tabs\" method=\"post\"><textarea type=\"text\" class=\"list\" name=\"write_tabs\" cols=\"100\" rows=\"40\"/>";

$y = 1;	
$east_conf_1 = array ($at[1], $se[1], $ne[1]);
arsort($east_conf_1);
foreach ($east_conf_1 as $conf_1) {
		$tmp_conf1 = explode ("|", $conf_1);
		$write_conf1 = $tmp_conf1[6]."|".$tmp_conf1[7]."|".$tmp_conf1[9]."|".$tmp_conf1[8]."|".ucfirst($tmp_conf1[10])."|".$y."|".$tmp_conf1[16]."|".$tmp_conf1[11]."|".$tmp_conf1[12]."|".$tmp_conf1[13]."|".$tmp_conf1[14]." : ".$tmp_conf1[15]."|".$tmp_conf1[5];
		echo $write_conf1."\n"; $y++;
}
$y = 4;
$east_conf_2 = array ($at[2], $at[3], $at[4], $at[5], $se[2], $se[3], $se[4], $se[5], $ne[2], $ne[3], $ne[4], $ne[5]);
arsort($east_conf_2);
foreach ($east_conf_2 as $conf_2) {
		$tmp_conf2 = explode ("|", $conf_2);
		$write_conf2 = $tmp_conf2[6]."|".$tmp_conf2[7]."|".$tmp_conf2[9]."|".$tmp_conf2[8]."|".ucfirst($tmp_conf2[10])."|".$y."|".$tmp_conf2[16]."|".$tmp_conf2[11]."|".$tmp_conf2[12]."|".$tmp_conf2[13]."|".$tmp_conf2[14]." : ".$tmp_conf2[15]."|".$tmp_conf2[5];
		echo $write_conf2."\n"; $y++;
}
echo "\n\n";
$y = 1;	
$west_conf_1 = array ($nw[1], $ce[1], $pa[1]);
arsort($west_conf_1);
foreach ($west_conf_1 as $conf_3) {
		$tmp_conf3 = explode ("|", $conf_3);
		$write_conf3 = $tmp_conf3[6]."|".$tmp_conf3[7]."|".$tmp_conf3[9]."|".$tmp_conf3[8]."|".ucfirst($tmp_conf3[10])."|".$y."|".$tmp_conf3[16]."|".$tmp_conf3[11]."|".$tmp_conf3[12]."|".$tmp_conf3[13]."|".$tmp_conf3[14]." : ".$tmp_conf3[15]."|".$tmp_conf3[5];
		echo $write_conf3."\n"; $y++;
}
$y = 4;
$west_conf_2 = array ($nw[2], $nw[3], $nw[4], $nw[5], $ce[2], $ce[3], $ce[4], $ce[5], $pa[2], $pa[3], $pa[4], $pa[5]);
arsort($west_conf_2);
foreach ($west_conf_2 as $conf_4) {
		$tmp_conf4 = explode ("|", $conf_4);
		$write_conf4 = $tmp_conf4[6]."|".$tmp_conf4[7]."|".$tmp_conf4[9]."|".$tmp_conf4[8]."|".ucfirst($tmp_conf4[10])."|".$y."|".$tmp_conf4[16]."|".$tmp_conf4[11]."|".$tmp_conf4[12]."|".$tmp_conf4[13]."|".$tmp_conf4[14]." : ".$tmp_conf4[15]."|".$tmp_conf4[5];
		echo $write_conf4."\n"; $y++;
}

echo "</textarea>\n<br /><input type=\"hidden\" name=\"ok\" value=\"ok\"><input type=\"hidden\" name=\"ok1\" value=\"ok\"><br />\n write tabs --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form>";



//zapise tabulky
if ($ok == "ok") {
	$file_write_tabs = $tab_file;
			$write_tabs = StripSlashes($write_tabs."\n");

		
		
			$fp_write_tabs = FOpen ($file_write_tabs, "w");
			FWrite ($fp_write_tabs, $write_tabs);
			FClose ($fp_write_tabs);
	
	$done = "done";	
	echo "<center><br />done!<center>";

}
}
?>

</div>
</body>
</html>
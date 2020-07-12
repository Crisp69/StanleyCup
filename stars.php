<?php
function parsestarfull_old($s) {
	$upload_dir = "data/stars";

	echo "<div class=\"text\"><b>: Heroes of the Weekend</b></div><br />";
	
	echo "<center><table width=\"95%\"><tr><td>";
	
	$f = fopen($upload_dir."/star".$s.".txt","r");
	$z = 1;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) != "") {
			echo "<table class=\"awards_small\" width=\"23%\" height=\"220px\" align=\"left\">";
			echo "<tr><td align=\"center\"><span class=\"note\">".trim($tmp[0])."</span></td></tr>";
			echo "<tr height=\"30px\"><td valign=\"top\" align=\"center\"><a title=\"$tmp[1]\" rel=\"shadowbox;width=1100;height=600\" class=\"text1\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&id=$tmp[4]\"><b>".trim($tmp[1])."</b></a></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><img src=\"img/winners/star/".trim($tmp[2]).".jpg\" alt=\"picture not loaded\" title=\"Weekend Star: $tmp[1]\"></span></td></tr>";
			echo "<tr height=\"20px\"><td align=\"center\"><span class=\"text\">".trim($tmp[3])."</span></td></tr></table>";
			}
				if ($z ==4) {echo "</td></tr><tr><td>"; $z = 1;} else $z++;
			}
	echo "</td></tr></table></center>";
}

function parsestarfull($s, $hilight) {global $current_season, $s;
	$upload_dir = "data/stars/";
	$n = "star";
	$k = ".txt";
	
	
	$g = ($upload_dir.$n.$current_season.".txt");
	if (file_exists($g)) {$star_season = $current_season;} else {$star_season = $current_season-1;}
	if (!isset($s)) {$s = $star_season;}
	$f2 = $n.$s.$k;

	
	if (File_Exists($upload_dir . $f2)) {
	$f = fopen($upload_dir.$f2,"r");
	if ($s <17) {
	echo "<div class=\"text\"><b>: Stars of the Weekend - $s. season</b></div>";} else {echo "<b>: Stars of the Night - $s. season</b>";}
	
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) != "") {
			echo "<div class=\"headline\"><center>".trim($tmp[0])."</center></div><br />";
			echo "<table align=\"center\"><tr><td>";
			echo "<table class=\"awards_small\" width=\"140px\" height=\"220px\" align=\"left\">";
			echo "<tr class=\"trhead\"><td align=\"center\">1st STAR</td></tr>";
			echo "<tr height=\"30px\"><td valign=\"center\" align=\"center\"><a title=\"$tmp[1]\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&id=$tmp[4]\"><b>".trim($tmp[1])."</b></a></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><img src=\"img/winners/star/".trim($tmp[2]).".jpg\" alt=\"picture not loaded\" title=\"1st Star: $tmp[1]\"></span></td></tr>";
			echo "<tr height=\"30px\"><td align=\"center\"><span class=\"text\">".trim($tmp[3])."</span></td></tr></table>";
			
			echo "<table class=\"awards_small\" width=\"140px\" height=\"220px\" align=\"left\">";
			echo "<tr class=\"trhead\"><td align=\"center\">2nd STAR</td></tr>";
			echo "<tr height=\"30px\"><td valign=\"center\" align=\"center\"><a title=\"$tmp[5]\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&id=$tmp[8]\"><b>".trim($tmp[5])."</b></a></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><img src=\"img/winners/star/".trim($tmp[6]).".jpg\" alt=\"picture not loaded\" title=\"2nd Star: $tmp[5]\"></span></td></tr>";
			echo "<tr height=\"30px\"><td align=\"center\"><span class=\"text\">".trim($tmp[7])."</span></td></tr></table>";
			
			echo "<table class=\"awards_small\" width=\"140px\" height=\"220px\" align=\"left\">";
			echo "<tr class=\"trhead\"><td align=\"center\">3rd STAR</td></tr>";
			echo "<tr height=\"30px\"><td valign=\"center\" align=\"center\"><a title=\"$tmp[9]\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_player_info.inc&id=$tmp[12]\"><b>".trim($tmp[9])."</b></a></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><img src=\"img/winners/star/".trim($tmp[10]).".jpg\" alt=\"picture not loaded\" title=\"3rd Star: $tmp[9]\"></span></td></tr>";
			echo "<tr height=\"30px\"><td align=\"center\"><span class=\"text\">".trim($tmp[11])."</span></td></tr></table>";
			echo "</td></tr>";
			echo "</table>";}

		} if (File_Exists("data/stats/stars".$s."reg.txt")) {echo "<br /><br /><center><b>Stars overview</b></center><br />"; 	include ("stats_function.php");
	parsestats($s, $pos = "stars", $type = "reg", $team, $statscount = 1000, $hilight, $sort, $page, $active);}
	}
	else {echo "<br /><br /><center>[no stars of the weekend available for $s. season]</center>";}
}

function parseseasonlist_stars() {global $s, $current_season;
	$upload_dir = "data/default/";
	$n = "season.txt";

	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose season...</option>";

	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if (($tmp[0] == "01") || ($tmp[0] == "02") || ($tmp[0] == "03") || ($tmp[0] == "04") || ($tmp[0] == "05") || ($tmp[0] == "06") || ($tmp[0] == "07") || ($tmp[0] == "08") || ($tmp[0] == "09") || ($tmp[0] == "10") || ($tmp[0] == "11")) {echo "";} else {
			echo "<option value=\"sc.php?id=stars.php&s=".trim($tmp[0])."\">".trim($tmp[0]).". season </option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table><br />";
}

?>
		


<?php
if($include_check == "bXnqwa") {

	if (!isset($s)) {
	$s = $stats_season;
	}
	parseseasonlist_stars();
	if (($s == 12) || ($s == 13)) {parsestarfull_old($s);} else {parsestarfull($s, $hilight);}
	echo "<br />";

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
		
?>
<?php
//do function treba $hilight pre zvyraznenie...

function parsestandings($s, $div, $conf) {global $current_season, $hilight;
	$upload_dir = "data/standings/";
	$n = "standings";
	$k = ".txt";
	if ((!IsSet($s) || $s == "")) {$s = $current_season;}	
	$f2 = $n.$s.$k;
if (file_exists($upload_dir."/".$f2)) {	
	$c = 0;
	
	echo "<table align=\"center\" class=\"overview\"><tr><th width=\"45%\" colspan=\"3\">\n";
	if ($div == "all") {echo "&nbsp;".StrToUpper($conf."ERN");} else {echo "&nbsp;".strtoupper($div);}
	echo "</th><th width=\"9%\" align=\"center\" title=\"wins\">W</th><th width=\"9%\" align=\"center\" title=\"ties\">T</th><th width=\"9%\" align=\"center\" title=\"losses\">L</th><th width=\"16%\" align=\"center\" colspan=\"2\">Score</th><th width=\"7%\" align=\"center\" title=\"points\">P</th><th width=\"5%\">&nbsp;</th></tr>\n";
	$z= 1;
	if ($div != "all") {
		$f = fopen($upload_dir . $f2, "r");
		while (!feof($f)) {$diff = 0;
			$tmp = explode("|", fgets($f, 2000));
			if (trim($tmp[0]) != "") {
                if ($div == trim($tmp[3])) {
                    if(trim($tmp[0]) == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                    
					echo "<td width=\"5%\">&nbsp;$tmp[6].</td>";
					echo "<td width=\"7%\"><a href=\"sc.php?id=teams.php&team=$tmp[0]\"><img width=\"33px\" class=\"logo\" src=\"img/team_logo/small/$tmp[0].png\" alt=\"$tmp[1]\" title=\"$tmp[1]\"></td>";
					echo "<td><a title=\"$tmp[1]\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_team_info_basic.php&team_id=$tmp[2]\" target=\"_blank\">$tmp[1]</a></td>";
					echo "<td align=\"center\">$tmp[7]</td>";
					echo "<td align=\"center\">$tmp[8]</td>";
					echo "<td align=\"center\">$tmp[9]</td>";
					echo "<td align=\"right\">$tmp[10]</td>";
                    $tmp_diff = explode(" : ",$tmp[10]);
                    $diff = $tmp_diff[0] - $tmp_diff[1];
                    echo "<td align=\"left\">&nbsp;";
                    if($diff > 0) {echo "<span class=\"textgreen_small\">+$diff</span>";} elseif($diff == 0) {echo "<span class=\"text_small\">$diff</span>";} else {echo "<span class=\"textred_small\">$diff</span>";}
                    echo "</td>";
					echo "<td align=\"center\">$tmp[11]</td>";
					echo "<td align=\"right\"><a href=\"sc.php?id=schedule.php&s=$s&type=reg&team=$tmp[0]\"><img title=\"schedule\" alt=\"cal\" src=\"img/s_cal.gif\"></a></td></tr>\n";
					}$c++;
				}
			}fclose($f);
		}
	elseif ($div = "all") {
		$f = fopen($upload_dir . $f2, "r");
		while (!feof($f)) {
			$tmp = explode("|", fgets($f, 2000));
			if (trim($tmp[0]) != "") {
				if ($conf == trim($tmp[4])) {
				    if(trim($tmp[0]) == $hilight) {if ($tmp[5]=="8") {echo "<tr class=\"hilight\" style=\"border-bottom:1px dashed #C6AD96\"\">";} else {echo "<tr class=\"hilight\">";} if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {if ($tmp[5]=="8") {echo "<tr style=\"border-bottom:1px dashed #C6AD96\"\">";} else {echo "<tr>";} $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                    echo "<td width=\"5%\">";
					if (($tmp[5] == "1") || ($tmp[5] == "2") || ($tmp[5] == "3")) {echo "&nbsp;$tmp[5].*";} else {echo "&nbsp;$tmp[5].";}
					echo "</td>";
					echo "<td width=\"7%\"><a href=\"sc.php?id=teams.php&team=$tmp[0]\"><img width=\"33px\" class=\"logo\" src=\"img/team_logo/small/$tmp[0].png\" alt=\"$tmp[1]\" title=\"$tmp[1]\"></td>";
					echo "<td><a class=\"text1\" title=\"$tmp[1]\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/index.php?p=public_team_info_basic.php&team_id=$tmp[2]\" target=\"_blank\">";
					if ($tmp[12]==1) {echo "<b>$tmp[1]</b>";} else { echo "$tmp[1]";}
					echo "</a></td>";
					echo "<td align=\"center\">$tmp[7]</td>";
					echo "<td align=\"center\">$tmp[8]</td>";
					echo "<td align=\"center\">$tmp[9]</td>";
					echo "<td align=\"right\">$tmp[10]</td>";
                    $tmp_diff = explode(" : ",$tmp[10]);
                    $diff = $tmp_diff[0] - $tmp_diff[1];
                    echo "<td align=\"left\">&nbsp;";
                    if($diff > 0) {echo "<span class=\"textgreen_small\">+$diff</span>";} elseif($diff == 0) {echo "<span class=\"text_small\">$diff</span>";} else {echo "<span class=\"textred_small\">$diff</span>";}
                    echo "</td>";
					echo "<td align=\"center\">$tmp[11]</td>";
					echo "<td align=\"right\"><a href=\"sc.php?id=schedule.php&s=$s&type=reg&team=$tmp[0]\"><img title=\"schedule\" alt=\"cal\" src=\"img/s_cal.gif\"></a></td></tr>\n";
					}$c++;
				}
			}fclose($f);
		}
	echo "</table><br />";
}	

}


function parsestandings_old($s) {global $current_season;
	$upload_dir = "data/standings";
	$n = "standings";
	$k = ".html";
	$f2 = $n.$s.$k;
	if (file_exists($upload_dir."/".$f2)) {
	include($upload_dir."/".$f2);	

	}
}

?>
<? 

if($include_check == "bXnqwa") {

    global $s;
	$upload_dir = "data/standings/";
	$n = "standings";
	$k = ".txt";
	
	$g = ($upload_dir.$n.$current_season.".txt");
	if (file_exists($g)) {$standing_season = $current_season;} else {$standing_season = $current_season-1;}
	if ((!IsSet($s) || $s == "")) {$s = $standing_season;}	
	
	parseseasonlist_standings();
	echo "<br />";
	
	if (($s == "01")) {parsestandings_old($s);} else {
		$upload_dir = "data/standings/";
		$n = "standings";
		$k = ".txt";
		if ((!IsSet($s) || $s == "")) {$s = $current_season;}	
		$f2 = $n.$s.$k;
		if (file_exists($upload_dir."/".$f2)) {	
			echo "<div class=\"text\"><b>: divisions standings Stanley Cup $s</b></div><br /><br />";
			parsestandings($s, $div = "atlantic", $conf);
			parsestandings($s, $div = "southeast", $conf);
			parsestandings($s, $div = "northeast", $conf);
			parsestandings($s, $div = "central", $conf);
			parsestandings($s, $div = "northwest", $conf);
			parsestandings($s, $div = "pacific", $conf);
			echo "<br /><div class=\"text\"><b>: conference standings Stanley Cup $s</b></div><br />";
			parsestandings($s, $div = "all", $conf = "East");
			parsestandings($s, $div = "all", $conf = "West");
			if ($s == "11") {echo "<div class=\"text\">All Chicago Blackhawks games in season 11 were cancelled<p></div>";}
			echo "<div class=\"text\">notes:<br />* - division leader<br />secured playoff in <b>bold</b><br /></div>";
			}
		else {echo "<br /><br /><center>no standings available for season $s</center>";}
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>


	
<?php
$help = "<center><a class=\"note\" href=\"javascript:popup_show('popup', 'popup_drag', 'popup_exit');\">[challenge help]</a></center><br />\n<div class=\"sample_popup\" id=\"popup\" style=\"display: none;\">\n<div id=\"popup_drag\"><img class=\"menu_form_exit\" id=\"popup_exit\" title=\"close\" src=\"img/form_exit.png\" alt=\"\" /></div>you are allowed to play at any stadium for higher income if you both agree on it, otherwise first team in the line is considered as home team<p>to challenge your opponent click directly <b>home (H)</b> or <b>away (A)</b> bellow (at) your opponent team's name<p><b>home</b> - you will play at your home stadium<br /><b>away</b> - you will play at your opponent's stadium<p><b>you must be logged to hockeyarena to send challenges directly from here!</b></div>";


function parseteamname_schedule($team)
{
	$f = fopen("data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {
				echo "$tmp[2]";
			}
		}
	}fclose($f);
}

function parseteamslist_teams_schedule() {global $team, $s, $type;
	
	$c = 0;
	echo "<table align=\"center\">";
	echo "<tr><td><span class=\"note\">view schedule by team: </span></td><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"sc.php?id=schedule.php&amp;s=$s&amp;type=$type&amp;team=all\">full schedule&nbsp;&nbsp;</option>\n";
	$f = fopen("data/default/teams_list.txt","r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {echo "<option SELECTED value=\"sc.php?id=$id&amp;amp;team=".trim($tmp[1])."\">".trim($tmp[0])."</option>";}
			else {echo "<option value=\"sc.php?id=schedule.php&amp;s=$s&amp;type=$type&amp;team=".trim($tmp[1])."\">".trim($tmp[0])."</option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table><br />";
}	
	

function parseschedule($s, $type, $team) {global $current_season, $schedule_season, $help, $include_check, $hilight;
	$upload_dir = "data/schedule";
	if (($s == "01")) {$k = ".php";} else {$k = ".txt";}
	if (!IsSet($s)) {$s = $current_season; $team = "all";}
	$link = "http://www.hockeyarena.net/sk/index.php?p=manager_schedule_friendly_match_sql.php&amp;challenged=";
	if(($s < 27) && ($team == "wpg")) {$team = "atl";}
	$g = ($upload_dir."/playoff".$current_season.$k);
	if (file_exists($g)) {$season_type = "po";} else {$season_type = "reg";}
	
	if (!IsSet($type)) {$type = $season_type;}
	if (!IsSet($team)) {$team = "all";}
	if ($type == "po") {$n = "playoff"; $x = "Play-offs"; $game = "12";} 
	if ($type == "reg") {$n = "schedule"; $x = "Regular Season"; $game = "3";}
	
	$f2 = $n.$s.$k;
	
	echo "<div class=\"text\"><b>: schedule - $x - Stanley Cup $s</b></div><br />";
	
	if ((($s == $current_season) && ($type == $season_type)) || (($s == $schedule_season) && ($current_season !== $schedule_season))) {echo "<br />$help";}
	
	if ($k == ".txt") {parseteamslist_teams_schedule();echo "\n";}
	if (($type == "po") && ($team == "all")) {echo "<br />"; include ("schedule_function_po_tree.php"); echo "<br />";}
	if (file_exists($upload_dir."/".$f2)) {
	if ($k !== ".txt") {include($upload_dir."/".$f2);}
	else {
	$z = 1;
		$f = fopen($upload_dir."/". $f2, "r");
		if ($team !== "all") {
		echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=$team\"><img class=\"logo\" alt=\"team logo\" title=\"";
		parseteamname_schedule($team);
		echo "\" width=\"150px\" src=\"img/team_logo/pics/$team.jpg\"></center><br /></a>";
		echo "<table align=\"center\" class=\"schedule\"><th colspan=\"9\" align=\"center\">$x - Stanley Cup $s</th>\n";	
		while (!feof($f)) {
			$tmp = explode("|", fgets($f, 2000));
			if (trim($tmp[0]) != "") {
                if(strlen($tmp[5])<2) {$tmp[5]="0".$tmp[5];}
                if(strlen($tmp[6])<2) {$tmp[6]="0".$tmp[6];}
				if (($team == $tmp[8]) || ($team == $tmp[9])) {
					if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
					echo "<td align=\"right\" width=\"9%\"><span class=\"note\">&nbsp;$tmp[5].$tmp[6].$tmp[7]</span></td>"; 
					if ($tmp[10] == "?") {if(($tmp[3] == "AAA") || ($tmp[3] == "BBB") || ($tmp[3] == "CCC") ||($tmp[3] == "DDD") || ($tmp[3] == "EEE") || ($tmp[3] == "FFF")) {echo "<td width=\"6%\"><span class=\"note\">&nbsp;n/a</span></td>";} else {
						echo "<td width=\"6%\">&nbsp;<a target=\"_blank\" class=\"note\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[3]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=0&amp;match_type=$game\" title=\"to be played at home\">H</a><span class=\"note\"> - <a target=\"_blank\" class=\"note\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[3]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=1&amp;match_type=$game\" title=\"to be played away\">A</a></span></td>";}} else {echo "<td width=\"6%\">&nbsp;</td>";}
					echo "<td valign=\"middle\" width=\"30%\" align=\"right\">";
					if(($tmp[3] == "AAA") || ($tmp[3] == "BBB") || ($tmp[3] == "CCC") ||($tmp[3] == "DDD") || ($tmp[3] == "EEE") || ($tmp[3] == "FFF")) {echo "$tmp[1]&nbsp;";} else {echo "<a class=\"text1\" title=\"$tmp[1]\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[3]\">"; if ($team == $tmp[8]) {echo "<b>$tmp[1]</b>";} else {echo "$tmp[1]";}
					echo "</a>&nbsp;";}
					echo "</td><td align=\"left\" valign=\"middle\"><a href=\"sc.php?id=teams.php&amp;team=$tmp[8]\"><img class=\"logo\" alt=\"$tmp[1]\" title=\"$tmp[1]\" src=\"img/team_logo/small/$tmp[8].png\" width=\"30px\"></a></td>";
					echo "<td width=\"6%\" align=\"center\">";
					if (($tmp[10] !== "?") && ($s == $current_season)) {echo "<a target=\"_blank\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_match_info.php&amp;match_id=$tmp[13]\">$tmp[10] : $tmp[11]</a>";} else {echo "$tmp[10] : $tmp[11]";}
					echo "</td>";
					echo "<td align=\"right\" valign=\"middle\"><a href=\"sc.php?id=teams.php&amp;team=$tmp[9]\"><img class=\"logo\" alt=\"$tmp[2]\" title=\"$tmp[2]\" src=\"img/team_logo/small/$tmp[9].png\" width=\"30px\"></a></td>";
					echo "<td valign=\"middle\" width=\"30%\" align=\"left\">&nbsp;";
					if(($tmp[4] == "AAA") || ($tmp[4] == "BBB") || ($tmp[4] == "CCC") ||($tmp[4] == "DDD") || ($tmp[4] == "EEE") || ($tmp[4] == "FFF")) {echo "$tmp[2]";} else {echo "<a target=\"_blank\" title=\"$tmp[2]\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[4]\">"; if ($team == $tmp[9]) {echo "<b>$tmp[2]</b>";} else {echo "$tmp[2]";}}
					echo "</a></td>";
					if ($tmp[11] == "?") {if(($tmp[4] == "AAA") || ($tmp[4] == "BBB") || ($tmp[4] == "CCC") ||($tmp[4] == "DDD") || ($tmp[4] == "EEE") || ($tmp[4] == "FFF")) {echo "<td width=\"6%\"><span class=\"note\">n/a&nbsp;</span></td>";} else {echo "<td width=\"6%\"><a target=\"_blank\"  title=\"to be played at home\" class=\"note\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[4]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=0&amp;match_type=$game\">H</a><span class=\"note\"> - <a target=\"_blank\" class=\"note\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[4]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=1&amp;match_type=$game\" title=\"to be played away\">A</a></span></td>";}} else {echo "<td width=\"6%\">&nbsp;</td>";}
					echo "</td>";
				echo "<td ><a href=\"sc.php?id=teams_compare.php&amp;team1=$tmp[8]&amp;team2=$tmp[9]\"><img class=\"logo\" title=\"$tmp[1] vs. $tmp[2] match-up history\" src=\"img/s_cal.gif\"></a></td>";
					echo "</tr>\n";
				}
			}
		}
		echo "</table>\n";
	}		
	elseif ($team == "all") {
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
            if(strlen($tmp[5])<2) {$tmp[5]="0".$tmp[5];}
            if(strlen($tmp[6])<2) {$tmp[6]="0".$tmp[6];}		  
            if ($tmp[12] == 1) 			
				{echo "<br /><table align=\"center\" class=\"overview\">\n<tbody><tr><th colspan=\"7\" align=\"center\">";
				if ($type == "po") {echo "$tmp[0] ";} $z = 1;
				echo "$tmp[5].$tmp[6].$tmp[7]";
                    if ($tmp[10] == "?") {echo " - 22:00";}
                    echo "</th></tr>\n";}
				if((trim($tmp[8]) == $hilight) || (trim($tmp[9]) == $hilight)) {echo "<tr class=\"hilight\" "; $trclass="1"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr "; $z=1; $trclass="0";} else {echo "<tr class=\"even\" "; $trclass="2"; $z++;}}
                $file_income = "data/schedule/income".$s.".txt";
                if (file_exists($file_income)) {
                    $f_inc = fopen($file_income, "r");
                    while (!feof($f_inc)) {
            			$tmp_inc = explode("|", fgets($f_inc, 2000));
            			if (trim($tmp_inc[0]) != "") {
                            if($tmp_inc[0] == $tmp[13]) {
                                echo "title=\"crowd: $tmp_inc[1], ticket price: $tmp_inc[3], ticket income: ".number_format($tmp_inc[2],"0", "", ",")."\"";
                            }
                        }
                    }
                }
                echo ">";
				echo "<td width=\"5%\">&nbsp;</td>";
				echo "<td valign=\"middle\" width=\"36%\" align=\"right\">";
				if(($tmp[3] == "AAA") || ($tmp[3] == "BBB") || ($tmp[3] == "CCC") ||($tmp[3] == "DDD") || ($tmp[3] == "EEE") || ($tmp[3] == "FFF")) {echo "$tmp[1]";} else {echo "<a class=\"text1\" title=\"$tmp[1]\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[3]\">$tmp[1]</a>";}
				if ($tmp[10] == "?") {if(($tmp[3] == "AAA") || ($tmp[3] == "BBB") || ($tmp[3] == "CCC") ||($tmp[3] == "DDD") || ($tmp[3] == "EEE") || ($tmp[3] == "FFF")) {echo "<br /><span class=\"note\">to be updated...</span>";} else {echo "<br /><a target=\"_blank\" class=\"note\"  title=\"to be played at home\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[3]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=0&amp;match_type=$game\">home</a><span class=\"note\"> - <a target=\"_blank\" title=\"to be played away\" class=\"note\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[3]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=1&amp;match_type=$game\">away</a></span>";}}
				echo "</td><td align=\"left\" valign=\"middle\">&nbsp;<a href=\"sc.php?id=teams.php&amp;team=$tmp[8]\"><img class=\"logo\" alt=\"$tmp[1]\" title=\"$tmp[1]\" src=\"img/team_logo/small/$tmp[8].png\" width=\"30px\"></a></td>";
				echo "<td align=\"center\">";
				if (($tmp[10] !== "?") && ($s == $current_season)) {echo "<a target=\"_blank\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_match_info.php&amp;match_id=$tmp[13]\">$tmp[10] : $tmp[11]</a>";} else {echo "$tmp[10] : $tmp[11]";}
				echo "</td>";
				echo "<td align=\"right\" valign=\"middle\"><a href=\"sc.php?id=teams.php&amp;team=$tmp[9]\"><img class=\"logo\" alt=\"$tmp[2]\" title=\"$tmp[2]\" src=\"img/team_logo/small/$tmp[9].png\" width=\"30px\"></a>&nbsp;</td>";
				echo "<td valign=\"middle\" width=\"36%\" align=\"left\">";
				if(($tmp[4] == "AAA") || ($tmp[4] == "BBB") || ($tmp[4] == "CCC") ||($tmp[4] == "DDD") || ($tmp[4] == "EEE") || ($tmp[4] == "FFF")) {echo "$tmp[2]";} else {echo "<a target=\"_blank\" class=\"text1\" title=\"$tmp[2]\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[4]\">$tmp[2]</a>";}
				if ($tmp[10] == "?") {if(($tmp[4] == "AAA") || ($tmp[4] == "BBB") || ($tmp[4] == "CCC") ||($tmp[4] == "DDD") || ($tmp[4] == "EEE") || ($tmp[4] == "FFF")) {echo "<br /><span class=\"note\">to be updated...</span>";} else {echo "<br /><a target=\"_blank\" class=\"note\" title=\"to be played at home\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[4]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=0&amp;match_type=$game\">home</a><span class=\"note\"> - <a target=\"_blank\" class=\"note\" title=\"to be played away\" rel=\"shadowbox;width=1100;height=600\" href=\"$link$tmp[4]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=1&amp;match_type=$game\">away</a></span>";}}
				echo "</td>";
				echo "<td align=\"center\" width=\"4%\"><a href=\"sc.php?id=teams_compare.php&amp;team1=$tmp[8]&amp;team2=$tmp[9]\"><img class=\"logo\" title=\"$tmp[1] vs. $tmp[2] match-up history\" src=\"img/s_cal.gif\"></a></td>";
				echo "</tr>\n";
				if (($tmp[12] == 2) || ($tmp[0] == "Stanley Cup Finals")) {echo "</table>\n";}
			}
		}
	}
	else {echo "<center><span class=\"text\"><br /><b>[no schedule available]</b></span></center><br />";}
	}
} echo "<br />";		
}

function parsetype ($s, $type) {global $s, $type, $team;

	echo "<br /><table align=\"right\"><tr><td>";
	echo "<form >";
	echo "<input type=\"radio\" ";
	if ($type=="reg") {echo "checked=\"checked\"";}
	echo "name=\"type\" value=\"sc.php?id=schedule.php&amp;s=$s&amp;type=reg&amp;team=$team\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;regular season</span><br />";
	echo "<input type=\"radio\" ";
	if ($type=="po") {echo " checked=\"checked\"";}
	echo "name=\"type\" value=\"sc.php?id=schedule.php&amp;s=$s&amp;type=po&amp;team=$team\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;playoffs</span>";
	echo "</form>";
	echo "</td></tr></table>";
}

?>

<?

if($include_check == "bXnqwa") {

	global $s, $schedule_season, $current_season;
	
	$upload_dir = "data/schedule";
	$g = ($upload_dir."/playoff".$current_season.".txt");
	if (file_exists($g)) {$season_type = "po";} else {$season_type = "reg";}
	
	if ((!IsSet($type) || ($type==""))) {$type = $season_type;}
	if ((!IsSet($s) || ($s==""))) {$s = $current_season;}	
	if ((!IsSet($team) || ($team==""))) {$team = "all";}
	if (($s == $schedule_season) && ($season_type == "reg")) {$type = "reg";}
	echo "<table align=\"right\"><tr><td>";
	parseseasonlist_schedule();
	if (($current_season !== $schedule_season) && ($s == $schedule_season)) { echo ""; $type = "reg";} 
	elseif (($current_season == $schedule_season) && ($s == $schedule_season) && ($season_type == "reg")) { echo "";}
	else {parsetype ($s, $type);}
	echo "</td></tr></table><br /><br />";

	parseschedule($s, $type, $team);
	
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
	
?>
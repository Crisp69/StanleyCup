<?php

function parsestandings_qual($div) {global $current_season;
	$upload_dir = "data/qual/";
	$k = ".txt";
	$f2 = $upload_dir.$div.$k;
if (file_exists($f2)) {	

	echo "<table align=\"center\" class=\"overview\"><tr><th width=\"45%\" colspan=\"2\">\n";
	echo "Standings</th><th width=\"9%\" align=\"center\" title=\"wins\">W</th><th width=\"9%\" align=\"center\" title=\"ties\">T</th><th width=\"9%\" align=\"center\" title=\"losses\">L</th><th width=\"14%\" align=\"center\">Score</th><th width=\"9%\" align=\"center\" title=\"points\">P</th></tr>\n";
	$z= 1;
	$f = fopen($upload_dir.$div.$k, "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			{if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
				echo "<td width=\"5%\">&nbsp;$tmp[0].</td>";
				echo "<td><a target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[2]\">$tmp[1]</a></td>";
				echo "<td align=\"center\">$tmp[3]</td>";
				echo "<td align=\"center\">$tmp[4]</td>";
				echo "<td align=\"center\">$tmp[5]</td>";
				echo "<td align=\"center\">$tmp[6]</td>";
				echo "<td align=\"center\">$tmp[7]</td>";
				echo "</tr>\n";
				}
			}
		}
	}echo "</table>";
}


function parseschedule_qual($type, $div) {global $help;
	$upload_dir = "data/qual/";
	$link = "http://www.hockeyarena.net/sk/index.php?p=manager_schedule_friendly_match_sql.php&amp;challenged=";
	$k = ".txt";
	if ($type == "po") {$n = "playoff"; $x = "Play-offs"; $game = "12";} 
	if ($type == "reg") {$n = "schedule"; $x = "Regular Season"; $game = "3";}
	
	$f2 = "schedule_". $div.$k;
	
	if (file_exists($upload_dir.$f2)) {
	$z = 1;
	$f = fopen($upload_dir."/". $f2, "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			{if ($tmp[12] == 1) 			
				{echo "<table align=\"center\" class=\"overview\">\n<tbody><tr>";
				if ($type == "po") {echo "<th>Group</th><th colspan=\"3\" align=\"center\">";}
				else {echo "<th colspan=\"4\" align=\"center\">";}
				echo "$tmp[5].$tmp[6].$tmp[7]</th></tr>\n";}
				if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
				if ($type == "po") {echo "<td valign=\"middle\" width=\"8%\" align=\"right\">$tmp[0]</td>";}
				else {echo "<td valign=\"middle\" width=\"8%\" align=\"right\"></td>";}
				echo "<td valign=\"middle\" width=\"37%\" align=\"right\"><a class=\"text1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[3]\">$tmp[1]</a>";
				if ($tmp[10] == "?") {echo "<br /><a target=\"_blank\" class=\"note\" href=\"$link$tmp[3]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=0&amp;match_type=$game\">home</a><span class=\"note\"> - <a target=\"_blank\" class=\"note\" href=\"$link$tmp[3]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=1&match_type=$game\">away</a></span>";}
				echo "</td>";
				echo "<td align=\"center\">$tmp[10] : $tmp[11]</td>";
				echo "<td valign=\"middle\" width=\"45%\" align=\"left\"><a target=\"_blank\" class=\"text1\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[4]\">$tmp[2]</a>";
				if ($tmp[10] == "?") {echo "<br /><a target=\"_blank\" class=\"note\" href=\"$link$tmp[4]&date=$tmp[7]-$tmp[6]-$tmp[5]&place=0&match_type=$game\">home</a><span class=\"note\"> - <a target=\"_blank\" class=\"note\" href=\"$link$tmp[4]&amp;date=$tmp[7]-$tmp[6]-$tmp[5]&amp;place=1&amp;match_type=$game\">away</a></span>";}
				echo "</td>";
				echo "</tr>\n";
				if (($tmp[12] == 2) || ($tmp[0] == "Game 2") || ($tmp[0] == "Game 3") || ($tmp[0] == "?? Game 3 ??") || ($tmp[0] == "Final") || ($tmp[0] == "1/16")) {echo "</table>\n";}
			}
		}
	}
	}echo "<br />";
}
		




?>

<?
if($include_check == "bXnqwa") {

    $help = "<center><a class=\"note\" href=\"javascript:popup_show('popup', 'popup_drag', 'popup_exit');\">[challenge help]</a></center><br />\n<div class=\"sample_popup\" id=\"popup\" style=\"display: none;\">\n<div id=\"popup_drag\"><img class=\"menu_form_exit\" id=\"popup_exit\" title=\"close\" src=\"img/form_exit.png\" alt=\"\" /></div>you are allowed to play at any stadium for higher income if you both agree on it, otherwise first team in the line is considered as home team<p>to challenge your opponent click directly <b>home (H)</b> or <b>away (A)</b> bellow (at) your opponent team's name<p><b>home</b> - you will play at your home stadium<br /><b>away</b> - you will play at your opponent's stadium<p><b>you must be logged to hockeyarena to send challenges directly from here!</b></div>";
    
    echo "<div class=\"text\"><b>: Stanley Cup Qualification</b><p></div>";echo "<br />$help<br />";
    echo "If you find any problem with scheduled date, please agree with your opponent any other day to play your game, but please remember that winner of your group must be know on <b>24th July</b> latest. Always inform sollu!";
    echo "<hr>";
    
    
    
	echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=tbl\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Tampa Bay Lightning\" src=\"img/team_logo/pics/tbl.jpg\"></a></center><br />";
    parseschedule_qual($type = "reg", $div = "tbl");
    parsestandings_qual($div = "tbl");
    echo "<br /><b>RULES:</b> Group of 3 teams, playing games against each other, points, standings and tie-breaking rules same as <a href=\"sc.php?id=rules.php\">tournament rules</a>.<hr>";
    
	echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=van\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Vancouver Canucks\" src=\"img/team_logo/pics/van.jpg\"></a></center><br />";
    parseschedule_qual($type = "po", $div = "van");
    
	echo "<br /><b>RULES:</b> One playoff game played, winner of the game advances to next round, winner of the finals qualifies for the tournament<hr>";
	
	
	
/*	echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=sjs\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"San Jose Sharks\" src=\"img/team_logo/pics/sjs.jpg\"></a></center><br />";
    parseschedule_qual($type = "po", $div = "sjs");
    parsestandings_qual($div = "sjs");
	echo "<br /><b>RULES:</b> One playoff game played, winner of the game qualifies for the tournament<hr>";
	echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=van\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Vancouver Canucks\" src=\"img/team_logo/pics/van.jpg\"></a></center><br />";
    parseschedule_qual($type = "po", $div = "van");
    parsestandings_qual($div = "van");
	echo "<br /><b>RULES:</b> One playoff game played, winner of the game qualifies for the tournament<hr>";*/
//    echo "<br /><b>RULES:</b> Group of 3 teams, playing games against each other, points, standings and tie-breaking rules same as <a href=\"sc.php?id=rules.php\">tournament rules</a>.<hr>";
    
    /*
    echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=dal\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Pittsburgh Penguins\" src=\"img/team_logo/pics/dal.jpg\"></a></center><br />";
    parseschedule_qual($type = "po", $div = "dal");
    echo "<br /><b>RULES:</b> Playoff series of 2 games, rules same as <a href=\"sc.php?id=rules.php\">tournament playoff rules</a>. In case of all ties, game 3 will be scheduled.<hr>";
    
    
	echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=min\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Minnesota Wild\" src=\"img/team_logo/pics/min.jpg\"></a></center><br />";
    parseschedule_qual($type = "po", $div = "min");
    
	echo "<br /><b>RULES:</b> One playoff game played, winner of the game advances to next round, winner of the finals qualifies for the tournament<hr>";
	
	echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=nyi\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"New York Islanders\" src=\"img/team_logo/pics/nyi.jpg\"></a></center><br />";
    parseschedule_qual($type = "po", $div = "nyi");
    
	echo "<br /><b>RULES:</b> One playoff game played, winner of the game advances to next round, winner of the finals qualifies for the tournament<hr>";
	
	
    echo "<br /><center><a href=\"sc.php?id=teams.php&amp;team=tbl\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Tampa Bay Lightning\" src=\"img/team_logo/pics/tbl.jpg\"></a></center><br />";
    parseschedule_qual($type = "reg", $div = "tbl");
    parsestandings_qual($div = "tbl");
    echo "<br /><b>RULES:</b> Group of 3 teams, playing games against each other, points, standings and tie-breaking rules same as <a href=\"sc.php?id=rules.php\">tournament rules</a>.<hr>";
    
    
    //echo "<br /><center><a href=\"sc.php?id=teams.php&team=sjs\"><img width=\"150px\" class=\"logo\" alt=\"qualification\" title=\"San Jose Sharks\" src=\"img/team_logo/pics/sjs.jpg\"></a></center><br />";
    //parseschedule_qual($type = "po", $div = "sjs");
    //echo "<b>RULES:</b> Playoff series of 1 game, rules same as <a href=\"sc.php?id=rules.php\">tournament playoff rules</a>. <hr>";
     
    // echo "<br /><center><a href=\"sc.php?id=teams.php&team=edm\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Edmonton Oilers\" src=\"img/team_logo/pics/edm.jpg\"></a></center><br />";
    // parseschedule_qual($type = "po", $div = "edm");
    // echo "<b>RULES:</b> Playoff 1-win-game series, according to <a href=\"sc.php?id=rules.php\">tournament playoff rules</a>.<hr>";
    
    // echo "<br /><center><a href=\"sc.php?id=teams.php&team=tor\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"Toronto Maple Leafs\" src=\"img/team_logo/pics/tor.jpg\"></a></center><br />";
    // parseschedule_qual($type = "reg", $div = "tor");
    // parsestandings_qual($div = "tor");
    // echo "<br /><b>RULES:</b> Group of 3 teams, playing games against each other, points, standings and tie-breaking rules same as <a href=\"sc.php?id=rules.php\">tournament rules</a>.<hr>";
    
    // echo "<br /><center><a href=\"sc.php?id=teams.php&team=van\"><img width=\" 150px\" class=\"logo\" alt=\"qualification\" title=\"vancouver Canucks\" src=\"img/team_logo/pics/van.jpg\"></a></center><br />";
    // parseschedule_qual($type = "po", $div = "van");
    // echo "<b>RULES:</b> Playoff series of 2 games, rules same as <a href=\"sc.php?id=rules.php\">tournament playoff rules</a>. In case of all ties, game 3 will be scheduled.<hr>";
*/
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}


?>
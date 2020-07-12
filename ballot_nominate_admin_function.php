<?php

function parsenominate_admin($trophy, $nick) {global $current_season;
	include ("data/ballot/data/pass.php");
	$nick_lower = strtolower($nick);
	$password_main = $password_main[$nick_lower];

	$f1 = "data/awards/desc/$trophy.txt";
	if(file_exists($f1)) {
	$fx = fopen($f1,"r");
	$tmp_desc = explode("|",fgets($fx,2000));
	if (trim($tmp_desc[0]) != "") {
		echo "<table class=\"awards\" width=\"50%\" align=\"center\"><tr>";
		echo "<td valign=\"top\" height=\"20px\" align=\"center\"><div class=\"headline\">$tmp_desc[1]<p></div></td></tr>";

		echo "</table><br />";}
	fclose($fx);}


	echo "<form method=\"post\" name=\"$trophy\">";
	echo "<br /><center><input type=\"hidden\" name=\"trophy\" value=\"$trophy\">\n<input type=\"hidden\" name=\"nick\" value=\"$nick\">\n<input class=\"date\" value=\"-- SELECT --\" type=\"submit\">\n<input type=\"hidden\" name=\"password\" value=\"$password_main\"></center><br />\n";	
	
	
	if($trophy == "james") {$stats = "defs"; $type = "reg"; $stats_count = "6";}
	if($trophy == "frank") {$stats = "points"; $type = "reg";  $stats_count = "6";}
	if($trophy == "bill") {$stats = "points";  $goalies = "yes"; $type = "reg"; $stats_count = "6";}
	if($trophy == "lady") {$stats = "points";  $goalies = "yes"; $type = "reg"; $stats_count = "6";}
	if($trophy == "conn") {$stats = "points";  $goalies = "yes"; $type = "po"; $stats_count = "3";}
	if($trophy == "vezina") {$stats = "nope"; $goalies = "yes"; $type = "reg"; $stats_count = "6";}
	if($trophy == "jack") {$stats = "nope";}
	
	
	if($stats !== "nope") {
		$file_points = "data/stats/".$stats.$current_season.$type.".txt";
			
		echo "<table class=\"overview\" align=\"center\">";
		echo "<tr>
				<th align=\"center\" width=\"6%\"></th>
				<th align=\"left\" width=\"27%\">name</th>
				<th width=\"7%\" align=\"right\">team</th>
				<th width=\"7%\" align=\"right\">M</th>
				<th width=\"7%\" align=\"right\">G</th>
				<th width=\"7%\" align=\"right\">A</th>
				<th width=\"7%\" align=\"right\">P</th>
				<th width=\"7%\" align=\"right\">+/-</th>
				<th width=\"7%\" align=\"right\">Perf</th>
				<th width=\"7%\" align=\"right\">Shs</th>
				</tr>\n";
		$z=1;
		if(file_exists($file_points)) {
		$f = fopen($file_points, "r");
			while (!feof($f)) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if ($tmp[3]> $stats_count) {
						if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						$name = $tmp[2];
						echo "<td align=\"right\"><input name=\"nominate[]\" value=\"$tmp[2];$tmp[11];;$tmp[3]G - $tmp[4]g + $tmp[5]a = $tmp[6]p, $tmp[7] (+/-);$tmp[13]\" type=\"checkbox\">&nbsp;</input></td>";
						echo "<td ><a target=\"_blank\" class=\"text1\" href=\"sc.php?id=player_stats.php&pos=points&name=";
						parseplayer_link($name = $name);
						echo "&amp;id_player=$tmp[13]&amp;s=$current_season\">" . trim($tmp[2]) . "</a></td>";
						echo "<td align=\"center\">" . trim($tmp[12]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[6]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[8], ",", ".") . "</td>";
						echo "<td align=\"right\">" . trim($tmp[9]) . "</td>";
						echo "</tr>\n";
					}
				}
			}fclose($f);}
			echo "</table><br />";
		}

	
	
	if($goalies == "yes") {	
	$file_points = "data/stats/goalies".$current_season.$type.".txt";
	
	echo "<table class=\"overview\" align=\"center\">";
	echo "<tr>
			<th align=\"center\" width=\"6%\"></th>
			<th align=\"left\" width=\"27%\">name</th>
			<th width=\"7%\" align=\"right\">team</th>
			<th width=\"8%\" align=\"right\">M</th>
			<th width=\"8%\" align=\"right\">Shs</th>
			<th width=\"8%\" align=\"right\">Svs</th>
			<th width=\"9%\" align=\"center\">%</th>
			<th width=\"8%\" align=\"right\">Shout</th>
			<th width=\"8%\" align=\"right\">Perf</th>
			</tr>\n";
	$z=1;
	if(file_exists($file_points)) {
	$f = fopen($file_points, "r");
			while (!feof($f)) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if ($tmp[3]> $stats_count) {
						if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						$name = $tmp[2];
						echo "<td align=\"right\"><input name=\"nominate[]\" value=\"$tmp[2];$tmp[9];goalie;$tmp[3]G - $tmp[4]shs/$tmp[5]svs - $tmp[6] - $tmp[7] shotouts;$tmp[12]\" type=\"checkbox\">&nbsp;</input></td>";
						echo "<td><a target=\"_blank\" class=\"text1\" href=\"sc.php?id=player_stats.php&pos=goalies&name=";
						parseplayer_link($name = $name);
						echo "&amp;id_player=$tmp[12]&amp;s=$current_season\">" . trim($tmp[2]) . "</a></td>";
						echo "<td align=\"center\">" . trim($tmp[10]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[6], ",", "."). "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[8], ",", "."). "</td>";
						echo "</tr>\n";
					}
				}
			}fclose($f);}

		echo "</table>";
	}
	

	if($trophy == "jack") {
	$file_points = "data/teams/teams_history.txt";
	echo "<table class=\"overview\" align=\"center\">";
	echo "<tr>
			<th align=\"center\" width=\"6%\"></th>
			<th align=\"left\" width=\"27%\">manager</th>
			<th width=\"7%\" align=\"left\">team</th>
			<th width=\"7%\" align=\"left\">div</th>
			<th width=\"8%\" align=\"left\">conf</th>
			<th width=\"8%\" align=\"left\">W-T-L</th>
			<th width=\"8%\" align=\"left\">score</th>
			</tr>\n";
	$z=1;
	if(file_exists($file_points)) {
	$f = fopen($file_points, "r");
			while (!feof($f)) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if ($tmp[0] ==  $current_season) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
					echo "<td align=\"right\"><input name=\"nominate[]\" value=\"$tmp[2];$tmp[1];manager;div: $tmp[3], conf: $tmp[4], W-T-L: $tmp[5], score: $tmp[6]\" type=\"checkbox\" checked=\"checked\">&nbsp;</input></td>";
					echo "<td align=\"left\">" . trim($tmp[2]) . "</td>";
					echo "<td align=\"left\">" . trim($tmp[1]) . "</td>";
					echo "<td align=\"left\">" . trim($tmp[3]) . "</td>";
					echo "<td align=\"left\">" . trim($tmp[4]) . "</td>";
					echo "<td align=\"left\">" . trim($tmp[5]) . "</td>";
					echo "<td align=\"left\">" . trim($tmp[6]) . "</td>";	
					echo "</tr>";
					}
				}
			}fclose($f);}

		echo "</table>";
		}

	echo "</form><br />";


	echo "<center><form name=\"nominate_form\" method=\"post\" action=\"sc.php?id=ballot_nominate_admin.php\"><textarea type=\"text\" class=\"list\" name=\"nominate_form\" cols=\"75\" rows=\"10\" />";
		
		foreach($_POST["nominate"] as $submit) {
			$tmp = explode(";", $submit);
				if ($tmp[2] == "") {
				$def_file = "data/stats/defs".$current_season."reg.txt";
				$f = fopen($def_file, "r");
					while (!feof($f)) {
						$tmp_def = explode("|", fgets($f, 2000));
						if (trim($tmp_def[0]) != "") {
							if ($tmp[0] == $tmp_def[2]) {$tmp[2] = "defender";} 
						}
					}
				}
				if ($tmp[2] == "") {$tmp[2] = "forward";}
					$nominate = $tmp[0].";".$tmp[1].";".$tmp[2].";".$tmp[3];
		echo "$nominate||\n";
		
		
		}
		
		echo "</textarea>\n<br /><input type=\"hidden\" name=\"trophy\" value=\"$trophy\">\n<input type=\"hidden\" name=\"nick\" value=\"$nick\">\n<input type=\"hidden\" name=\"continue\" value=\"yes\">\n<input type=\"hidden\" name=\"password\" value=\"$password_main\">\n<input type=\"hidden\" name=\"ok\" value=\"ok\">\n<input type=\"submit\" class=\"date\" value=\"-- SUBMIT --\" /></form></center>";
}



function parseselect_admin($trophy, $nick) {global $current_season;
	include ("data/ballot/data/pass.php");
	$nick_lower = strtolower($nick);
	$password_main = $password_main[$nick_lower];
	
	
	echo "<table align=\"right\"><tr><td>";
	echo "<form method=\"post\">";
	echo "<tr><td>&nbsp;<select size=\"6\" name=\"trophy\" class=\"list\">\n";
	echo "<option value=\"jack\">&nbsp;Jack Adams Award</option>\n";
	echo "<option value=\"vezina\">&nbsp;Vezina Trophy</option>\n";
	echo "<option value=\"james\">&nbsp;James Norris Award</option>\n";
	echo "<option value=\"lady\">&nbsp;Lady Bing Memorial Trophy</option>\n";
	echo "<option value=\"frank\">&nbsp;Frank Selke Trophy</option>\n";
	echo "<option value=\"bill\">&nbsp;Bill Masterson Award</option>\n";
	echo "<option value=\"conn\">&nbsp;Conn Smythe Award</option>\n";
	echo "</select>\n</td></tr><tr><td align=\"center\">";
	echo "<input type=\"hidden\" name=\"nick\" value=\"$nick\">\n<input type=\"hidden\" name=\"password\" value=\"$password_main\">\n<input type=\"submit\" class=\"date\" value=\"-- OK --\" />\n"; 
	echo "</form>\n";
	echo "</td></tr></table><br />\n";
}


?>
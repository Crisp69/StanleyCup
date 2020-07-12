<?php


function parsenominate($trophy, $team, $nick) {global $current_season;
	//kontrola hlasovanych
	
	if($nick !== "admin") { 
		$file_votes = "data/ballot/".$trophy."_nominates.txt";
		if(file_exists($file_votes)) {
		$f_votes = fopen($file_votes, "r");
		while(!feof($f_votes)) {
			$tmp_vote = explode("|",fgets($f_votes,2000));
			if (trim($tmp_vote[0]) != "") {
				if (trim(strtolower($tmp_vote[1])) == strtolower($nick)) {$ok = "nope"; $tmp_voted = explode(";", $tmp_vote[2]);$voted = $tmp_voted[0]." - ".$tmp_voted[2];}			
				}
		}fclose($f_votes);
		}
	}

	$f1 = "data/awards/desc/$trophy.txt";
	if(file_exists($f1)) {
	$fx = fopen($f1,"r");
	$tmp_desc = explode("|",fgets($fx,2000));
	if (trim($tmp_desc[0]) != "") {
		if ($ok !== "nope") {
			echo "<hr>";
			echo "Please nominate one of your players for following award (only players with 6+ games played are available):<p>";
			echo "<table class=\"awards\" width=\"50%\" align=\"center\"><tr><td rowspan=\"2\" align=\"center\" valign=\"top\"><br /><a target=\"_blank\" href=\"sc.php?id=awards.php&trophy=$tmp_desc[0]\"><img alt=\"$tmp_desc[1]\" height=\"100px\" title=\"$tmp_desc[1]\" class=\"awards\" src=\"img/trophies/$tmp_desc[0].jpg\"></a><p></td>";
			echo "<td valign=\"top\" height=\"20px\" align=\"center\"><div class=\"headline\">$tmp_desc[1]<p></div></td></tr>";
			echo "<tr><td valign=\"top\" width=\"60%\" align=\"center\" valign=\"top\"><div class=\"text\">$tmp_desc[2]<p></div></td></tr>";
			echo "</table><br /><center>$tmp_desc[3]</center><br />";
			if ($trophy == "calder") {echo "<center><div class=\"headline\">Nominate only players U-20 (included), older players will be deleted!<p></div></center>";}
			}
		else {echo " - $tmp_desc[1] - nomination done: $voted<p>";}
		}
	fclose($fx);}
	
	if ($ok !== "nope") {
	echo "\n<form method=\"post\" name=\"$trophy\" action=\"sc.php?id=ballot_nominate.php\">";
	$file_points = "data/stats/points".$current_season."reg.txt";
	echo "<table class=\"overview\" align=\"center\">";
	echo "<tr>
			<th align=\"center\" width=\"6%\"></th>
			<th align=\"left\" width=\"27%\">name</th>
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
					if ($team == trim($tmp[12])) {
						if ($tmp[3]>5) {
							if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
							$name = $tmp[2];
							echo "<td align=\"right\"><input name=\"nominate\" value=\"$tmp[2];$tmp[11];;$tmp[3]G - $tmp[4]g + $tmp[5]a = $tmp[6]p, $tmp[7] (+/-);$tmp[13]\" type=\"radio\">&nbsp;</input></td>";
							echo "<td ><a rel=\"shadowbox;width=750;height=600;title=$tmp[2]\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name=";
							parseplayer_link($name = $name);
							echo "&amp;id_player=$tmp[13]&amp;s=$current_season\">" . trim($tmp[2]) . "</a></td>";
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
				}
			}
			echo "</table><br />";
			fclose($f);}
	$file_points = "data/stats/goalies".$current_season."reg.txt";	
	echo "<table class=\"overview\" align=\"center\">";
	echo "<tr>
			<th align=\"center\" width=\"6%\"></th>
			<th align=\"left\" width=\"27%\">name</th>
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
					if ($team == trim($tmp[10])) {
						if ($tmp[3]>5) {
							if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
							$name = $tmp[2];
							echo "<td align=\"right\"><input name=\"nominate\" value=\"$tmp[2];$tmp[9];goalie;$tmp[3]G - $tmp[4]shs/$tmp[5]svs - $tmp[6] - $tmp[7] shotouts;$tmp[12]\" type=\"radio\">&nbsp;</input></td>";
							echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp[2]\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
							parseplayer_link($name = $name);
							echo "&amp;id_player=$tmp[12]&amp;s=$current_season\">" . trim($tmp[2]) . "</a></td>";
							echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
							echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
							echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
							echo "<td align=\"right\">" . strtr($tmp[6], ",", "."). "</td>";
							echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
							echo "<td align=\"right\">" . strtr($tmp[8], ",", "."). "</td>";
							echo "</tr>\n";
						}
					}
				}
			}
			echo "</table>";
			fclose($f);}
	include ("data/ballot/data/pass.php");
	$nick_lower = strtolower($nick);
	$password_main = $password_main[$nick_lower];
	
	echo "<br /><center><input type=\"hidden\" name=\"trophy\" value=\"$trophy\">\n<input type=\"hidden\" name=\"continue\" value=\"yes\">\n<input class=\"date\" value=\"-- NOMINATE --\" type=\"submit\" onClick=\"valbutton($trophy);return false;\"></form></center><br />\n";

echo "<script language=\"JavaScript\">
function valbutton(thisform) {
myOption = -1;
for (i=thisform.nominate.length-1; i > -1; i--) {
if (thisform.nominate[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
alert(\"You must select a player!\");
return false;
}
thisform.submit();
}
</script>";

	}
}


?>
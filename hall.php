<?php


function parsehall() {
	$upload_dir = "data/data/";
	echo "<center>";
	echo "<div class=\"headline\">Manager Hall of Fame</div><br /></center>";
	echo "<table class=\"overview\" width=\"95%\" align=\"center\">";
	echo "<tr class=\"trhead\">";
	echo "<th width=\"5%\">rk</th>";
	echo "<th width=\"20%\">manager</th>";
	echo "<th width=\"25%\">team</th>";
	echo "<th width=\"10%\" align=\"center\">Div</th>";
	echo "<th width=\"10%\" align=\"center\">Conf</th>";
	echo "<th width=\"10%\" align=\"center\">Pres</th>";
	echo "<th width=\"10%\" align=\"center\">SC</th>";
	echo "<th width=\"10%\" align=\"center\">Points</th>";
	echo "</tr>";
	$z = 1;
	$c = 0;
	$f = fopen($upload_dir."hall.txt","r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) !== "") {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
			echo "<td align=\"right\">".trim($tmp[0]).".&nbsp;</td>";
			echo "<td><b><a class=\"text1\" href=\"sc.php?id=manager_stats.php&amp;manager=$tmp[1]\">".trim($tmp[1])."</b></td>";
			echo "<td>".trim($tmp[2])."</td>";
			echo "<td align=\"center\">".trim($tmp[3])."</td>";
			echo "<td align=\"center\">".trim($tmp[4])."</td>";
			echo "<td align=\"center\">".trim($tmp[5])."</td>";
			echo "<td align=\"center\">".trim($tmp[6])."</td>";
			echo "<td align=\"center\">".trim($tmp[7])."</td>";
			echo "</tr>";
			$c++;
		}
	}
	fclose($f);
	echo "</table><br />";
	echo "<div class=\"note\"><b>Points:</b><br />Div - Division winner - 1 point<br />Conf - Conference winner - 3 points<br />Pres - Presidents' Trophy - 3 points<br />SC - Stanley Cup winner - 5 points<br />
</div>";
}
function parsechapms() {
	$upload_dir = "data/data";

	echo "<center><div class=\"headline\"><b>Stanley Cup Champions</b></div></center><br />\n";
	echo "<table align=\"center\" width=\"92%\"\"><tr><td>\n";
	
	$f = fopen($upload_dir."/champs.txt","r");
	$z = 1;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) !== "") {
			echo "<table class=\"awards_small\" width=\"152px\" height=\"250px\" align=\"left\">";
			echo "<tr><td align=\"center\"><span class=\"text\"><b>Stanley Cup $tmp[0] champions</b></span></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><b><a rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[3]\">$tmp[2]</a></b></span></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><b><a rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=manager_manager_info.php&amp;id=$tmp[5]\">$tmp[4]</a></b></span></td></tr>";
			echo "<tr><td align=\"center\"><span class=\"text\"><img width=\"110px\" src=\"img/winners/$tmp[1].jpg\" alt=\"picture not loaded\" title=\"$tmp[2]\"></span></td></tr>";
			echo "</table>\n";
			}
				if ($z ==4) {echo "</td></tr><tr><td>"; $z = 1;} else $z++;
			}
	echo "</td></tr></table><br />";
}

?>

		


<?php

if($include_check == "bXnqwa") {

		echo "<div class=\"text\"><b>: Stanley Cup Hall of Fame</b></div><br />";
		echo "<table align=\"center\" width=\"35%\">";
		echo "<tr><td><div class=\"text\">season: </div></td><td>";
		parseseasonlist_schedule($type="po");
		echo "</tr>";
		echo "<tr><td><div class=\"text\">standings: </div></td><td>";
		parseseasonlist_standings();
		echo "</tr>";
		echo "<tr><td><div class=\"text\">stats: </div></td><td>";
		parseseasonlist_stats();
		echo "</tr>";
		echo "<tr><td><div class=\"text\">awards: </div></td><td>";
		parseseasonlist_awards();
		echo "</tr>";
		echo "<tr><td><div class=\"text\">managers: </div></td><td>";
		parsemanagersearch();
		echo "</tr>";
		echo "</table><br />";
		echo "<center>";		
		parsechapms();
		echo "</center>";
		parsehall();
        
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
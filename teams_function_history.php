<?php

/*historia*/
function parseteamshistory($team) {
	$upload_dir = "data/teams/";
	$n1 = "teams";
	$n2 = ".txt";
	$z = 1;
	echo "<table class=\"overview2\" align=\"center\">\n<tr><th align=\"center\" title=\"season\">s&nbsp;</th><th>manager</th><th align=\"center\" title=\"Division ranking\">div</th><th align=\"center\" title=\"Conference ranking\">conf</th><th align=\"center\" title=\"Wins - Ties - Lost\">W-T-L</th><th align=\"center\">score</th><th align=\"center\" title=\"Conference Quarterfinals\">conf 1/4</th><th align=\"center\" title=\"Conference Semifinals\">conf 1/2</th><th align=\"center\" title=\"Conference Finals\">conf fin</th><th align=\"center\" title=\"Stanley Cup Finals\">SC fin</th>\n";

	$cent = "<td align=\"center\">";
	
	$f2 = $n1."_history".$n2;
	$f = fopen($upload_dir.$f2,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
			if ($tmp[2] == "<i>no manager</i>") {echo "<td>&nbsp;$tmp[0].</td><td>&nbsp;<span class=\"note\"\">$tmp[2]</span></td>$cent$tmp[3].</td>$cent$tmp[4].</td>$cent$tmp[5]</td>$cent$tmp[6]</td>$cent$tmp[7]</td>$cent$tmp[8]</td>$cent$tmp[9]</td>$cent$tmp[10]</td></tr>\n";}
			else {
				echo "<td>&nbsp;<a class=\"note2\" href=\"sc.php?id=standings.php&s=$tmp[0]\">$tmp[0].</a></td><td>";
                if(($tmp[0] <27) && ($team == "wpg")) {echo "[atl] ";}
                echo "<b><a class=\"note2\" href=\"sc.php?id=manager_stats.php&manager=".trim($tmp[2])."\">".trim($tmp[2])."</a></b></td>$cent$tmp[3].</td>$cent$tmp[4].</td>$cent$tmp[5]</td>$cent$tmp[6]</td>$cent$tmp[7]</td>$cent$tmp[8]</td>$cent$tmp[9]</td>$cent$tmp[10]</td></tr>\n";}
			}
		}
	}
	fclose($f);
	echo "</td></tr></table><br />";
}
	

?>
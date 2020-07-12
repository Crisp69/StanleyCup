

<?php

function parsestats($s, $pos, $type, $manager, $statscount)
{global $aaa;

	$upload_dir = "data/stats/";

	$p = StrToUpper($pos);
	$n2 = ".txt";
	$c = 0;
	$f2 = $pos . $s . $type . $n2;
	
	if (File_Exists($upload_dir . $f2)) {
		if ($s == "allstats") {
			$sx = "All Time Stats";
		} else {
			$sx = $s . ". season";
		}
	$z = 1;
	
		echo "<div class=\"text\"><b><center>$sx - $p";


//		if(($s == "allstats") && ($pos == "points")) {echo " - <a class=\"text1\" href=\"sc.php?id=teams.php&team=$team&detail=stats_points\">$p</a>";} elseif(($s == "allstats") && ($pos == "goalies")) {echo " - <a class=\"text1\" href=\"sc.php?id=teams.php&team=$team&detail=stats_goalies\">$p</a>";} else {
	//	echo " - <a class=\"text1\" href=\"sc.php?id=stats.php&team=$team&type=$type&s=$s&pos=$pos\">$p</a>";}


		echo "</b></center>";
		echo "</div><br />\n";
		
		echo "<table class=\"sort-table\" align=\"center\">\n";
		$c = 1;
		if ($pos == "goalies") {
			echo "<thead>
			<tr>
			<td class=\"trhead\" align=\"center\" width=\"6%\">rk</th>
			<td class=\"trhead\" align=\"left\" width=\"46%\" ";
			
			echo ">name</th>
			
			<td class=\"trhead\" width=\"7%\" align=\"center\" ";
			
			echo ">M</th>
			<td class=\"trhead\" width=\"7%\" align=\"center\" ";
			
			echo ">Shs</th>
			<td class=\"trhead\" width=\"8%\" align=\"center\" ";
			
			echo ">Svs</th>
			<td class=\"trhead\" width=\"10%\" align=\"center\" ";
			
			echo ">%</th>
			<td class=\"trhead\" width=\"8%\" align=\"right\" ";
			
			echo ">Shout&nbsp;</th>
			<td class=\"trhead\" width=\"8%\" align=\"right\" ";
			
			echo ">Perf&nbsp;</td>
			</tr></thead>\n";
			$f = fopen($upload_dir . $f2, "r");
			while (!feof($f) && ($c - 1) < $statscount) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if (strtolower($manager) == strtolower(trim($tmp[11]))) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						$name = $tmp[2];
						echo "<td align=\"right\" title=\"overall #$tmp[0]\">";
						if($tmp[3]<22) {echo "--";} else {echo $c.".";}
						echo "&nbsp;</td>";
						echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
						parseplayer_link($name = $name);
						echo "\">" . trim($tmp[2])."</a>";
                        if (($tmp[12] == 0)) {echo " <span class=\"note\">†</span>";}
                        echo "</td>";
						//echo "<td><a href=\"sc.php?id=teams.php&team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[10]\">" . trim($tmp[9]) . "</a></td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . number_format(strtr($tmp[6], ",", "."),1). "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[8], ",", "."). "</td>";
						echo "</tr>\n";$c++;
					} 
				}
			}
			echo "</table><br />\n";
			fclose($f);
		} 
		elseif (($pos !== "goalies") && ($pos !== "stars")) {
			echo "<thead><tr>
			<td class=\"trhead\" align=\"center\" width=\"6%\">rk</td>
			<td class=\"trhead\" align=\"left\" width=\"46%\" ";
			
			echo ">name</td>
			
			
			
			<td class=\"trhead\" width=\"7%\" align=\"center\" ";
			
			echo ">M</td>
			<td class=\"trhead\" width=\"7%\" align=\"center\" ";
			
			echo ">G</td>
			<td class=\"trhead\" width=\"7%\" align=\"center\" ";
			
			echo ">A</td>
			<td class=\"trhead\" width=\"7%\" align=\"center\" ";
			
			echo ">P</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			
			echo ">+/-&nbsp;</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			
			echo ">Perf&nbsp;</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			
			echo ">Shs&nbsp;</td>
			</tr></thead>\n";
			$f = fopen($upload_dir . $f2, "r");
			while (!feof($f) && ($c - 1) < $statscount) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if (strtolower($manager) == strtolower(trim($tmp[13]))) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						$name = $tmp[2];
						echo "<td align=\"right\" title=\"overall #$tmp[0]\">" . $c . ".&nbsp;</td>";
						echo "<td ><a rel=\"shadowbox;width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name=";
						parseplayer_link($name = $name);
						echo "\">" . trim($tmp[2]) . "</a>";
                        if (($tmp[14] == 0)) {echo " <span class=\"note\">†</span>";}
                        echo "</td>";
						//echo "<td><a href=\"sc.php?id=teams.php&team=$tmp[12]\"><img width=\"21px\" alt=\"$tmp[12]\" title=\"$tmp[11]\" src=\"img/team_logo/small/$tmp[12].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[12]\">" . trim($tmp[11]) . "</a></td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[6]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . number_format(strtr($tmp[8], ",", "."),1) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[9]) . "</td>";
						echo "</tr>\n";
						;$c++;
					} 
				}
			}
			echo "</table><br />";
			fclose($f);
		}
	}

}
?>
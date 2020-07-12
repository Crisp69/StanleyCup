
<? function parseteamsearch($team)
{
	global $team;
	$f = fopen("data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {
				echo strtoupper($tmp[0]);
			}
		}
	}
	
}
?>

<?php

function parsestats($s, $pos, $type, $team, $statscount, $detail)
{global $aaa;

	$upload_dir = "data/stats/";

	$p = StrToUpper($pos);
	if ($s== "allstats") {$n2 = "_team.txt";} else {$n2 = ".txt";}
	$c = 0;
	$f2 = $pos . $s . $type . $n2;
    if(($team == "wpg") && ($s == "allstats") && (!file_exists("data/stats/points27po.txt"))) {$team = "atl";}

	if (File_Exists($upload_dir . $f2)) {
		if ($s == "allstats") {
			$sx = "All Time Stats";
		} else {
			$sx = $s . ". season";
		}
	$z = 1;
	
		echo "<div class=\"text\"><b><center>";
		
		if(($s == "allstats") && ($pos == "points")) {echo "<a class=\"text1\" href=\"sc.php?id=teams.php&team=$team&detail=stats_points\">$sx - ";parseteamsearch($team); echo " - $p</a>";} elseif(($s == "allstats") && ($pos == "goalies")) {echo "<a class=\"text1\" href=\"sc.php?id=teams.php&team=$team&detail=stats_goalies\">$sx - ";parseteamsearch($team); echo " - $p</a>";} else {
		echo "<a class=\"text1\" href=\"sc.php?id=stats.php&team=$team&type=$type&s=$s&pos=$pos\">$sx - ";parseteamsearch($team); echo " - $p</a>";}
		
		

		echo "</b></center>";
		echo "</div><br />\n";
		echo "<script type=\"text/javascript\" src=\"sortabletable.js\"></script>\n";
		
		echo "<table class=\"sort-table\" id=\"$pos\" align=\"center\">\n";
		$c = 1;
		if ($pos == "goalies") {
			echo "<thead>
			<tr>
			<td class=\"trhead\" align=\"center\" width=\"6%\">rk</th>
			<td class=\"trhead\" align=\"left\" width=\"29%\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">name</th>
			<td class=\"trhead\" width=\"17%\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">team</th>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">M</th>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">Shs</th>
			<td class=\"trhead\" width=\"8%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">Svs</th>
			<td class=\"trhead\" width=\"10%\" align=\"center\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">%</th>
			<td class=\"trhead\" width=\"8%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">Shout</th>
			<td class=\"trhead\" width=\"8%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">Perf</td>
			</tr></thead>\n";
			$f = fopen($upload_dir . $f2, "r");
			while (!feof($f) && ($c - 1) < $statscount) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if ($team == trim($tmp[10])) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						$name = $tmp[2];
						
						echo "<td align=\"right\">";
						if(($tmp[3]<22) && ($s=="allstats")) {echo "--";} else {echo $c.".";}
						echo "&nbsp;</td>";
						echo "<td><a rel=\"shadowbox;width=750;height=600;title=$tmp[2] - all time stats in $tmp[9]\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
						parseplayer_link($name = $name);
						echo "\">" . trim($tmp[2]) . "</a></td>";
						echo "<td><a href=\"sc.php?id=teams.php&team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[10]\">" . trim($tmp[9]) . "</a></td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[6], ",", "."). "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . number_format(strtr($tmp[8], ",", "."),1). "</td>";
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
			<td class=\"trhead\" align=\"left\" width=\"29%\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">name</td>
			<td class=\"trhead\" width=\"17%\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">team</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">M</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">G</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">A</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">P</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">+/-</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">Perf</td>
			<td class=\"trhead\" width=\"7%\" align=\"right\" ";
			if($aaa !== "all") {echo "title=\"Click here to sort!\"";}
			echo ">Shs</td>
			</tr></thead>\n";
			$f = fopen($upload_dir . $f2, "r");
			while (!feof($f) && ($c - 1) < $statscount) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					if ($team == trim($tmp[12])) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						$name = $tmp[2];
						
						echo "<td align=\"right\">" . $c . ".&nbsp;</td>";
						echo "<td ><a rel=\"shadowbox;width=750;height=600;title=$tmp[2] - all time stats in $tmp[11]\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name=";
						parseplayer_link($name = $name);
						echo "\">" . trim($tmp[2]) . "</a></td>";
						echo "<td><a href=\"sc.php?id=teams.php&team=$tmp[12]\"><img width=\"21px\" alt=\"$tmp[12]\" title=\"$tmp[11]\" src=\"img/team_logo/small/$tmp[12].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[12]\">" . trim($tmp[11]) . "</a></td>";
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
if (($detail == "stats_goalies") || ($detail == "stats_points")) {
    echo "<script type=\"text/javascript\">";
    
    if ($detail == "stats_points") {echo "
    var st1 = new SortableTable(document.getElementById(\"points\"),
    	[\"None\", \"String\", \"String\", \"Number\", \"Number\",\"Number\",\"Number\", \"Number\", \"Number\", \"Number\"]);";}
    if ($detail == "stats_goalies") {echo "
    var st1 = new SortableTable(document.getElementById(\"goalies\"),
        [\"None\", \"String\", \"String\", \"Number\", \"Number\",\"Number\",\"String\", \"Number\", \"Number\", \"Number\"]);";}
    echo "//<![CDATA[
    function addClassName(el, sClassName) {
    	var s = el.className;
    	var p = s.split(\" \");
    	var l = p.length;
    	for (var i = 0; i < l; i++) {
    		if (p[i] == sClassName)
    			return;
    	}
    	p[p.length] = sClassName;
    	el.className = p.join(\" \").replace( /(^\s+)|(\s+$)/g, \"\" );
    }
    function removeClassName(el, sClassName) {
    	var s = el.className;
    	var p = s.split(\" \");
    	var np = [];
    	var l = p.length;
    	var j = 0;
    	for (var i = 0; i < l; i++) {
    		if (p[i] != sClassName)
    			np[j++] = p[i];
    	}
    	el.className = np.join(\" \").replace( /(^\s+)|(\s+$)/g, \"\" );
    }
    // restore the class names
    st1.onsort = function () {
    	var rows = st1.tBody.rows;
    	var l = rows.length;
    	for (var i = 0; i < l; i++) {
    		removeClassName(rows[i], i % 2 ? \"even\" : \"odd\");
    		addClassName(rows[i], i % 2 ? \"odd\" : \"even\");
    	}
    };

    //]]>
    </script>";
}
}
?>
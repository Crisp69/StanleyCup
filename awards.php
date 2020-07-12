<?php


function parseawards($trophy) {global $id;
	$upload_dir = "data/awards/";
	$n1 = "awards";
	$n2 = ".txt";

	
	$c = 0;
	$f1 = "data/awards/desc/$trophy.txt";
	$fx = fopen($f1,"r");
	$tmp_desc = explode("|",fgets($fx,2000));
	if (trim($tmp_desc[0]) != "") {
		echo "<table class=\"awards\" width=\"50%\" align=\"center\"><tr><td height=\"20px\" colspan=\"3\" align=\"center\"><div class=\"headline\">$tmp_desc[1]<p></div></td></tr>";
		echo "<tr><td></td><td align=\"center\"><br /><img alt=\"$tmp_desc[1]\" height=\"100px\" title=\"$tmp_desc[1]\" class=\"awards\" src=\"img/trophies/$tmp_desc[0].jpg\"><p></td><td></td></tr>";
		echo "<tr><td></td><td width=\"80%\"align=\"center\" valign=\"top\"><div class=\"text\">$tmp_desc[2]<p></div></td><td></td></tr>";
		echo "</table><br />";}
		$z = 1; 
		echo "<table class=\"overview\" align=\"center\"><tr class=\"head\"><th align=\"center\">season</th><th align=\"center\">";
		if (($trophy =="stanleycup") || ($trophy =="pres") || ($trophy =="cla") || ($trophy =="wall") || ($trophy =="jack")  ) {echo "manager";}
		else {echo "player";}
		echo "</th><th colspan=\"2\" align=\"center\">team</tr>";
	$x = File ("data/default/season.txt");
	for ($i = Count ($x); $i > 0 ; $i--) {
		$f2 = $n1.$i.$n2;
		if (file_exists($upload_dir.$f2)) {
		$f = fopen($upload_dir.$f2,"r");
		
		while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {
				if ($trophy == $tmp[0]) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
					$name = $tmp[3];
					
					echo "<td align=\"center\"><a class=\"text1\" href=\"sc.php?id=awards_season.php&s=$i\">$i.</a></td><td align=\"center\">";
					if (($tmp[0] !== "stanleycup") && ($tmp[0] !== "pres") && ($tmp[0] !== "wall") && ($tmp[0] !== "cla") && ($tmp[0] !== "jack") && ($tmp[0] !== "will") && ($tmp[0] !== "vezina") && (trim($tmp[6]) !== "goalie")) {echo "<a rel=\"shadowbox;width=750;height=600;title=$tmp[3] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name=";
					parseplayer_link($name = $name);
					echo "\"><b>$tmp[3]</b></a>";} 
					elseif (($tmp[0] == "will") || ($tmp[0] == "vezina") || (trim($tmp[6]) == "goalie")) {echo "<a rel=\"shadowbox;width=750;height=600;title=$tmp[3] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
					parseplayer_link($name = $name);
					echo "\"><b>$tmp[3]</b></a>";} 
					else {echo "<b><a class=\"text1\" href=\"sc.php?id=manager_stats.php&manager=$tmp[3]\">$tmp[3]</a></b>";}
			echo "</td><td align=\"right\" width=\"15%\"><img width=\"33px\" src=\"img/team_logo/small/$tmp[4].png\" alt=\"$tmp[2]\" title=\"$tmp[2]\"></td><td width=\"35%\">&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[4]\">$tmp[2]</a></td></tr>\n" ;}
				$c++;
			}
		}
		fclose($f);
	}
	}
	echo "</table>";
}

function parseawardslist_awards() {global $id;
	$upload_dir = "data/default/";
	$n = "awards_list.txt";
	
	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose trophy...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) !== "") {
			echo "<option value=\"sc.php?id=$id&trophy=".trim($tmp[1])."\">".trim($tmp[2])."</option>";
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table><br /><br /><br />";
}	
?>
<?php	
if($include_check == "bXnqwa") {
	parseawardslist_awards();
	if ((!isset($trophy) || ($trophy == ""))) {$trophy = "stanleycup";}
	parseawards($trophy);
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
		
		
		?>


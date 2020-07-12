<?php


function parseawards_season($s) {global $current_season;
	$upload_dir = "data/awards/";
	$n1 = "awards";
	$n2 = ".txt";

	$g = ($upload_dir."/".$n1.$current_season.$n2);
	if (file_exists($g)) {$award_season = $current_season;} else {$award_season = $current_season-1;}
	if ((!IsSet($s)) || $s == "") {$s = $award_season;}	
	
	$c = 0;
	$f2 = $n1.$s.$n2;
	if (file_exists($upload_dir.$f2)) {
	echo "<div class=\"text\"><b>: awards $s. season</b></div><br />";
	$f = fopen($upload_dir.$f2,"r");
	while(!feof($f)) {
	$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			$name = $tmp[3];
			
			echo "<table class=\"awards\" align=\"center\" width=\"55%\">";
			echo "<tr><td colspan=\"3\" align=\"center\"valign=\"top\"><br /><a class=\"headline\" href=\"sc.php?id=awards.php&trophy=$tmp[0]\"><b>".trim($tmp[1])."</a></span></b><p></td></tr>";
			echo "<tr><td rowspan=\"1\" width=\"50%\" align=\"center\" valign=\"center\"><a href=\"sc.php?id=awards.php&trophy=$tmp[0]\"><img alt=\"$tmp[1]\" height=\"100px\" title=\"$tmp[1]\" class=\"awards\"src=\"img/trophies/$tmp[0].jpg\"></a></td>";
			echo "<td valign=\"top\" align=\"center\">";
			
					if (($tmp[0] !== "stanleycup") && ($tmp[0] !== "pres") && ($tmp[0] !== "wall") && ($tmp[0] !== "cla") && ($tmp[0] !== "jack") && ($tmp[0] !== "will") && ($tmp[0] !== "vezina") && (trim($tmp[6]) !== "goalie")) {echo "<a rel=\"shadowbox;width=750;height=600;title=$tmp[3] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=points&name=";
					parseplayer_link($name = $name);
					echo "\"><b>$tmp[3]</b></a>";}
					 
					elseif (($tmp[0] == "will") || ($tmp[0] == "vezina") || (trim($tmp[6]) == "goalie")) {echo "<a rel=\"shadowbox;width=750;height=600;title=$tmp[3] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
					parseplayer_link($name = $name);
					echo "\"><b>$tmp[3]</b></a>";} 
					else {echo "<b><a class=\"text1\" href=\"sc.php?id=manager_stats.php&manager=$tmp[3]\">$tmp[3]</a></b>";}
			echo "<p><a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[4]\">$tmp[2]</a><p>";
			echo "<a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[4]\"><img alt=\"$tmp[2]\" width=\"100px\" title=\"$tmp[2]\" src=\"img/team_logo/pics/$tmp[4].jpg\"></td><td width=\"10%\"></a>&nbsp;</td></tr>";
			$f1 = "data/awards/desc/$tmp[0].txt";
			$fx = fopen($f1,"r");
			$tmp_desc = explode("|",fgets($fx,2000));
			if (trim($tmp_desc[0]) != "") {
			echo "<tr><td colspan=\"3\" valign=\"top\" align=\"center\"><span class=\"note\">$tmp_desc[2]</span></td></tr><tr><td colspan=\"2\">&nbsp;</td></tr>";}
			echo "</table><br />";			
			$c++;
		}
	}
	fclose($f);
	}
	else {echo "<br /><center><div class=\"text\">[no awards available]</div></center>";}
}

?>
<?php	

if($include_check == "bXnqwa") {
	parseseasonlist_awards();
	parseawards_season($s);
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
		
		
?>


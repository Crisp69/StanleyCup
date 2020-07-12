<?php

function parsestats_short($stats_season, $pos_short, $statscount)
{global $current_season;
$upload_dir = "data/stats";

	
	$h = ($upload_dir."/points".$stats_season."po.txt");
	if (file_exists($h)) {$season_type_short = "po"; $uuu = "Playoffs";} else {$season_type_short = "reg"; $uuu = "Regular Season";}
	$type_short = $season_type_short;
	

	

	

	$p = StrToUpper($pos);
	$n2 = ".txt";
	$c = 0;
	$f2 = "/" .$pos_short . $stats_season . $type_short . $n2;
	
		if ($pos_short == "goalies") {
		  if(File_exists($upload_dir . $f2)) {
			$f = fopen($upload_dir .  $f2, "r");
			while (!feof($f) && $c < $statscount) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
					echo "<tr><td valign=\"top\" rowspan=\"2\" width=\"60px\" align=\"right\"><img src=\"img/winners/star/".trim($tmp[10]).".jpg\" alt=\"picture not loaded\" width=\"50px\" title=\"$tmp[2]\">&nbsp;</td>";
					$name = $tmp[2];
					echo "<td valign=\"top\"><a rel=\"shadowbox;width=750;height=600;title=$tmp[2] - all time stats\" class=\"polltext\" href=\"jquery.php?id=player_stats.php&amp;pos=goalies&amp;name=";
                    parseplayer_link($name = $name); 
                    echo "&amp;id_player=$tmp[11]&amp;s=$current_season\"><b>" . trim($tmp[2]) . "</b></a></td></tr>";
					echo "<tr><td valign=\"top\"><span class=\"polltext\">" . trim($tmp[6]) . " saves<p></span></td></tr>";
				}$c++;
			}
			fclose($f);
		}
        } 
		elseif (($pos_short !== "goalies") && ($pos !== "stars")) {
		  if(File_exists($upload_dir . $f2)) {
			$f = fopen($upload_dir . $f2, "r");
			while (!feof($f) && $c < $statscount) {
				$tmp = explode("|", fgets($f, 2000));
				if (trim($tmp[0]) != "") {
						echo "<tr><td valign=\"top\" rowspan=\"2\" width=\"60px\" align=\"right\"><img src=\"img/winners/star/".trim($tmp[12]).".jpg\" alt=\"picture not loaded\" width=\"50px\" title=\"$tmp[2]\">&nbsp;</td>";
						$name = $tmp[2];
						echo "<td valign=\"top\"><a rel=\"shadowbox;width=750;height=600;title=$tmp[2] - all time stats\" class=\"polltext\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; 
                        parseplayer_link($name = $name); 
                        echo "&amp;id_player=$tmp[13]&amp;s=$current_season\"><b>" . trim($tmp[2]) . "</b></a></td></tr>\n";
						if($pos_short == "goals") {echo "<tr><td valign=\"top\"><span class=\"polltext\">" . trim($tmp[4]) . " goals<p></span></td></tr>\n";}
						if($pos_short == "points") {echo "<tr><td valign=\"top\"><span class=\"polltext\">" . trim($tmp[6]) . " points<p></span></td></tr>\n";}
						if($pos_short == "defs") {echo "<tr><td valign=\"top\"><span class=\"polltext\">" . trim($tmp[6]) . " points<p></span></td></tr>\n";}
						
				}$c++;
			}
			fclose($f);
		}
        }
	}
	
?>

<?	

echo "<table class=\"star\" width=\"99%\" align=\"center\">\n";
$upload_dir = "data/stats";


	$g = ($upload_dir."/points".$current_season."reg.txt");
	
	if (file_exists($g)) {$stats_season = $current_season;} else {$stats_season = $current_season-1;}

	
	$h = ($upload_dir."/points".$stats_season."po.txt");
	if (file_exists($h)) {$season_type = "po"; $uuu = "Playoffs";} else {$season_type = "reg"; $uuu = "Regular Season";}
	
	echo "<tr><td colspan=\"2\" align=\"center\"><span class=\"date\"><b>Stanley Cup $stats_season - $uuu</b></span></td></tr><tr><td>\n";
	
	
	echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;Most Points</span></td></tr>\n";
    parsestats_short($stats_season, $pos_short = "points", $statscount = 1);
    echo "</table>";
	echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;Most Goals</span></td></tr>\n";
    parsestats_short($stats_season, $pos_short = "goals", $statscount = 1);
    echo "</table>";
	echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;Best Defender</span></td></tr>\n";
    parsestats_short($stats_season, $pos_short = "defs", $statscount = 1);
    echo "</table>";
	echo "<hr class=\"hrstar\"><table class=\"hilitestars\"><tr><td colspan=\"2\" align=\"left\"><span class=\"mag_title\">&nbsp;Best Goalie</span></td></tr>\n";
    parsestats_short($stats_season, $pos_short = "goalies", $statscount = 1);
    echo "</table>";

		echo "</td></tr><tr><td colspan=\"2\" align=\"right\">";
		echo "<hr class=\"hrstar\"><a class=\"date\" href=\"sc.php?id=stats.php\"><b>more stats</a></b>&nbsp;<br /><br /></td></tr></table>\n";
?>
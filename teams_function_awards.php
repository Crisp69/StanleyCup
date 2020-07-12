<?php

/*trofeje*/
function parseawards($team) {global $id;
	$upload_dir = "data/awards/";
	$n1 = "awards";
	$n2 = ".txt";

	
	echo "\n<br /><table aling=\"center\"><tr><td>\n";
	$x = File ("data/default/season.txt");
	$w = 0;
	$z = 1;
    $awards_list = "data/default/awards_list.txt";
    if (file_exists($awards_list)) {
        $f3 = fopen($awards_list,"r");
        while(!feof($f3)) {
            $tmp_awards = explode("|",fgets($f3,2000));
            if (trim($tmp_awards[0]) !== "") {
                $trophy = $tmp_awards[1];
            	for ($i = Count ($x); $i > 0 ; $i--) {
            		$f2 = $n1.$i.$n2;
                   		if (file_exists($upload_dir.$f2)) {
            			$f = fopen($upload_dir.$f2,"r");
            			while(!feof($f)) {
            			$tmp = explode("|",fgets($f,2000));
            				if (trim($tmp[0]) !== "") {
            				    if ($tmp[0] == $trophy) { 
            					if (((($team == "wpg") && ($tmp[4] == "wpg")) || (($team == "wpg") && ($tmp[4] == "atl"))) || ($team == $tmp[4])) {$w = $w + 1;
            					If ($w == 1) {echo "<center><div class=\"headline\">Stanley Cup Awards<p></div></center></td></tr></table><table aling=\"center\"><tr><td>\n";}
                                $name = $tmp[3];
            					echo "<table height=\"165px\" width=\"95px\"align=\"left\"class=\"awards_small\"><tr><td align=\"center\">";
            					echo "<a class=\"note\" href=\"sc.php?id=awards_season.php&s=$i\">$i. season</a></td></tr>";
            					echo "<tr><td height=\"25px\" align=\"center\"><span class=\"whitedate\"><b>$tmp[1]</b></span></td></tr>";
            					echo "<tr><td height=\"25px\" align=\"center\">";
            					if (($tmp[0] !== "stanleycup") && ($tmp[0] !== "pres") && ($tmp[0] !== "wall") && ($tmp[0] !== "cla") && ($tmp[0] !== "jack") && ($tmp[0] !== "will") && ($tmp[0] !== "vezina") && (trim($tmp[6])) !== "goalie") {echo "<a rel=\"shadowbox;width=750;height=600;title=$tmp[3] - all time stats\" class=\"note\" href=\"jquery.php?id=player_stats.php&pos=points&name="; 
                                parseplayer_link($name = $name);
                                echo "\"><b>$tmp[3]</b></a>";} 
            					elseif (($tmp[0] == "will") || ($tmp[0] == "vezina") || (trim($tmp[6]) == "goalie")) {echo "<a rel=\"shadowbox;width=750;height=600;title=$tmp[3] - all time stats\" class=\"note\" href=\"jquery.php?id=player_stats.php&pos=goalies&name=";
                                parseplayer_link($name = $name);
                                echo "\"><b>$tmp[3]</b></a>";} 
            					else {echo "<span class=\"note\"><b><a class=\"note\" href=\"sc.php?id=manager_stats.php&manager=$tmp[3]\">$tmp[3]</a></b></span>";}
            					echo "</td></tr>";
            					echo "<tr><td class=\"trophies3\"align=\"center\"><a href=\"sc.php?id=awards.php&trophy=".trim($tmp[0])."\"><img class=\"awards_small\" alt=\"$tmp[1]\" class=\"logo\" height=\"70px\" title=\"$tmp[1]: $tmp[5]\" src=\"img/trophies/$tmp[0].jpg\"></a></td></tr><tr><td>&nbsp;</td></tr>";
            					echo "</table>\n" ;
            					if ($z ==6) {echo "</td></tr><tr><td>"; $z = 1;} else $z++;
                                } 
            					}
            				}
            			}
            		fclose($f);
            		}
                }
            }
        }
	}fclose($f3); 
echo "</td></tr></table><br />";
}

?>
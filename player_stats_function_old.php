<?php
function parseteamsearch($team) {
	global $team;
	$f = fopen("data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {
				echo " - <a href=\"sc.php?id=teams.php&team=$tmp[1]\">" . strtoupper($tmp[0])."</a>";
			}
		}
	}
	if ($team == "all") {
		echo " - ALL TEAMS";
	}
}


function parsestats($pos, $type, $statscount, $name)
{
	$upload_dir = "data/stats/";
	$x = File ("data/default/season.txt");
	
	$$p = StrToUpper($pos);
	$n2 = ".txt";
	$c = 0;
	
	if ($type == "po") {
		$t = "Playoffs";
	} else {
		$t = "Regular Season";
	}
	echo "<script type=\"text/javascript\" src=\"sortable.js\"></script>";
		echo "<div class=\"text\"><center><b>stats - $t";
		
		echo "</b></center></div><br />";
		echo "<table class=\"sortable\" id=\"1\" align=\"center\">\n";
		$z = 1;
		if ($pos == "goalies") {$m = 0; $s = 0; $v = 0; $o = 0; 
			echo "
			<tr class=\"trhead\">
			<th align=\"center\" width=\"6%\">s</th>
			<th align=\"left\" width=\"27%\">name</th>
			<th width=\"17%\">team</th>
			<th width=\"8%\" align=\"right\">M</th>
			<th width=\"8%\" align=\"right\">Shs</th>
			<th width=\"8%\" align=\"right\">Svs</th>
			<th width=\"10%\" align=\"center\">%</th>
			<th width=\"8%\" align=\"right\">Shout</th>
			<th width=\"8%\" align=\"right\">Perf</th>
			</tr>\n";
			for ($i = Count ($x); $i > 0 ; $i--) {if ($i < 10) {$i = "0".$i;} $f2 = $pos . $i . $type . $n2;
			

			if (file_exists($upload_dir.$f2)) {
			$f = fopen($upload_dir.$f2,"r");
		
			while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {
					$aaa = StrTr ($tmp[2], utf8_decode("áäâacccddéeëeçínnnnóörršdttúuüuuýžÁÄCCDÉEËÍNNÓÖRŠTÚUÜÝŽ'"), "aaaacccddeeeeeinnnnoorrssttuuuuuyzAACCDEEEINNOORSTUUUYZ ");
					if (trim($name) == $aaa) {
						if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						echo "<td align=\"right\"><a class=\"text1\" href=\"sc.php?id=stats.php&team=all&type=$type&s=$i&pos=$pos\">$i.</a>&nbsp;</td>";
						echo "<td>";
                        if (trim($tmp[11]) !== "") {echo "<a class=\"text1\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_player_info.inc&id=$tmp[11]\" target=\"_blank\">". trim($tmp[2]) . "</a></td>";} else {
                        echo trim($tmp[2]) . "</td>";}
						echo "<td><a href=\"sc.php?id=teams.php&team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=stats.php&team=".trim($tmp[10])."&type=$type&s=$i&pos=$pos\">" . trim($tmp[9]) . "</a></td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[6], ",", "."). "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[8], ",", "."). "</td>";
						echo "</tr>\n"; $m = $m + $tmp[3]; $s = $s + $tmp[4]; $v = $v + $tmp[5]; $o = $o + $tmp[7];
					}
					$c++;
				}
			}
			
			fclose($f);
		}  
		}
		if ($s == 0) {$percentage = "0";} else {$percentage = (round(($v / $s) * 100, 2));}
		echo "<tr class=\"sum\"><td></td><td colspan=\"2\">TOTAL</td><td align=\"right\">$m</td><td align=\"right\">$s</td><td align=\"right\">$v</td><td align=\"right\">$percentage%</td><td align=\"right\">$o</td><td></td></tr>";
		echo "</table><br />\n";
	}
	elseif ($pos !== "goalies") {
			$m = 0; $g = 0; $a = 0; $u = 0; $s = 0;
			echo "
			<tr class=\"trhead\">
			<th align=\"center\" width=\"6%\">s</th>
			<th align=\"left\" width=\"27%\">name</th>
			<th width=\"18%\">team</th>
			<th width=\"7%\" align=\"right\">M</th>
			<th width=\"7%\" align=\"right\">G</th>
			<th width=\"7%\" align=\"right\">A</th>
			<th width=\"7%\" align=\"right\">P</th>
			<th width=\"7%\" align=\"right\">+/-</th>
			<th width=\"7%\" align=\"right\">Perf</th>
			<th width=\"7%\" align=\"right\">Shs</th>
			</tr>\n";
			for ($i = Count ($x); $i > 0 ; $i--) {if ($i < 10) {$i = "0".$i;} $f2 = "points" . $i . $type . $n2;
			

			if (file_exists($upload_dir.$f2)) {
			$f = fopen($upload_dir.$f2,"r");
		
			while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {
				$aaa = StrTr ($tmp[2], utf8_decode("áäâacccddéeëeçínnnnóörršdttúuüuuýžÁÄCCDÉEËÍNNÓÖRŠTÚUÜÝŽ'"), "aaaacccddeeeeeinnnnoorrssttuuuuuyzAACCDEEEINNOORSTUUUYZ ");
					if (trim($name) == $aaa) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						echo "<td align=\"right\"><a class=\"text1\" href=\"sc.php?id=stats.php&team=all&type=$type&s=$i&pos=$pos\">$i.</a>&nbsp;</td>";
						echo "<td>";
                        if (trim($tmp[13]) !== "") {echo "<a class=\"text1\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_player_info.inc&id=$tmp[13]\" target=\"_blank\">". trim($tmp[2]) . "</a></td>";} else {
                        echo trim($tmp[2]) . "</td>";}
						echo "<td><a href=\"sc.php?id=teams.php&team=$tmp[12]\"><img width=\"21px\" alt=\"$tmp[12]\" title=\"$tmp[11]\" src=\"img/team_logo/small/$tmp[12].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=stats.php&team=".trim($tmp[12])."&type=$type&s=$i&pos=$pos\">" . trim($tmp[11]) . "</a></td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[6]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . strtr($tmp[8], ",", ".") . "</td>";
						echo "<td align=\"right\">" . trim($tmp[9]) . "</td>";
						echo "</tr>\n"; $m = $m + $tmp[3]; $g = $g + $tmp[4]; $a = $a + $tmp[5]; $p = $g + $a; $u = $u + $tmp[7]; $s = $s + $tmp[9];  
						}
					$c++;
				}
			}
			
			fclose($f);
		}
		}
		if ($u > 0) {$u = "+$u";}
		echo "<tfoot><tr class=\"sum\"><td></td><td colspan=\"2\">TOTAL</td><td align=\"right\">$m</td><td align=\"right\">$g</td><td align=\"right\">$a</td><td align=\"right\">$p</td><td align=\"right\">$u</td><td></td><td align=\"right\">$s</td></tfoot></tr>";
		echo "</table><br />\n";
	} 
}

function parseawards($playername) {global $id;
	$upload_dir = "data/awards/";
	$n1 = "awards";
	$n2 = ".txt";
	
	echo "\n<table align=\"center\"><tr><td>\n";
	$x = File ("data/default/season.txt");
	$z = 1;
	for ($i = Count ($x); $i > 0 ; $i--) {
		$f2 = $n1.$i.$n2;
		if (file_exists($upload_dir.$f2)) {
			$f = fopen($upload_dir.$f2,"r");
			while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
				if (trim($tmp[0]) != "") {$aaa = StrTr ($tmp[3], utf8_decode("áäâacccddéeëeçínnnnóörršdttúuüuuýžÁÄCCDÉEËÍNNÓÖRŠTÚUÜÝŽ'"), "aaaacccddeeeeeinnnnoorrssttuuuuuyzAACCDEEEINNOORSTUUUYZ ");
					if (trim($playername) == $aaa) 
					{
					echo "<table height=\"165px\" width=\"95px\"align=\"left\"class=\"awards_small\"><tr><td align=\"center\">";
					echo "<a class=\"note\" href=\"sc.php?id=awards_season.php&s=$i\">$i. season</a></td></tr>";
					echo "<tr><td height=\"25px\" align=\"center\"><span class=\"whitedate\"><b>$tmp[1]</b></span></td></tr>";
					echo "<tr><td height=\"25px\" align=\"center\"><b>";
					echo "<b><span class=\"note\">$tmp[3]</span></b>"; 
					echo "</td></tr>";
					echo "<tr><td class=\"trophies3\" align=\"center\"><a href=\"sc.php?id=awards.php&trophy=".trim($tmp[0])."\"><img class=\"awards_small\" alt=\"$tmp[1]\" class=\"logo\" height=\"70px\" title=\"$tmp[1]: $tmp[5]\" src=\"img/trophies/$tmp[0].jpg\"></a></td></tr><tr><td>&nbsp;</td></tr>";
					echo "</table>\n" ;
					if ($z ==6) {echo "</td></tr><tr><td>"; $z = 1;} else $z++; 
					}
				}
			}
		fclose($f);
		}
		
	} 
	
	echo "</td></tr></table><br />";
}

?>

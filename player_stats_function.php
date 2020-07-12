<?php
function parseteamsearch($team) {
	//global $team;
	$f = fopen("data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {
				echo ucwords($tmp[0]);
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
		echo "<table class=\"sortable\" id=\"11\" width=\"95%\" align=\"center\">\n";
		$z = 1;
		if ($pos == "goalies") {$m = 0; $s = 0; $v = 0; $o = 0; 
			echo "
			<tr class=\"trhead\">
			<th align=\"center\" width=\"6%\">s</th>
			<th align=\"left\" width=\"27%\">name</th>
			<th align=\"left\" width=\"17%\">team</th>
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
					$aaa = preg_replace('/[^a-zA-Z0-9_ -]/s', '-', $tmp[2]);
                    if (trim($name) == $aaa) {
						if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						echo "<td align=\"right\">$i.&nbsp;</td>";
						echo "<td align=\"left\">";
                        if (trim($tmp[11]) !== "") {echo "<a class=\"text1\" target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_player_info.inc&amp;id=$tmp[11]\">". trim($tmp[2]) . "</a></td>";} else {
                        echo trim($tmp[2]) . "</td>";}
						echo "<td align=\"left\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\">&nbsp;" . trim($tmp[9]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . number_format(strtr($tmp[6], ",", "."),1). "</td>";
						echo "<td align=\"right\">" . trim($tmp[7]) . "</td>";
						echo "<td align=\"right\">" . number_format(strtr($tmp[8], ",", "."),1). "</td>";
						echo "</tr>\n"; $m = $m + $tmp[3]; $s = $s + $tmp[4]; $v = $v + $tmp[5]; $o = $o + $tmp[7]; $perf = $perf + $tmp[3] * (strtr($tmp[8],",",".")); 
					}
					$c++;
				}
			}
			
			fclose($f);
		}  
		}
		if ($s == 0) {$percentage = "0";} else {$percentage = (number_format(($v / $s) * 100, 1));}
        if ($m == 0) {$perf_t = 0;} else {$perf_t = number_format($perf / $m, 1);}
		echo "<tr class=\"sum\"><td></td><td colspan=\"2\" align=\"left\">TOTAL</td><td align=\"right\">$m</td><td align=\"right\">$s</td><td align=\"right\">$v</td><td align=\"right\">$percentage</td><td align=\"right\">$o</td><td align=\"right\">$perf_t</td></tr>";
		echo "</table><br />\n";
	}
	elseif ($pos !== "goalies") {
			$m = 0; $g = 0; $a = 0; $u = 0; $s = 0;$perf=0;
			echo "
			<tr class=\"trhead\">
			<th align=\"center\" width=\"6%\">s</th>
			<th align=\"left\" width=\"27%\">name</th>
			<th align=\"left\" width=\"18%\">team</th>
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
				$aaa = preg_replace('/[^a-zA-Z0-9_ -]/s', '-', $tmp[2]);
					if (trim($name) == $aaa) {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
						echo "<td align=\"right\">$i.&nbsp;</td>";
						echo "<td align=\"left\">";
                        if (trim($tmp[13]) !== "") {echo "<a class=\"text1\" target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_player_info.inc&amp;id=$tmp[13]\">". trim($tmp[2]) . "</a></td>";} else {
                        echo trim($tmp[2]) . "</td>";}
						echo "<td align=\"left\"><img width=\"21px\" alt=\"$tmp[12]\" title=\"$tmp[11]\" src=\"img/team_logo/small/$tmp[12].png\">&nbsp;" . trim($tmp[11]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[5]) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[6]) . "</td>";
						echo "<td align=\"right\">" . vsprintf("%+d", trim($tmp[7])) . "</td>";
						echo "<td align=\"right\">" . number_format(strtr($tmp[8], ",", "."),1) . "</td>";
						echo "<td align=\"right\">" . trim($tmp[9]) . "</td>";
						echo "</tr>\n"; $m = $m + $tmp[3]; $g = $g + $tmp[4]; $a = $a + $tmp[5]; $p = $g + $a; $u = $u + $tmp[7]; $s = $s + $tmp[9]; $perf =  $perf + $tmp[3] * (strtr($tmp[8],",",".")); 
                        
						}
					$c++;
				}
			}
			
			fclose($f);
		}
		}
		if ($u > 0) {$u = "+$u";} 
        if ($m == 0) {$perf_t = 0;} else {$perf_t = number_format($perf / $m, 1);}
		echo "<tfoot><tr class=\"sum\"><td></td><td colspan=\"2\" align=\"left\">TOTAL</td><td align=\"right\">$m</td><td align=\"right\">$g</td><td align=\"right\">$a</td><td align=\"right\">$p</td><td align=\"right\">$u</td><td align=\"right\">$perf_t</td><td align=\"right\">$s</td></tfoot></tr>";
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
            				if (trim($tmp[0]) != "") {$aaa = preg_replace('/[^a-zA-Z0-9_ -]/s', '-', $tmp[3]);
                            if ($tmp[0] == $trophy) {
            					if (trim($playername) == $aaa) 
                					{
                					echo "<table height=\"165px\" width=\"95px\"align=\"left\"class=\"awards_small\"><tr><td align=\"center\">";
                					echo "$i. season</td></tr>";
                					echo "<tr><td height=\"25px\" align=\"center\"><span class=\"whitedate\"><b>$tmp[1]</b></span></td></tr>";
                					echo "<tr><td height=\"25px\" align=\"center\"><b>";
                					echo "<b><span class=\"note\">$tmp[3]</span></b>"; 
                					echo "</td></tr>";
                					echo "<tr><td class=\"trophies3\" align=\"center\"><img class=\"awards_small\" alt=\"$tmp[1]\" class=\"logo\" height=\"70px\" title=\"$tmp[1]: $tmp[5]\" src=\"img/trophies/$tmp[0].jpg\"></td></tr><tr><td>&nbsp;</td></tr>";
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
        }fclose($f3);
    }
	echo "</td></tr></table><br />";
}

function parseplayerstats_name($id_player, $pos)  {global $current_season;
    if ($pos == "points") {
        $file = "data/stats/points_round".$current_season.".txt";
        $count = 0;$z = 1;
        if(file_exists($file)) {
            $f = fopen($file,"r");
            while(!feof($f)) {
                $tmp_name = explode("|",fgets($f,2000));
                if($id_player == $tmp_name[12]) {
                    $count = $count + 1;
                    if($count == 1) {echo "<span class=\"text\"><b><a target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_player_info.inc&amp;id=$id_player\" class=\"text1\">$tmp_name[1]</a> - $tmp_name[10] <img width=\"21px\" alt=\"".strtoupper($tmp_name[11])."\" title=\"".strtoupper($tmp_name[11])."\" src=\"img/team_logo/small/$tmp_name[11].png\"></b><br /><br />game by game record - season $current_season</span><br /><br />";}
                }
            }
            if($count != 0) {
                echo "<table align=\"center\" width=\"95%\" class=\"sortable\">";
                echo "<th width=\"13%\" align=\"left\">date</th>";
                echo "<th align=\"left\">against</th>";
                echo "<th width=\"7%\" align=\"right\">G</th>";
                echo "<th width=\"7%\" align=\"right\">A</th>";
                echo "<th width=\"7%\" align=\"right\">P</th>";
                echo "<th width=\"7%\" align=\"right\">+/-</th>";
                echo "<th width=\"7%\" align=\"right\">perf</th>";
                echo "<th width=\"7%\" align=\"right\">sho</th>";
                echo "<th width=\"7%\" align=\"right\">PPG</th>";
                echo "<th width=\"7%\" align=\"right\">SHG</th>";
                echo "<th width=\"7%\" align=\"right\">PIM</th>";
                echo "<th width=\"7%\" align=\"right\">USG</th>";
                $f = fopen($file,"r");
                while(!feof($f)) {
                    $tmp_stats = explode("|",fgets($f,2000));
                    if($id_player == $tmp_stats[12]) {
                        if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
                        echo "<td align=\"left\">&nbsp;$tmp_stats[18]</td>";$team = $tmp_stats[17];
                        echo "<td align=\"left\">&nbsp;<img  width=\"21px\" alt=\"".strtoupper($tmp_stats[17])."\" title=\"".strtoupper($tmp_stats[17])."\" src=\"img/team_logo/small/$tmp_stats[17].png\">&nbsp;";parseteamsearch($team = trim($tmp_stats[17])); echo "</td>";
                        echo "<td align=\"right\">$tmp_stats[3]</td>";
                        echo "<td align=\"right\">$tmp_stats[4]</td>";
                        echo "<td align=\"right\">$tmp_stats[5]</td>";
                        echo "<td align=\"right\">$tmp_stats[6]</td>";
                        echo "<td align=\"right\">$tmp_stats[7]</td>";
                        echo "<td align=\"right\">$tmp_stats[8]</td>";
                        echo "<td align=\"right\">$tmp_stats[13]</td>";
                        echo "<td align=\"right\">$tmp_stats[14]</td>";
                        echo "<td align=\"right\">$tmp_stats[15]</td>";
                        echo "<td align=\"right\">$tmp_stats[16]</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            }
        }
        if($count == 0) {
            echo "selected player has played 0 games in current season";
        }
    }
    if ($pos == "goalies") {
        $file = "data/stats/goalies_round".$current_season.".txt";
        $count = 0;$z = 1;
        if(file_exists($file)) {
            $f = fopen($file,"r");
            while(!feof($f)) {
                $tmp_name = explode("|",fgets($f,2000));
                if($id_player == $tmp_name[11]) {
                    $count = $count + 1;
                    if($count == 1) {echo "<b>$tmp_name[2] - $tmp_name[9] <img width=\"21px\" alt=\"".strtoupper($tmp_name[10])."\" title=\"".strtoupper($tmp_name[10])."\" src=\"img/team_logo/small/$tmp_name[10].png\"></b><br /><br />game by game record - season $current_season<br /><br />";}
                }
            }
            if($count != 0) {
                echo "<table align=\"center\" width=\"95%\" class=\"sortable\">";
                echo "<th width=\"15%\" align=\"left\">date</th>";
                echo "<th align=\"left\">against</th>";
                echo "<th width=\"8%\" align=\"right\">shs</th>";
                echo "<th width=\"8%\" align=\"right\">svs</th>";
                echo "<th width=\"8%\" align=\"right\">%</th>";
                echo "<th width=\"8%\" align=\"right\">shout</th>";
                echo "<th width=\"8%\" align=\"right\">perf</th>";
                echo "<th width=\"8%\" align=\"right\">min</th>";
                $f = fopen($file,"r");
                while(!feof($f)) {
                    $tmp_stats = explode("|",fgets($f,2000));
                    if($id_player == $tmp_stats[11]) {
                        if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
                        echo "<td align=\"left\">&nbsp;$tmp_stats[15]</td>";$team = $tmp_stats[14];
                        echo "<td align=\"left\">&nbsp;<img  width=\"21px\" alt=\"".strtoupper($tmp_stats[14])."\" title=\"".strtoupper($tmp_stats[14])."\" src=\"img/team_logo/small/$tmp_stats[14].png\">&nbsp;";parseteamsearch($team = trim($tmp_stats[14])); echo "</td>";
                        echo "<td align=\"right\">$tmp_stats[4]</td>";
                        echo "<td align=\"right\">$tmp_stats[5]</td>";
                        echo "<td align=\"right\">".number_format(strtr($tmp_stats[6], ",", "."),1)."</td>";
                        echo "<td align=\"right\">$tmp_stats[7]</td>";
                        echo "<td align=\"right\">".number_format(strtr($tmp_stats[8], ",", "."),1)."</td>";
                        echo "<td align=\"right\">".number_format(strtr($tmp_stats[12], ",", "."),0)."</td>";
                        
                        echo "</tr>";
                    }
                }
                echo "</table>";
            }
        }
        if($count == 0) {
            echo "<span class=\"text\">selected player has played 0 games in current season</span>";
        }
    }
    echo $name;
}



?>

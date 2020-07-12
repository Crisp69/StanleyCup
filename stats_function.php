
<? function parseteamsearch($team)
{
	global $team;
	$f = fopen("data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {
				echo " - " . strtoupper($tmp[0]);
			}
		}
	}
	if ($team == "all") {
		echo " - ALL TEAMS";
	}
}
?>

<?php

function parsestats($s, $pos, $type, $team, $statscount, $hilighted, $sort, $page, $active)
{global $aaa, $current_season;

	$upload_dir = "data/stats/";
//echo $s.$current_season;
	$p = StrToUpper($pos);
	$n2 = ".txt";
	$c = 0;
	$f2 = $pos . $s . $type . $n2;
	if ($type == "po") {
		$t = "Playoffs";
	} else {
		$t = "Regular Season";
	}
	
	if (File_Exists($upload_dir . $f2)) {
		if ($s == "allstats") {
			$sx = "All Time Stats";
		} else {
			$sx = $s . ". season";
		}
	$z = 1;
    if (isset($active) && ($active != "") && ($active != "all")) {$active_link = "&amp;active=$active"; $active_title = " - ACTIVE PLAYERS";}
	if ($pos !== "stars") {
	    if($pos == "goals") {$po = "points";} else {$po = $pos;}
		echo "<center><span class=\"text1\"><b><a class=\"text1\" href=\"sc.php?id=stats.php&amp;team=$team&amp;type=$type&amp;s=$s&amp;pos=$po&amp;sort=$sort$active_link\">stats - $sx";
		if ($pos !== "stars") {echo " - $t";}
        parseteamsearch($team);
		if ($pos == "goalies") {echo " - GOALIES";} elseif ($pos == "defs") {echo " - DEFENDERS";} else {echo " - ALL SKATERS";} 
        $query = array("gms" => "games", "goals" =>"goals", "asists" => "asists", "points" => "points", "plus" => "+/-", "perf" => "performance", "shs" => "shots", "svs" => "saves", "svs_perc" => "saves %", "shotout" => "shot-outs", "ppg" => "powerplay goals", "shg" => "shorthanded goals", "pim" => "penalty minutes", "mins" => "minutes played", "gaa" => "goals against average");
		}
    if($sort == "goals") {
        $table_link = "<a class=\"trhead\" href=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;type=$type&amp;team=$team$active_link";
	    $head_link = "<a class=\"note1\" href=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;type=$type&amp;team=$team$active_link";
    }
    else {
        $table_link = "<a class=\"trhead\" href=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;type=$type&amp;team=$team$active_link";
    	$head_link = "<a class=\"note1\" href=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;type=$type&amp;team=$team$active_link";
    }
        if(!isset($page) || ($page == "")) {$page = 1;}
        $start = $statscount * ($page - 1); 
        $end = $statscount * $page; 
	if(($s < 27) && ($team == "wpg")) {$team = "atl";}
    //BRANKARI
	if ($pos == "goalies") {
        $srts_g = array("gms", "svs_perc", "shs", "svs", "shotout", "perf", "gaa", "mins");
        if (!in_array($sort, $srts_g)) {$sort = "svs_perc";}
        foreach ($query as $key => $value) {if ($sort == $key) {echo " - $value";}} echo "$active_title</a></b></center></span>\n";
        
	    echo "<center><span class=\"note1\"><b>sort stats by -></b> $head_link&sort=gms\">games</a> | $head_link&sort=shs\">shots</a> | $head_link&sort=svs\">svs</a> | $head_link&sort=svs_perc\">saves %</a> | $head_link&sort=shotout\">shot-outs</a> | $head_link&sort=perf\">performance</a>"; if($s != "allstats") {echo " | $head_link&sort=gaa\">goals against average</a> | $head_link&sort=mins\">minutes played</a></span>";}
	    echo "</center><br /><table class=\"sort-table\" align=\"center\">\n";
		echo "<thead>
		<tr>
		<td class=\"trhead\" align=\"center\" width=\"5%\">rk</td>
		<td class=\"trhead\" align=\"left\" width=\"22%\">name</td>";
		if($s != "allstats") {echo "<td class=\"trhead\" width=\"18%\">team</td>";} else {echo "<td class=\"trhead\" width=\"14%\">team</td>";} 
		echo "<td class=\"trhead\" width=\"5%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=gms\">M</a></td>
		<td class=\"trhead\" width=\"7%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=shs\">Shs</a></td>
		<td class=\"trhead\" width=\"7%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=svs\">Svs</a></td>
		<td class=\"trhead\" width=\"9%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=svs_perc\">%</a>&nbsp;</td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=shotout\">SO</a></td>
		<td class=\"trhead\" width=\"7%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=perf\">Per</a></td>";
        if($s != "allstats") {echo "
		<td class=\"trhead\" width=\"7%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=gaa\">GAA</a></td>
		<td class=\"trhead\" width=\"7%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=mins\">MIN</a></td>";}
		echo "</tr></thead>\n";
        
        //SORTOVANIE
        if(File_exists($upload_dir . $f2)) {
		$f = fopen($upload_dir . $f2, "r");
		while (!feof($f)) {
			$tmp_stats = explode("|", fgets($f, 2000));
			if (trim($tmp_stats[0]) != "") {
                 $srt[svs_perc] = ((strtr(trim($tmp_stats[5]),",",".")/strtr(trim($tmp_stats[4]),",",".")*100)+100)*10;
                 $srt[gms] = trim($tmp_stats[3])+100;
                 $srt[shs] = trim($tmp_stats[4])+1000;
                 $srt[svs] = trim($tmp_stats[5])+1000;
                 $srt[shotout] = trim($tmp_stats[7])+100;
                 $srt[perf] = strtr(trim($tmp_stats[8]),",",".")*10+1000;
                 if(!isset($tmp_stats[13]) || $tmp_stats[13] == 0) {$tmp_stats[13] = number_format(($tmp_stats[4]-$tmp_stats[5])/$tmp_stats[3],2);}
                 $srt[gaa] = 9999-trim($tmp_stats[13])*100;
                 if(!isset($tmp_stats[12]) || ($s == "allstats")) {$mins="-";} else {$mins = $tmp_stats[12];}
                 $srt[mins] = trim($mins)+1000;
                 if(($s == "allstats") && ($active == "active")) {
                    if (trim($tmp_stats[12])==1) {
                         $base_row = $tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|"."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14];
                         
                         if($sort == "svs_perc") {$sort_string = $srt[svs_perc].$srt[shs].$srt[shotouts]."!!".$base_row;} 
                         else {$sort_string = $srt[$sort].$srt[svs_perc].$srt[games].$srt[shs].$srt[shotouts].$srt[perf]."!!".$base_row;}
                         
                         $sort_strings[] = $sort_string;
                         }
                    }
                    else {
                        $base_row = $tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|"."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14];
                     
                     if($sort == "svs_perc") {$sort_string = $srt[svs_perc].$srt[shs].$srt[shotouts]."!!".$base_row;} 
                     else {$sort_string = $srt[$sort].$srt[svs_perc].$srt[games].$srt[shs].$srt[shotouts].$srt[perf]."!!".$base_row;}
                     
                     $sort_strings[] = $sort_string;
                    }
            }
        }fclose($f);
        arsort($sort_strings);
        
        $i = 1;
        $c = 0;
        $u = 1;

        //ZOBRAZENIE HODNOTENYCH BRANKAROV
        
        foreach ($sort_strings as $sort_string) {
            $tmp_hlp = explode("!!",$sort_string);
            $tmp = explode("|", $tmp_hlp[1]);
            $name = $tmp[2];
            
            if(trim($tmp[0]) !== "-") {
			     if ($team == trim($tmp[10])) {
			         if(($c < $end) && ($c  >= $start)) {
                        if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
    				    echo "<td align=\"right\" title=\"overall #$u in $sort\"";
                        echo ">".$i.".</td>";
                        echo "<td><a rel=\"shadowbox;&width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=goalies&amp;name="; parseplayer_link($name = $name); if($s != "allstats") {echo "&amp;id_player=$tmp[12]";}
                        if($s == $current_season) {echo "&amp;s=$current_season";}echo "\">".trim($tmp[2])."</a>"; if (($s == "allstats") && ($tmp[13] == 0)) {echo " <span class=\"note\">†</span>";} echo "</td>";
    					echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[10]\">".trim($tmp[9])."</a></td>";
    					echo "<td ";if ($sort == "gms") {echo "class=\"sort\" ";} echo "align=\"right\">".trim($tmp[3])."</td>";
    					echo "<td ";if ($sort == "shs") {echo "class=\"sort\" ";} echo "align=\"right\">".trim($tmp[4])."</td>";
    					echo "<td ";if ($sort == "svs") {echo "class=\"sort\" ";} echo "align=\"right\">".trim($tmp[5])."</td>";
    					echo "<td ";if ($sort == "svs_perc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[6], ",", "."),1)."</td>";
    					echo "<td ";if ($sort == "shotout") {echo "class=\"sort\" ";} echo "align=\"right\">".trim($tmp[7])."</td>";
    					echo "<td ";if ($sort == "perf") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[8], ",", "."),1)."</td>";
                        if($s != "allstats") {echo "<td ";if ($sort == "gaa") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[14], ",", "."),2)."</td>";
                        echo "<td ";if ($sort == "mins") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[13], ",", "."),0)."</td>";}
    					echo "</tr>\n";
                    } $i++;$c++;
                }
                elseif ($team == "all") {
                    if(($c < $end) && ($c  >= $start)) {
                        if(trim($tmp[10]) == $hilighted) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                        echo "<td align=\"right\">".$i.".</td>";
                        echo "<td><a rel=\"shadowbox;&width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=goalies&amp;name="; parseplayer_link($name = $name); if($s != "allstats") {echo "&amp;id_player=$tmp[12]";}
                    if($s == $current_season ) {echo "&amp;s=$current_season";}echo "\">".trim($tmp[2])."</a>"; if (($s == "allstats") && ($tmp[13] == 0)) {echo " <span class=\"note\">†</span>";} echo "</td>";
    					echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[10]\">".trim($tmp[9])."</a></td>";
    					echo "<td ";if ($sort == "gms") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[3])."</td>";
    					echo "<td ";if ($sort == "shs") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[4])."</td>";
    					echo "<td ";if ($sort == "svs") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[5])."</td>";
    					echo "<td ";if ($sort == "svs_perc") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format(strtr($tmp[6], ",", "."),1)."</td>";
    					echo "<td ";if ($sort == "shotout") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[7])."</td>";
    					echo "<td ";if ($sort == "perf") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format(strtr($tmp[8], ",", "."),1)."</td>";
                        if($s != "allstats") {echo "<td ";if ($sort == "gaa") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[14], ",", "."),2)."</td>";
                        echo "<td ";if ($sort == "mins") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[13], ",", "."),0)."</td>";}
    					echo "</tr>\n"; 
                    }$i++;$c++;  
                }$u++;
            }
        }
        
        //ZOBRAZENIE NEHODNOTENYCH BRANKAROV
        foreach ($sort_strings as $sort_string) {
            $tmp_hlp = explode("!!",$sort_string);
            $tmp = explode("|", $tmp_hlp[1]);
            $name = $tmp[2];
            if(trim($tmp[0]) == "-") {
                if ($team == trim($tmp[10])) {
                    if(($c < $end) && ($c  >= $start)) {
                        if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
    				    echo "<td align=\"right\">-&nbsp;</td>";
                        echo "<td><a rel=\"shadowbox;&width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=goalies&amp;name="; parseplayer_link($name = $name); if($s != "allstats") {echo "&amp;id_player=$tmp[12]";}
                    if($s == $current_season ) {echo "&amp;s=$current_season";}echo "\">".trim($tmp[2])."</a>"; if (($s == "allstats") && ($tmp[13] == 0)) {echo " <span class=\"note\">†</span>";} echo "</td>";
    					echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[10]\">".trim($tmp[9])."</a></td>";
    					echo "<td ";if ($sort == "gms") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[3])."</td>";
    					echo "<td ";if ($sort == "shs") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[4])."</td>";
    					echo "<td ";if ($sort == "svs") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[5])."</td>";
    					echo "<td ";if ($sort == "svs_perc") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format(strtr($tmp[6], ",", "."),1)."</td>";
    					echo "<td ";if ($sort == "shotout") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[7])."</td>";
    					echo "<td ";if ($sort == "perf") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format(strtr($tmp[8], ",", "."),1)."</td>";
                        if($s != "allstats") {
                        echo "<td ";if ($sort == "gaa") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[14], ",", "."),2)."</td>";
                        echo "<td ";if ($sort == "mins") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[13], ",", "."),0)."</td>";}
    					echo "</tr>\n";
                    }$c++;
                }
                elseif ($team == "all") {
                    if(($c < $end) && ($c  >= $start)) {
                        if(trim($tmp[10]) == $hilighted) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                        echo "<td align=\"right\">-&nbsp;</td>";
                        echo "<td><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=goalies&amp;name="; parseplayer_link($name = $name); if($s != "allstats") {echo "&amp;id_player=$tmp[12]";}
                    if($s == $current_season ) {echo "&amp;s=$current_season";}echo "\">".trim($tmp[2])."</a>"; if (($s == "allstats") && ($tmp[13] == 0)) {echo " <span class=\"note\">†</span>";} echo "</td>";
    					echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[10]\"><img width=\"21px\" alt=\"$tmp[10]\" title=\"$tmp[9]\" src=\"img/team_logo/small/$tmp[10].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[10]\">".trim($tmp[9])."</a></td>";
    					echo "<td ";if ($sort == "gms") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[3])."</td>";
    					echo "<td ";if ($sort == "shs") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[4])."</td>";
    					echo "<td ";if ($sort == "svs") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[5])."</td>";
    					echo "<td ";if ($sort == "svs_perc") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format(strtr($tmp[6], ",", "."),1)."</td>";
    					echo "<td ";if ($sort == "shotout") {echo "class=\"sort\" ";} echo " align=\"right\">".trim($tmp[7])."</td>";
    					echo "<td ";if ($sort == "perf") {echo "class=\"sort\" ";} echo " align=\"right\">".number_format(strtr($tmp[8], ",", "."),1)."</td>";
                        if($s != "allstats") {echo "<td ";if ($sort == "gaa") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[14], ",", "."),2)."</td>";
                        echo "<td ";if ($sort == "mins") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(strtr($tmp[13], ",", "."),0)."</td>";}
    					echo "</tr>\n";
                    }$c++;
                }
                
            }
        }
		echo "</table><br />\n";
        }
	} 
    
    //HVIEZDY
	elseif ($pos == "stars") 
		{echo "<table class=\"sort-table\" align=\"center\">\n";echo "<thead>
		<tr>
		<th align=\"center\" width=\"5%\">rk</th>
		<th align=\"left\" width=\"30%\">name</th>
		<th width=\"25%\">team</th>
		<th width=\"10%\" align=\"right\">1st</th>
		<th width=\"10%\" align=\"right\">2nd</th>
		<th width=\"10%\" align=\"right\">3rd</th>
		<th width=\"10%\" align=\"right\">Points</th>
		</tr></thead>\n";
        if(File_exists($upload_dir . $f2)) {
		$f = fopen($upload_dir . $f2, "r");
		while (!feof($f) && $c < $statscount) {
			$tmp = explode("|", fgets($f, 2000));
			if (trim($tmp[0]) != "") {if(trim($tmp[7]) == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {
		if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
					echo "<td align=\"right\">" . trim($tmp[0]) . ".&nbsp;</td>";
					echo "<td>" . trim($tmp[1]) . "</td>";
					echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[7]\"><img width=\"21px\" alt=\"$tmp[7]\" title=\"$tmp[6]\" src=\"img/team_logo/small/$tmp[7].png\"></a>&nbsp;<a class=\"text1\" class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[7]\">" . trim($tmp[6]) . "</a></td>";
					echo "<td align=\"right\">" . trim($tmp[2]) . "</td>";
					echo "<td align=\"right\">" . trim($tmp[3]) . "</td>";
					echo "<td align=\"right\">" . trim($tmp[4]) . "</td>";
					echo "<td align=\"right\">" . trim($tmp[5]) . "&nbsp;</td>";
					echo "</tr>\n";
					$c++;	}
				
			}fclose($f);
        }
		echo "</table><br /><br />\n";
	} 
    
    //HRACI V POLI
	elseif (($pos !== "goalies") && ($pos !== "stars")) {
	    $srts = array("gms", "goals", "points", "asists", "plus", "perf", "shs", "ppg", "shg", "pim");
        if (!in_array($sort, $srts)) {$sort = "points";} 
	    foreach ($query as $key => $value) {if ($sort == $key) {echo " - $value";}} echo "$active_title</a></b></center>\n";
        
        echo "<center><span class=\"note1\"><b>sort stats by -></b> $head_link&amp;sort=gms\">games</a> | $head_link&amp;sort=goals\">goals</a> | $head_link&amp;sort=asists\">asists</a> | $head_link&amp;sort=points\">points</a> | $head_link&amp;sort=plus\">+/-</a> | $head_link&amp;sort=perf\">performance</a> | $head_link&amp;sort=shs\">shots</a>";
        if($s!="allstats") {echo "| $head_link&amp;sort=ppg\">PP goals</a> | $head_link&amp;sort=shg\">SH goals</a> | $head_link&amp;sort=pim\">penalties</a>";}
	    echo "</span></center><br /><table class=\"sort-table\" align=\"center\">\n";
		echo "<thead><tr>
		<td class=\"trhead\" align=\"center\" width=\"5%\">rk</td>
		<td class=\"trhead\" align=\"left\" width=\"24%\">name</td>
        <td class=\"trhead\" width=\"19%\">team</td> 
		<td class=\"trhead\" width=\"4%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=gms\">M</a></td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=goals\">G</a></td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=asists\">A</td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=points\">Pts</a></td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=plus\">+/-</a></td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=perf\">Per</a></td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=shs\">Shs</a></td>";
        if($s!="allstats") {echo 
        "<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=ppg\">PPG</a></td>
		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=shg\">SHG</a></td>
 		<td class=\"trhead\" width=\"6%\" align=\"right\" title=\"Click here to sort!\">$table_link&amp;sort=pim\">PIM</a></td>";}
		echo "</tr></thead>\n";
		if(file_exists($upload_dir . $f2)) {
        $f = fopen($upload_dir . $f2, "r");
		while (!feof($f)) {
			$tmp_stats = explode("|", fgets($f, 2000));
			if (trim($tmp_stats[0]) != "") {
                 $srt[gms] = $tmp_stats[3] + 100;
                 $srt[goals] = $tmp_stats[4] + 100;
                 $srt[asists] = $tmp_stats[5] + 100;
                 $srt[points] = $tmp_stats[6] + 100;
                 $srt[plus] = $tmp_stats[7] + 500;
                 $srt[perf] = $tmp_stats[8]*10 + 1000;
                 $srt[shs] = $tmp_stats[9] + 1000;
                 if(!isset($tmp_stats[14]) || ($tmp_stats[14] == "") || ($s == "allstats")) {$ppg="-";} else {$ppg = $tmp_stats[14];}
                 $srt[ppg] = $ppg + 100;
                 if(!isset($tmp_stats[15]) || ($s == "allstats")) {$tmp_stats[15]="-";}
                 $srt[shg] = $tmp_stats[15] + 100;
                 if(!isset($tmp_stats[16]) || ($s == "allstats")) {$tmp_stats[16]="-";}
                 $srt[pim] = $tmp_stats[16] + 1000;
                 if(($tmp_stats[9] !== "0") && ($tmp_stats[9] !== "")) {$srt[perc] = (($tmp_stats[4]/$tmp_stats[9])+100)*1000;} else {$srt[perc] = "000000";}
                 
                 if(($s == "allstats") && ($active == "active")) {
                    if (trim($tmp_stats[14])==1) {
                        $base_row = $tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14]."|";
                        if($sort == "points") {$sort_string = $srt[points].$srt[goals].$srt[perf]."!!".$base_row;} 
                 elseif($sort == "goals") {$sort_string = $srt[goals].$srt[points].$srt[perc]."!!".$base_row;}
                 else {$sort_string = $srt[$sort].$srt[points].$srt[plus].$srt[goals].$srt[perf]."!!".$base_row;}
                 
                 $sort_strings[] = $sort_string;
                        
                    }
                 }

                 else {$base_row = $tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14]."|".$tmp_stats[15]."|".$tmp_stats[16]."|".$tmp_stats[17]."|";
                 
                 if($sort == "points") {$sort_string = $srt[points].$srt[goals].$srt[perf]."!!".$base_row;} 
                 elseif($sort == "goals") {$sort_string = $srt[goals].$srt[points].$srt[perc]."!!".$base_row;}
                 else {$sort_string = $srt[$sort].$srt[points].$srt[plus].$srt[goals].$srt[perf]."!!".$base_row;}
                 
                 $sort_strings[] = $sort_string;

                 }
                 
            }
        }fclose($f);
        arsort($sort_strings);
        
        $i = 1;
        $c = 0;
        $u = 1;
        //ZOBRAZENIE HRACOV V POLI
        
        foreach ($sort_strings as $sort_string) {
            $tmp_hlp = explode("!!",$sort_string);
            $tmp = explode("|", $tmp_hlp[1]);
        	$name = $tmp[2];
            
                
			if ($team == trim($tmp[12])) {
			     if (($c >= $start) && ($c < $end)) {
                    if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
    				echo "<td align=\"right\" title=\"overall #$u in $sort\"";
                    echo ">$i.</td>";
    				echo "<td ><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); if($s != "allstats") {echo "&amp;id_player=$tmp[13]";}
                    if($s == $current_season ) {echo "&amp;s=$current_season";}echo "\">" . trim($tmp[2]) . "</a>";
                    if (($s == "allstats") && ($tmp[14] == 0)) {echo " <span class=\"note\">†</span>";}
                    echo "</td>";
    				echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[12]\"><img width=\"21px\" alt=\"$tmp[12]\" title=\"$tmp[11]\" src=\"img/team_logo/small/$tmp[12].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=teams.php&amp;team=$tmp[12]\">" . trim($tmp[11]) . "</a></td>";
    				echo "<td ";if ($sort == "gms") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[3]) . "</td>";
    				echo "<td ";if ($sort == "goals") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[4]) . "</td>";
    				echo "<td ";if ($sort == "asists") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[5]) . "</td>";
    				echo "<td ";if ($sort == "points") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[6]) . "</td>";
    				echo "<td ";if ($sort == "plus") {echo "class=\"sort\" ";} echo " align=\"right\">" . vsprintf("%+d", trim($tmp[7])) . "</td>";
    				echo "<td ";if ($sort == "perf") {echo "class=\"sort\" ";} echo " align=\"right\">" . number_format(strtr($tmp[8], ",", "."),1) . "</td>";
    				echo "<td ";if ($sort == "shs") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[9]) . "</td>";
                    if($s != "allstats") {echo "<td ";if ($sort == "ppg") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[14]) . "</td>";
                    echo "<td ";if ($sort == "shg") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[15]) . "</td>";
                    echo "<td ";if ($sort == "pim") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[16]) . "</td>";}
    				echo "</tr>\n";
                }$i++;$c++;
			} elseif ($team == "all") {
			     if (($c >= $start) && ($c < $end)) {
                    if(trim($tmp[12]) == $hilighted) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                    echo "<td align=\"right\">$i.</td>";
    				echo "<td ><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); if($s != "allstats") {echo "&amp;id_player=$tmp[13]";}
                    if($s == $current_season ) {echo "&amp;s=$current_season";}echo "\">" . trim($tmp[2]) . "</a> ";
                    if (($s == "allstats") && ($tmp[14] == 0)) {echo " <span class=\"note\">†</span>";}
                    echo "</td>";
    				echo "<td><a href=\"sc.php?id=teams.php&amp;team=$tmp[12]\"><img width=\"21px\" alt=\"$tmp[12]\" title=\"$tmp[11]\" src=\"img/team_logo/small/$tmp[12].png\"></a>&nbsp;<a class=\"text1\" href=\"sc.php?id=stats.php&amp;team=$tmp[12]&amp;type=$type&amp;s=$s&amp;pos=$pos\">" . trim($tmp[11]) . "</a></td>";
    				echo "<td ";if ($sort == "gms") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[3]) . "</td>";
    				echo "<td ";if ($sort == "goals") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[4]) . "</td>";
    				echo "<td ";if ($sort == "asists") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[5]) . "</td>";
    				echo "<td ";if ($sort == "points") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[6]) . "</td>";
    				echo "<td ";if ($sort == "plus") {echo "class=\"sort\" ";} echo " align=\"right\">" . vsprintf("%+d", trim($tmp[7])) . "</td>";
    				echo "<td ";if ($sort == "perf") {echo "class=\"sort\" ";} echo " align=\"right\">" . number_format(strtr($tmp[8], ",", "."),1) . "</td>";
    				echo "<td ";if ($sort == "shs") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[9]) . "</td>";
                    if($s != "allstats") {echo "<td ";if ($sort == "ppg") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[14]) . "</td>";
                    echo "<td ";if ($sort == "shg") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[15]) . "</td>";
                    echo "<td ";if ($sort == "pim") {echo "class=\"sort\" ";} echo " align=\"right\">" . trim($tmp[16]) . "</td>";}
    				echo "</tr>\n";
    				}$c++;$i++;
                }$u++;
            }
		echo "</table><br />";

        
		}
	}
    if ($aaa !== "all") {echo "<table align=\"right\" ><tr><td align=\"left\" width=\"50%\">";
        if ($page > 1) {echo "<a class=\"note1\" href=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;type=$type&amp;team=$team&amp;sort=$sort&amp;page=".($page-1); if (isset($active) && ($active != "") && ($active != "all")) {echo "&active=$active";} echo "\">previous $statscount <--</a>";}
        echo "</td><td width=\"50%\" align=\"right\">";
        if ($page * $statscount < $c) {
        echo "<a class=\"note1\" href=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;type=$type&amp;team=$team&amp;sort=$sort&amp;page=".($page+1); if (isset($active) && ($active != "") && ($active != "all")) {echo "&active=$active";} echo "\">--> next $statscount</a><br />";}
        echo "</td></tr></table>";
    }
}       

}
?>
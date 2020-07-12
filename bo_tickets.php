<?
function parseteamslist_bo() {global $game, $date, $manager, $current_season;
	
	$c = 0;
	echo "<table align=\"center\">";
	echo "<tr><td><span class=\"note\">bets on game: </span></td><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"jquery.php?id=bo_tickets.php&amp;manager=all&amp;date=$date&amp;game=all\">all games&nbsp;&nbsp;</option>\n";
    $po_file = "data/schedule/playoff".$current_season.".txt";
    $reg_file = "data/schedule/schedule".$current_season.".txt";
    $files = array($reg_file, $po_file);
    foreach ($files as $file) {
        if (file_exists($file)) {
            $f = fopen($file,"r");
            $tmp_date = explode("-", $date);
            while(!feof($f)) {
        		$tmp = explode("|",fgets($f,2000));
        		if (trim($tmp[0]) != "") {
                    if(($tmp[5] == $tmp_date[2]) && ($tmp[6] == $tmp_date[1]) && ($tmp[7] == $tmp_date[0])) {
            			if ($game == trim($tmp[14])) {echo "<option SELECTED value=\"jquery.php?id=bo_tickets.php&amp;manager=all&amp;date=$date&amp;game=".trim($tmp[14])."\">".strtoupper(trim($tmp[8]))." - ".strtoupper(trim($tmp[9]))."</option>";}
            			else {echo "<option value=\"jquery.php?id=bo_tickets.php&amp;manager=all&amp;date=$date&amp;game=".trim($tmp[14])."\">".strtoupper(trim($tmp[8]))." - ".strtoupper(trim($tmp[9]))."</option>";}
            			$c++;
                    }
        		}
        	}
        	fclose($f);
	    }
    }
    
    echo "</tr></table><br />";
}
?>

<?php

if($include_check == "bXnqwa") {
    
        if(!isset($date)) {$date = "all";}
        if(!isset($team)) {$team = "all";}
        if(!isset($manager)) {$manager = "all";}
        if(!isset($s)) {$s = $current_season;} 
        
        $po_file = "data/schedule/playoff".$s.".txt";
        $reg_file = "data/schedule/schedule".$s.".txt";
        $files = array($po_file, $reg_file);
        $upload_dir = "data/betting/".$s."/";
        $total_file = "rounds.txt";
    
        if(file_exists($upload_dir.$total_file)) {
            $f2 = fopen($upload_dir.$total_file, "r");
            while (!feof($f2)) {
                $tmp_2 = explode("|",fgets($f2, 2000));
                if($tmp_2[0] !="") {
                     
                    $tmp_hlp = $tmp_2[0];
                    $tmp_round = explode("_", $tmp_hlp);
                    $round_date = $tmp_round[0];
                    if($date !="all") {if ($date == $round_date) {$dates[] = $round_date;}} else {$dates[] = $round_date;}
                }
            }
            
        arsort($dates);
        
        //$count=count($dates);echo $count;
        //if($count == 1) {echo "<table class=\"sortable\" width=\"95%\" align=\"center\"><tr><th>date</th><th align=\"center\">home</th><th align=\"center\">away</th><th align=\"center\">bet</th><th align=\"center\">result</th><th align=\"center\">win</th></tr>";}
        if($manager != "all") {
            echo "<table class=\"sortable\" width=\"95%\" align=\"center\"><tr><th width=\"12%\" align=\"center\">date</th><th align=\"center\" width=\"25%\">home</th><th align=\"center\" width=\"25%\">away</th><th align=\"center\">bet</th><th align=\"center\" >result</th><th align=\"center\">win</th><th></th><th aliign=\"center\">points</th></tr>";
            
            $wins = 0;$z = 1;
            $numb = 0;
            $points_total = 0;
            foreach ($dates as $round_date) {
                
                $file = $round_date."_all.txt";
                if(file_exists($upload_dir.$file)) {
                $f3 = fopen($upload_dir.$file, "r");
                
                            
                //if($date !=="all") {$f3 = fopen($upload_dir.$date."_all.txt", "r");}
                while (!feof($f3)) {
                $tmp_3 = explode("|",fgets($f3, 2000));
                $mydate = $tmp_3[1];
    			$tmp_mydate = explode("_",$mydate);
                    if($tmp_3[0] !="") {
                        if((strtolower($tmp_3[0]) == strtolower($manager)) && (($tmp_3[5] != "?") || ($tmp_3[6] != "?"))) {
                            foreach ($files as $file) {
                                if(file_exists($file)) {
                                    $f5 = fopen($file, "r");
                                    while (!feof($f5)) {
                                        $tmp_5 = explode("|",fgets($f5, 2000));
                                        if($tmp_5[0] !="") {
											//$tmpdate = $tmp_5[7]."-".$tmp_5[6]."-".$tmp_5[6];
											
											if(($tmp_5[14] == $tmp_3[2]) && ($tmp_5[13] == $tmp_3[8])) {
                                                if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
                                                echo "<td align=\"right\">$tmp_3[1]</td><td align=\"center\">$tmp_5[1]</td><td align=\"center\" >$tmp_5[2]</td><td align=\"center\">";
                                                if ($tmp_3[4] == $tmp_3[7]) {echo "<span class=\"textgreen\">$tmp_3[4]</span>";} else {echo "<span class=\"textred\">$tmp_3[4]</span>";}
                                                echo "</td><td align=\"center\" >";
                                                if($s == $current_season) {echo "<a class=\"text1\" target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_match_info.php&amp;match_id=$tmp_3[8]\">$tmp_3[5] : $tmp_3[6]</a>";} else {echo "$tmp_3[5] : $tmp_3[6]";}
                                                echo "</td><td align=\"center\">$tmp_3[7]</td><td align=\"center\">";
                                                if (($tmp_3[4] == $tmp_3[7]) && ($tmp_3[5] != $tmp_3[6])) {echo "<img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\">";$wins = $wins + 1;} elseif (($tmp_3[4] == $tmp_3[7]) && ($tmp_3[5] = $tmp_3[6])) {echo "<img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\"><img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\">";} else {echo "<img src=\"img/dialog-no.png\" alt=\"no\" title=\"wrong bet\" >";}
                                                echo "</td>";
                                                echo "<td align=\"center\"><b>$tmp_3[9]</b></td>";
                                                $points_total = $points_total + $tmp_3[9];
                                                echo "</tr>";$numb = $numb + 1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }//else {echo "<tr><td rowspan=\"6\">no bets by manager $manager for $tmp_3[1]</td></tr>";}
                        } 
                    } 
                }
            }
            echo "<tr class=\"sum\"><td colspan=\"3\"></td><td colspan=\"5\" align=\"center\">$points_total points / $wins wins / $numb tickets</td></tr>";
            echo "</table><br />";
            //if($count ==1) {echo "</table>";}
        }
        if($manager == "all") {
            parseteamslist_bo();
            echo "<table class=\"sortable\" width=\"95%\" align=\"center\"><tr><th width=\"12%\" align=\"center\">manager</th><th align=\"center\" width=\"25%\">home</th><th align=\"center\" width=\"25%\">away</th><th align=\"center\">bet</th><th align=\"center\" >result</th><th align=\"center\">win</th><th></th><th aliign=\"center\">points</th></tr>";
            
            $wins = 0;$z = 1;
            $numb = 0;
            $points_total = 0;
            foreach ($dates as $round_date) {
                
                $file = $round_date."_all.txt";
                if(file_exists($upload_dir.$file)) {
                $f3 = fopen($upload_dir.$file, "r");
                
                            
                //if($date !=="all") {$f3 = fopen($upload_dir.$date."_all.txt", "r");}
                while (!feof($f3)) {
                $tmp_3 = explode("|",fgets($f3, 2000));
                $mydate = $tmp_3[1];
    			$tmp_mydate = explode("_",$mydate);
                    if($tmp_3[0] !="") {
                        if((($tmp_3[5] != "?") || ($tmp_3[6] != "?"))) {
                            if($game == "all") {
                                foreach ($files as $file) {
                                    if(file_exists($file)) {
                                        $f5 = fopen($file, "r");
                                        while (!feof($f5)) {
                                            $tmp_5 = explode("|",fgets($f5, 2000));
                                            if($tmp_5[0] !="") {
												//$tmpdate = $tmp_5[7]."-".$tmp_5[6]."-".$tmp_5[6];
												
                                                if(($tmp_5[14] == $tmp_3[2]) && ($tmp_5[13] == $tmp_3[8])) {
                                                    if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
                                                    echo "<td align=\"center\">$tmp_3[0]</td><td align=\"center\">$tmp_5[1]</td><td align=\"center\" >$tmp_5[2]</td><td align=\"center\">";
                                                    if ($tmp_3[4] == $tmp_3[7]) {echo "<span class=\"textgreen\">$tmp_3[4]</span>";} else {echo "<span class=\"textred\">$tmp_3[4]</span>";}
                                                    echo "</td><td align=\"center\" >";
                                                    if($s == $current_season) {echo "<a class=\"text1\" target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_match_info.php&amp;match_id=$tmp_3[8]\">$tmp_3[5] : $tmp_3[6]</a>";} else {echo "$tmp_3[5] : $tmp_3[6]";}
                                                    echo "</td><td align=\"center\">$tmp_3[7]</td><td align=\"center\">";
                                                    if (($tmp_3[4] == $tmp_3[7]) && ($tmp_3[5] != $tmp_3[6])) {echo "<img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\">";$wins = $wins + 1;} elseif (($tmp_3[4] == $tmp_3[7]) && ($tmp_3[5] = $tmp_3[6])) {echo "<img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\"><img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\">";} else {echo "<img src=\"img/dialog-no.png\" alt=\"no\" title=\"wrong bet\" >";}
                                                    echo "</td>";
                                                    echo "<td align=\"center\"><b>$tmp_3[9]</b></td>";
                                                    $points_total = $points_total + $tmp_3[9];
                                                    echo "</tr>";$numb = $numb + 1;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            if($game != "all") {
                                foreach ($files as $file) {
                                    if(file_exists($file)) {
                                        $f5 = fopen($file, "r");
                                        while (!feof($f5)) {
                                            $tmp_5 = explode("|",fgets($f5, 2000));
                                            if($tmp_5[0] !="") {
                                                if(($tmp_5[14] == $tmp_3[2]) && ($game == $tmp_3[2])) {
                                                    if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
                                                    echo "<td align=\"center\">$tmp_3[0]</td><td align=\"center\">$tmp_5[1]</td><td align=\"center\">$tmp_5[2]</td><td align=\"center\" width=\"10%\">";
                                                    if ($tmp_3[4] == $tmp_3[7]) {echo "<span class=\"textgreen\">$tmp_3[4]</span>";} else {echo "<span class=\"textred\">$tmp_3[4]</span>";}
                                                    echo "</td><td align=\"center\" >";
                                                    if($s == $current_season) {echo "<a class=\"text1\" target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_match_info.php&amp;match_id=$tmp_3[8]\">$tmp_3[5] : $tmp_3[6]</a>";} else {echo "$tmp_3[5] : $tmp_3[6]";}
                                                    echo "</td><td align=\"center\">$tmp_3[7]</td><td align=\"center\">";
                                                    if (($tmp_3[4] == $tmp_3[7]) && ($tmp_3[5] != $tmp_3[6])) {echo "<img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\">";$wins = $wins + 1;} elseif (($tmp_3[4] == $tmp_3[7]) && ($tmp_3[5] = $tmp_3[6])) {echo "<img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\"><img src=\"img/dialog-ok.png\" alt=\"ok\" title=\"correct bet\">";} else {echo "<img src=\"img/dialog-no.png\" alt=\"no\" title=\"wrong bet\" >";}
                                                    echo "</td>";
                                                    echo "<td align=\"center\"><b>$tmp_3[9]</b></td>";
                                                    $points_total = $points_total + $tmp_3[9];
                                                    echo "</tr>";$numb = $numb + 1;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } 
                    } 
                }
            }
            echo "</table><br />";
            //if($count ==1) {echo "</table>";}
        }
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
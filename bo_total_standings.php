<?php

function parse_bo_total($s)
{
    global $current_season;
    if (!isset($s)) {
        $s = $current_season;
    }
    //$s = 20;
    $upload_dir = "data/betting/" . $s . "/";
    $total_file = "betting.txt";


    if (file_exists($upload_dir . $total_file)) {
        $f = fopen($upload_dir . $total_file, "r");
        while (!feof($f)) {
            $tmp_hlp = explode("|", fgets($f, 2000));
            if (trim($tmp_hlp[0]) != "") {
                $points_total = $tmp_hlp[1] + $tmp_hlp[3] + $tmp_hlp[4]; 
                $srt1 = ($points_total + 5000)*10;
                $srt2 = 10000 - $tmp_hlp[2] + 1000;
                $sort = $srt1 . $srt2 . "!!" . $tmp_hlp[0] . "|" . $tmp_hlp[1] . "|" . $tmp_hlp[2] . "|" . $tmp_hlp[3] . "|" . $tmp_hlp[4] . "|";
                //echo $sort."<br />";
                $sorts[] = $sort;
            }
            $z++;
        }
        fclose($f);

        arsort($sorts);
        $u = 1;
        $z = 1;
        echo "<center><b>Total standings season $s</b></center><br/>";
        echo "<table align=\"center\" class=\"sortable\" width=\"430px\">";
        echo "<tr><th>rk</th><th>manager</th><th>&nbsp;</th><th align=\"right\">bets</th><th align=\"right\" title=\"correct winner\">wins</th><th align=\"right\" title=\"correct tie\">ties</th><th align=\"right\" title=\"incorrect bet\">loss</th><th align=\"right\" width=\"15%\">points</th><th align=\"center\" title=\"points / bets\" width=\"15%\">%</th></tr>";
        foreach ($sorts as $sort) {
            $tmp_1 = explode("!!", $sort);
            $tmp = explode("|", $tmp_1[1]);
            if (trim($tmp[0]) != "") {
                if ($z == 2) {
                    echo "<tr>";
                    $z = 1;
                }
                else {
                    echo "<tr class=\"even\">";
                    $z++;
                }
                echo "<td width=\"5%\" align=\"right\">$u.</td>";
                echo "<td width=\"30%\"><a href=\"sc.php?id=manager_stats.php&amp;manager=$tmp[0]\" class=\"text1\">$tmp[0]</a></td>";
                echo "<td width=\"10px\" align=\"right\"><a rel=\"shadowbox;width=800;height=600;title=Tickets of $tmp[0]\" href=\"jquery.php?id=bo_tickets.php&amp;s=$s&amp;manager=" .
                    strtolower($tmp[0]) . "\" class=\"text1\"><img width=\"10px\" alt=\"detail\" title=\"tickets detail\" src=\"img/zoom.png\"></a></td>";
                echo "<td align=\"right\">$tmp[2]</td>";
                echo "<td align=\"right\">$tmp[1]</td>";
                echo "<td align=\"right\">".($tmp[3]/2)."</td>";
                echo "<td align=\"right\">".($tmp[4]*-2)."</td>";
                $points_total_srt = $tmp[1] + $tmp[3] + $tmp[4];
                echo "<td align=\"right\">". number_format($points_total_srt,1) .
                    "</td>";
                echo "<td align=\"right\">". number_format(($points_total_srt/$tmp[2]*100),1).
                    "%</td>";
                echo "</tr>";
            }
            $u++;
        }
        echo "</table><br />";
    }
}


function parse_bo_last_round($s)
{
    global $current_season;
    if (!isset($s)) {
        $s = $current_season;
    }


    $upload_dir = "data/betting/" . $s . "/";
    $total_file = "rounds.txt";
    $c = 0;
    if (file_exists($upload_dir . $total_file)) {
        $f2 = fopen($upload_dir . $total_file, "r");
        while (!feof($f2) && ($c < 1)) {
            $tmp_2 = explode("|", fgets($f2, 2000));
            if ($tmp_2[0] != "") {
                $round_file = trim($tmp_2[0]);
            }
            $c++;
        }

        if (file_exists($upload_dir . $round_file)) {
            $f = fopen($upload_dir . $round_file, "r");
            while (!feof($f)) {
                $tmp_hlp = explode("|", fgets($f, 2000));
                if (trim($tmp_hlp[0]) != "") {
                    $tmp_date = explode("_", $round_file);
                    $date = $tmp_date[0];
                $points_total = $tmp_hlp[1] + $tmp_hlp[3] + $tmp_hlp[4]; 
                $srt1 = ($points_total + 5000)*10;
                $srt2 = 10000 - $tmp_hlp[2] + 1000;
                $sort = $srt1 . $srt2 . "!!" . $tmp_hlp[0] . "|" . $tmp_hlp[1] . "|" . $tmp_hlp[2] . "|" . $tmp_hlp[3] . "|" . $tmp_hlp[4] . "|". $date ."|";
                $sorts[] = $sort;
                }
                $z++;
            }

            arsort($sorts);
            $u = 1;
            $z = 1;
            echo "<center><b>Last round <a rel=\"shadowbox;width=800;height=600;title=All tickets from $date\"  href=\"jquery.php?id=bo_tickets.php&amp;manager=all&amp;date=$date&amp;game=all\"><img alt=\"detail\" title=\"tickets detail\" src=\"img/zoom.png\" width=\"10px\"></a></b></center><br/>";
            echo "<table align=\"center\" class=\"sortable\" width=\"430px\">";
            echo "<tr><th>rk</th><th>manager</th><th>&nbsp;</th><th align=\"right\">bets</th><th align=\"right\" title=\"correct winner\">wins</th><th align=\"right\" title=\"correct tie\">ties</th><th align=\"right\" title=\"incorrect bet\">loss</th><th align=\"right\" width=\"15%\">points</th><th align=\"center\" title=\"points / bets\" width=\"15%\">%</th></tr>";
            foreach ($sorts as $sort) {
                $tmp_1 = explode("!!", $sort);
                $tmp = explode("|", $tmp_1[1]);
                if (trim($tmp[0]) != "") {
                    if ($z == 2) {
                        echo "<tr>";
                        $z = 1;
                    }
                    else {
                        echo "<tr class=\"even\">";
                        $z++;
                    }
                    echo "<td width=\"5%\" align=\"right\">$u.</td>";
                    echo "<td width=\"30%\"><a href=\"sc.php?id=manager_stats.php&amp;manager=$tmp[0]\" class=\"text1\">$tmp[0]</a></td>";
                    echo "<td width=\"10px\" align=\"right\"><a rel=\"shadowbox;width=800;height=600;title=Tickets of $tmp[0]\" href=\"jquery.php?id=bo_tickets.php&amp;manager=" .
                        strtolower($tmp[0]) . "&date=$tmp[5]\" class=\"text1\"><img alt=\"detail\" title=\"tickets detail\" src=\"img/zoom.png\" width=\"10px\"></a></td>";
                echo "<td align=\"right\">$tmp[2]</td>";
                echo "<td align=\"right\">$tmp[1]</td>";
                echo "<td align=\"right\">".($tmp[3]/2)."</td>";
                echo "<td align=\"right\">".($tmp[4]*-2)."</td>";
                $points_total_srt = $tmp[1] + $tmp[3] + $tmp[4];
                echo "<td align=\"right\">". number_format($points_total_srt,1) .
                    "</td>";
                echo "<td align=\"right\">". number_format(($points_total_srt/$tmp[2]*100),1).
                    "%</td>";
                echo "</tr>";
                }
                $u++;
            }
            echo "</table><br />";
        }
    }
}

?>
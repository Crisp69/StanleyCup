<?php

function parse_bo_total_short ($s) {global $current_season;
    
    $total_file = "betting.txt";
    
    
    if(file_exists("data/betting/".$current_season."/".$total_file)) {$s = $current_season;} else {$s = $current_season - 1;}
    
    $upload_dir = "data/betting/".$s."/";
    

    if(file_exists($upload_dir.$total_file)) {
        $f = fopen($upload_dir.$total_file, "r");
        while (!feof($f)) {
            $tmp_hlp = explode("|", fgets($f, 2000));
            if(trim($tmp_hlp[0]) != "") {
                $points_total = $tmp_hlp[1] + $tmp_hlp[3] + $tmp_hlp[4]; 
                $srt1 = ($points_total + 5000)*1000;
                $srt2 = 10000 - $tmp_hlp[2] + 50000;
                $sort = $srt1 . $srt2 . "!!" . $tmp_hlp[0] . "|" . $tmp_hlp[1] . "|" . $tmp_hlp[2] . "|" . $tmp_hlp[3] . "|" . $tmp_hlp[4] . "|";
                $sorts[] = $sort;
                }$z++;
            } fclose($f);
        
    arsort($sorts);
    $u = 1;
    $z = 1;
    
    echo "<table align=\"center\" class=\"poll\" width=\"95%\">";
    echo "<tr><td class=\"date\"><b>#</b></td><td class=\"date\"><b>manager</b></td><td align=\"right\" class=\"date\"><b>points</b></td><td align=\"right\" class=\"date\"><b>bets</b></td></tr>";
    foreach ($sorts as $sort) {
        $tmp_1 = explode("!!", $sort);
            $tmp = explode("|", $tmp_1[1]);
            if(trim($tmp[0]) != "") {
                if($u<6) {
                    if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
                    echo "<td width=\"5%\" align=\"right\"><span class=\"date\">$u.</span></td>";
                    echo "<td width=\"50%\" align=\"left\"><span class=\"date\"><a rel=\"shadowbox;width=800;height=600;title=Tickets of $tmp[0]\" href=\"jquery.php?id=bo_tickets.php&amp;manager=$tmp[0]\" class=\"date\">$tmp[0]</a></span></td>";
                    echo "<td align=\"right\"><span class=\"date\">".number_format(($tmp[1] + $tmp[3] + $tmp[4]),1)."</a></td>";
                    echo "<td align=\"right\"><span class=\"date\">$tmp[2]</a></td>";
                    echo "</tr>";
                    }
                }$u++;
    }
    echo "<tr><td colspan=\"4\" align=\"right\">";
		echo "<a class=\"date\" href=\"sc.php?id=bo.php\"><b>bet now!</b></a>&nbsp;<br /></td></tr></table>\n";
    }
}
?>
<?php

function parseincome($s, $sort, $sort2, $hilight) {global $current_season;

    $income_file = "data/schedule/income".$s.".txt";
    if(file_exists($income_file)) {
        if (($sort == "") || !isset($sort)) {$sort = "inc";}
        echo "<a name=\"table1\"><br /><br /></a><center><b>Game Income Record";
        $query4 = array("inc" => "Income", "crd" =>"Crowd", "prc" => "Price");
                foreach ($query4 as $key => $value) {if ($sort == $key) {echo " - $value";}}
                echo "</b><br /><br /><span class=\"note1\"><b>sort table by -></b> ";
                foreach ($query4 as $key => $value) {echo "<a class=\"note1\" href=\"sc.php?id=stats_income.php&amp;s=$s&amp;sort=$key&amp;sort2=$sort2#table1\">".ucwords($value)."</a> | ";}
                echo "</span></center>";
        echo "<br /><table class=\"sort-table\" align=\"center\">\n";
        echo "<thead>
        	<tr>
            <td class=\"trhead\" align=\"center\" width=\"2%\" title=\"ranking\">rk</td>
        	<td colspan=\"1\" class=\"trhead\" align=\"center\" width=\"12%\">date</td><td colspan=\"5\" class=\"trhead\" align=\"center\" width=\"\">game</td><td colspan=\"1\" class=\"trhead\" align=\"center\" title=\"played @\">stadium</td>";
                foreach ($query4 as $key => $value) {echo "<td width=\"10%\" class=\"trhead\" align=\"right\" title=\"$value\"><a class=\"trhead\" href=\"sc.php?id=stats_income.php&s=$s&amp;sort=$key&amp;sort2=$sort2#table1\">".$value."</a></td>\n";}    
        	echo "</tr>
        	</thead>
        ";
        
        $z = 1;
        $fi = fopen($income_file, "r");
    	while (!feof($fi)) {
    		$tmp_base = explode("|", fgets($fi, 2000));
    		if (trim($tmp_base[0]) !== "") {
                $query4 = array("inc", "crd", "prc");
                if (!in_array($sort, 
                
                $query4)) {$sort = "inc";}
    			
                $srt3[inc] = $tmp_base[2]+10000000;
                $srt3[none] = $tmp_base[2]+10000000;                
                $srt3[crd] = $tmp_base[1]+10000;
                $srt3[prc] = $tmp_base[3]+10000;
                

                $sort_string3 = trim($srt3[$sort])."!!".$tmp_base[0]."|".$tmp_base[1]."|".$tmp_base[2]."|".$tmp_base[3]."|".$tmp_base[0]."|".$tmp_base[4]."|".$tmp_base[5]."|".$tmp_base[6]."|".$tmp_base[7]."|".$tmp_base[8]."|".$tmp_base[9]."|".$tmp_base[10]."|".$tmp_base[11]."|";
                //echo $sort_string3."<br>";
                $sort_strings3[] = $sort_string3;
            }
        }
        arsort($sort_strings3);
        $i = 1;
        $z = 1;
        foreach ($sort_strings3 as $sort_string3) {
            $tmp_hlp = explode("!!",$sort_string3);
            $tmp_stats = explode ("|", $tmp_hlp[1]);
            if(($tmp_stats[6] == $hilight) || ($tmp_stats[5] == $hilight)) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {
    		if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
            echo "<td align=\"right\">&nbsp;$i.</td>";
            echo "<td align=\"right\">$tmp_stats[9].$tmp_stats[10].$tmp_stats[11]</td>";
            echo "<td align=\"right\">";
            parseteamnamesearch($tmp_stats[5]);
            echo "</td>";
    		echo "<td> - </td>";
            echo "<td align=\"right\">";
            parseteamnamesearch($tmp_stats[6]);
            echo "</td>";
            echo "<td align=\"center\">&nbsp;";
            echo strtoupper($tmp_stats[12]);
            echo "</td>";
            echo "<td ";if ($sort == "inc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[2],"0", "", ",")."</td>";
            echo "<td ";if ($sort == "crd") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[1]</td>";
            echo "<td ";if ($sort == "prc") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[3]</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }
}


function parseincome_stats($s, $sort2, $sort, $hilight) {global $current_season;

    $income_file = "data/stats/income".$s.".txt";
    if(file_exists($income_file)) {
        if (($sort2 == "") || !isset($sort2)) {$sort2 = "t_inc";}
        echo "<a name=\"table2\"><br /><br /></a><center><b>Game Income Stats";
        $query4 = array("h_gm"=> "Home Games", "h_crd" =>"Home Crowd", "h_inc" => "Home Income", "avg_h_i"=>"Average Home Income", "t_crd" =>"Total Crowd", "t_inc" => "Total Income", "avg_t_i"=>"Average Total Income");
                foreach ($query4 as $key => $value) {if ($sort2 == $key) {echo " - $value";}}
                echo "</b><br /><br /><span class=\"note1\"><b>sort table by -></b> ";
                foreach ($query4 as $key => $value) {echo "<a class=\"note1\" href=\"sc.php?id=stats_income.php&amp;s=$s&amp;sort=$sort&amp;sort2=$key#table2\">".ucwords($value)."</a> | ";}
                echo "</span></center>";
        echo "<br /><table class=\"sort-table\" align=\"center\">\n";
        echo "<thead>
        	<tr>
            <td class=\"trhead\" align=\"center\" width=\"2%\" title=\"ranking\">rk</td>
        	<td colspan=\"2\" class=\"trhead\" align=\"center\" width=\"20%\" >team</td>";
                foreach ($query4 as $key => $value) {echo "<td width=\"11%\" class=\"trhead\" align=\"right\" title=\"$value\"><a class=\"trhead\" href=\"sc.php?id=stats_income.php&s=$s&amp;sort=$sort&amp;sort2=$key#table2\">".str_replace("Avg", "avg", ucwords(str_replace("_", " ", $key)))."</a></td>\n";}    
        	echo "</tr>
        	</thead>
        ";
        
        $z = 1;
        $fi = fopen($income_file, "r");
    	while (!feof($fi)) {
    		$tmp_base = explode("|", fgets($fi, 2000));
    		if (trim($tmp_base[0]) !== "") {
                $query4 = array("h_inc", "h_crd", "avg_h_i", "t_inc", "t_crd", "h_gm", "avg_t_i");
                if (!in_array($sort2,$query4)) {$sort2 = "t_inc";}
    			
                $total_inc = $tmp_base[1]+$tmp_base[4];
                $total_crd = $tmp_base[2]+$tmp_base[5];
                $total_gm = $tmp_base[3] + $tmp_base[6];
                $srt3[h_gm] = $tmp_base[3]+100; 
                $srt3[h_inc] = $tmp_base[1]+1000000000;
                $srt3[h_crd] = $tmp_base[2]+1000000000;                
                $srt3[t_inc] = $total_inc+1000000000;
                $srt3[t_crd] = $total_crd+1000000000;
                if($tmp_base[3]==0) {$avg_h_inc = 0;} else {$avg_h_inc = ($tmp_base[1]/$tmp_base[3]);}
                if(($tmp_base[3]+$tmp_base[6])==0) {$avg_t_inc = 0;} else {$avg_t_inc = (($tmp_base[1]+$tmp_base[4])/($tmp_base[3]+$tmp_base[6]));}
                $srt3[avg_h_i] = $avg_h_inc + 100000000;
                $srt3[avg_t_i] = $avg_t_inc + 100000000;

                $sort_string3 = trim($srt3[$sort2])."!!".$tmp_base[0]."|".$tmp_base[1]."|".$tmp_base[2]."|".$tmp_base[3]."|".$total_inc."|".$total_crd."|".$tmp_base[6]."|".$avg_h_inc."|".$avg_t_inc."|";
                //echo $sort_string3."<br>";
                $sort_strings3[] = $sort_string3;
            }
        }
        arsort($sort_strings3);
        $i = 1;
        $z = 1;
        foreach ($sort_strings3 as $sort_string3) {
            $tmp_hlp = explode("!!",$sort_string3);
            $tmp_stats = explode ("|", $tmp_hlp[1]);
            if(($tmp_stats[0] == $hilight)) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {
    		if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
            echo "<td align=\"right\">&nbsp;$i.</td>";
            echo "<td align=\"right\">";
            parseteamnamesearch($tmp_stats[0]);
            echo "</td>";
            echo "<td ";if ($sort2 == "h_gm") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[3],"0", "", ",")."</td>";
    		echo "<td ";if ($sort2 == "h_crd") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[2],"0", "", ",")."</td>";
            echo "<td ";if ($sort2 == "h_inc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(($tmp_stats[1]/1000000),"2", ".", ",")."M</td>";
            echo "<td ";if ($sort2 == "avg_h_i") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(($tmp_stats[7]/1000),"1", ".", ",")."t</td>";
            echo "<td ";if ($sort2 == "t_crd") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[5],"0", "", ",")."</td>";
            echo "<td ";if ($sort2 == "t_inc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(($tmp_stats[4]/1000000),"2", ".", ",")."M</td>";
            echo "<td ";if ($sort2 == "avg_t_i") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format(($tmp_stats[8]/1000),"1", ".", ",")."t</td>";
            
            echo "</tr>";
            $i++;
        }
        echo "</table><br />";
        echo "<span class=\"note\">* income is income from the game, income per team = income from game / 2<br />* home stats based on stadium where game was played, does not consider official <a class=\"note\" href=\"sc.php?id=schedule.php\">schedule</a></span><hr>";
        
    }
}

function parseseasonlist_income() {global $s, $current_season;
	$upload_dir = "data/default/";
	$n = "season.txt";

	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">&nbsp;choose season...</option>\n";

	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if (($tmp[0] == "01") || ($tmp[0] == "02") || ($tmp[0] == "03") || ($tmp[0] == "04") || ($tmp[0] == "05") || ($tmp[0] == "06") || ($tmp[0] == "07") || ($tmp[0] == "08") || ($tmp[0] == "09") || ($tmp[0] == "10") || ($tmp[0] == "11") || ($tmp[0] == "12") || ($tmp[0] == "13") || ($tmp[0] == "14") || ($tmp[0] == "15") || ($tmp[0] == "16") || ($tmp[0] == "17") || ($tmp[0] == "18") || ($tmp[0] == "19") || ($tmp[0] == "20") || ($tmp[0] == "21") || ($tmp[0] == "22")) {echo "";} else {
			echo "<option value=\"sc.php?id=stats_income.php&amp;s=".trim($tmp[0])."\">&nbsp;".trim($tmp[0]).". season </option>\n";}
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table><br />";
}


?>


<?


if($include_check == "bXnqwa") {
    echo "<b>: teams stats - Stanley Cup $s</b><br />";
    $g = "data/schedule/income".$current_season.".txt";
    if (file_exists($g)) {$stats_season = $current_season;} else {$stats_season = $current_season-1;}
    if ((!IsSet($s)) || $s == "") {$s = $stats_season;}	
    
    parseseasonlist_income();
    
    parseincome_stats($s, $sort2=$sort2, $sort=$sort, $hilight);
    parseincome($s, $sort=$sort, $sort2=$sort2, $hiligt = $hilight);
    

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
?>
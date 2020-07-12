<? 

function parsestats($s, $sort1, $sort2, $hilight) {global $current_season;

$stats_file = "data/stats/teams".$s.".txt";
if (file_exists($stats_file)) {

    echo "<b>: teams stats - Stanley Cup $s</b><br />"; 
    //echo "<span class=\"note\">(last update: ". date("d M Y h:i a", filemtime("$stats_file")).")</span><br />";
    echo "<a name=\"table_1\"><br /><br /></a><center><b>General Stats";
    $query1 = array("gd" => "Goals difference", "sf" =>"Shots forward", "sa" => "Shots against", "sd" => "Shots difference", "s_perc" => "Team shooting %", "g_perc" => "Saves %", "gaa" => "Goals against average", "so" => "Shot-outs", "usg" => "Unstoppable goals", "uag" => "Unassisted goals", "fow" => "Face-offs won");
    
            foreach ($query1 as $key => $value) {if ($sort1 == $key) {echo " - $value";}}
            echo "</b><br /><br /><span class=\"note1\"><b>sort table by -></b> ";
            foreach ($query1 as $key => $value) {echo "<a class=\"note1\" href=\"sc.php?id=teams_stats.php&amp;s=$s&amp;sort1=$key&amp;sort2=$sort2#table_1\">".ucwords($value)."</a> | ";}
            echo "</span></center>";
    //echo "<script type=\"text/javascript\" src=\"sortabletable.js\"></script>\n";
    echo "<br /><table class=\"sort-table\" align=\"center\">\n";
    echo "<thead>
    	<tr>
    	<td class=\"trhead\" align=\"center\" width=\"2%\" title=\"ranking\">rk</td>
        <td colspan=\"2\" class=\"trhead\" align=\"center\" width=\"21%\"><a class=\"trhead\" href=\"sc.php?id=teams_stats.php&s=$s&hilight=$hilight&sort1=team&sort2=$sort2#table_1\">team</a></td>";
        foreach ($query1 as $key => $value) {echo "<td class=\"trhead\" align=\"right\" width=\"7%\" title=\"$value\"><a class=\"trhead\" href=\"sc.php?id=teams_stats.php&amp;s=$s&sort1=$key&amp;sort2=$sort2#table_1\">".strtoupper(str_replace("_perc", "%", $key))."</a></td>\n";}    
    	echo "</tr>
    	</thead>\n";
    
    $f = fopen($stats_file, "r");
    	while (!feof($f)) {
    		$tmp_base = explode("|", fgets($f, 2000));
    		if (trim($tmp_base[0]) !== "") {
                $query1a = array("gd", "sf", "sa", "sd", "s_perc", "g_perc", "gaa", "so", "usg", "uag", "fow", "team");
                if (!in_array($sort1, $query1a)) {$sort1 = "none";}
    			if (($sort1 == "") || !isset($sort1)) {$sort1 = "none";}
                $srt[none] = $tmp_base[0];
                $srt[team] = $tmp_base[0];
                $srt[gd] = $tmp_base[1] + 2000;
                $srt[sf] = $tmp_base[3] + 2000;
                $srt[sa] = $tmp_base[4] + 2000;
                $srt[sd] = $tmp_base[5] + 2000;
                $srt[s_perc] = $tmp_base[6] + 2000;
                $srt[g_perc] = $tmp_base[7] + 2000;
                $srt[gaa] = $tmp_base[8] + 2000;
                $srt[so] = $tmp_base[2] + 2000;
                $srt[usg] = $tmp_base[10] + 2000;
                $srt[uag] = $tmp_base[11] + 2000;
                $srt[fow] = $tmp_base[9] + 2000;
                
                $sort_string = trim($srt[$sort1])."!!".$tmp_base[0]."|".$tmp_base[1]."|".$tmp_base[2]."|".$tmp_base[3]."|".$tmp_base[4]."|".$tmp_base[5]."|".$tmp_base[6]."|".$tmp_base[7]."|".$tmp_base[8]."|".$tmp_base[9]."|".$tmp_base[10]."|".$tmp_base[11];
                $sort_strings[] = $sort_string;
                }
            }
       
       if (($sort1 == "none") || ($sort1 == "sa") || ($sort1 == "gaa") || ($sort1 == "team")) {sort($sort_strings);} else {arsort($sort_strings);}
       $i = 1;
       $z = 1;
       foreach ($sort_strings as $sort_string) {
            $tmp_hlp = explode("!!",$sort_string);
            $tmp_stats = explode ("|", $tmp_hlp[1]);
            $team_name = strtolower(($tmp_stats[0]));
            if($tmp_stats[0] == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {   
                if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
    			echo "<td align=\"right\">&nbsp;$i.</td>";
                echo "<td width=\"4%\">";
    			parseteamnamesearch($team_name);
    			echo "</td>";
    			echo "<td ";if ($sort1 == "gd") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[1]</td>";
    			echo "<td ";if ($sort1 == "sf") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[3]</td>";
    			echo "<td ";if ($sort1 == "sa") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[4]</td>";
    			echo "<td ";if ($sort1 == "sd") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[5]</td>";
    			echo "<td ";if ($sort1 == "s_perc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[6],2)."</td>";
    			echo "<td ";if ($sort1 == "g_perc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[7],2)."</td>";
    			echo "<td ";if ($sort1 == "gaa") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[8],2)."</td>";
    			echo "<td ";if ($sort1 == "so") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[2]</td>";
    			echo "<td ";if ($sort1 == "usg") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[10]</td>";
    			echo "<td ";if ($sort1 == "uag") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[11]</td>";
    			echo "<td ";if ($sort1 == "fow") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[9],2)."</td>";
    			echo "</tr>\n";$i++;
        }			
    	echo "</table>";
    
    echo "<a name=\"table_2\"><br /><br /></a><center><b>Special Teams Stats";
    $query2 = array("sh" => "Times shorthanded", "ppga" =>"Powerplay Goals Against", "pk_perc" => "Penalty Kill efficiency", "shg" => "Shorthanded Goals", "pp" => "Times powerplay", "ppg" => "Powerplay goals", "pp_perc" => "Powerplay efficiency", "shga" => "Shorthanded Goals Against");
    
            foreach ($query2 as $key => $value) {if ($sort2 == $key) {echo " - $value";}}
            echo "</b><br /><br /><span class=\"note1\"><b>sort table by -></b> ";
            foreach ($query2 as $key => $value) {echo "<a class=\"note1\" href=\"sc.php?id=teams_stats.php&amp;s=$s&amp;sort1=$sort1&amp;sort2=$key#table_2\">".ucwords($value)."</a> | ";}
            echo "</span></center>";
    echo "<br /><table class=\"sort-table\" align=\"center\">\n";
    echo "<thead>
    	<tr>
        <td class=\"trhead\" align=\"center\" width=\"2%\" title=\"ranking\">rk</td>
    	<td colspan=\"2\" class=\"trhead\" align=\"center\" width=\"34%\"><a class=\"trhead\" href=\"sc.php?id=teams_stats.php&amp;s=$s&amp;sort1=$sort1&amp;sort2=team#table_2\">team</a></td>";
            foreach ($query2 as $key => $value) {echo "<td class=\"trhead\" align=\"right\" width=\"8%\" title=\"$value\"><a class=\"trhead\" href=\"sc.php?id=teams_stats.php&amp;s=$s&amp;sort1=$sort1&amp;sort2=$key#table_2\">".strtoupper(str_replace("_perc", "%", $key))."</a></td>\n";}    
    	echo "</tr>
    	</thead>
    
    ";
    $z = 1;
    $stats_file = "data/stats/teams".$s.".txt";
    $f = fopen($stats_file, "r");
    	while (!feof($f)) {
    		$tmp_base = explode("|", fgets($f, 2000));
    		if (trim($tmp_base[0]) !== "") {
                $query3 = array("sh", "ppga", "pk_perc", "shg", "pp", "ppg", "pp_perc", "shga", "team");
                if (!in_array($sort2, $query3)) {$sort2 = "none";}
    			if (($sort2 == "") || !isset($sort2)) {$sort2 = "none";}
                $srt2[team] = $tmp_base[0];
                $srt2[none] = $tmp_base[0];
                $srt2[sh] = $tmp_base[18] + 2000;
                $srt2[ppga] = $tmp_base[17] + 2000;
                $srt2[pk_perc] = $tmp_base[19] + 2000;
                $srt2[shg] = $tmp_base[12] + 2000;
                $srt2[pp] = $tmp_base[15] + 2000;
                $srt2[ppg] = $tmp_base[14] + 2000;
                $srt2[pp_perc] = $tmp_base[16] + 2000;
                $srt2[shga] = $tmp_base[13] + 2000;
                $sort_string2 = trim($srt2[$sort2])."!!".$tmp_base[0]."|".$tmp_base[1]."|".$tmp_base[2]."|".$tmp_base[3]."|".$tmp_base[4]."|".$tmp_base[5]."|".$tmp_base[6]."|".$tmp_base[7]."|".$tmp_base[8]."|".$tmp_base[9]."|".$tmp_base[10]."|".$tmp_base[11]."|".$tmp_base[12]."|".$tmp_base[13]."|".$tmp_base[14]."|".$tmp_base[15]."|".$tmp_base[16]."|".$tmp_base[17]."|".$tmp_base[18]."|".$tmp_base[19];
                $sort_strings2[] = $sort_string2;
                }
            }
       
       if (($sort2 == "none") || ($sort2 == "sh") || ($sort2 == "ppga") || ($sort2 == "shga") || ($sort2 == "team")) {sort($sort_strings2);} else {arsort($sort_strings2);}
       $i = 1;
       $z = 1;
       foreach ($sort_strings2 as $sort_string2) {
            $tmp_hlp = explode("!!",$sort_string2);
            $tmp_stats = explode ("|", $tmp_hlp[1]); 
                $team_name = strtolower(($tmp_stats[0]));
                if($tmp_stats[0] == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {
    			if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
    			echo "<td align=\"right\">&nbsp;$i.</td>";
                echo "<td width=\"4%\">";
    			parseteamnamesearch($team_name);
    			echo "</td>";
    			echo "<td ";if ($sort2 == "sh") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[18]</td>";
    			echo "<td ";if ($sort2 == "ppga") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[17]</td>";
    			echo "<td ";if ($sort2 == "pk_perc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[19],2)."</td>";
    			echo "<td ";if ($sort2 == "shg") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[12]</td>";
    			echo "<td ";if ($sort2 == "pp") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[15]</td>";
    			echo "<td ";if ($sort2 == "ppg") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[14]</td>";
    			echo "<td ";if ($sort2 == "pp_perc") {echo "class=\"sort\" ";} echo "align=\"right\">".number_format($tmp_stats[16],2)."</td>";
    			echo "<td ";if ($sort2 == "shga") {echo "class=\"sort\" ";} echo "align=\"right\">$tmp_stats[13]</td>";
    			echo "</tr>";$i++;
    	}
    	echo "</table>";

    echo "<br /><br /><hr><span class=\"note\">";
    foreach ($query1 as $key => $value) {echo strtoupper(str_replace("_perc", "%", $key))." = ".ucwords($value)."<br />\n";}
    foreach ($query2 as $key => $value) {echo strtoupper(str_replace("_perc", "%", $key))." = ".ucwords($value)."<br />\n";}
    
    
}
else {
	echo "<br /><br /><center>no stats available for season $s</center>\n";}
}

function parseseasonlist_teamstats() {global $s, $current_season;
	$upload_dir = "data/default/";
	$n = "season.txt";

	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">&nbsp;choose season...</option>\n";

	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if (($tmp[0] == "01") || ($tmp[0] == "02") || ($tmp[0] == "03") || ($tmp[0] == "04") || ($tmp[0] == "05") || ($tmp[0] == "06") || ($tmp[0] == "07") || ($tmp[0] == "08") || ($tmp[0] == "09") || ($tmp[0] == "10") || ($tmp[0] == "11") || ($tmp[0] == "12") || ($tmp[0] == "13") || ($tmp[0] == "14") || ($tmp[0] == "15") || ($tmp[0] == "16")) {echo "";} else {
			echo "<option value=\"sc.php?id=teams_stats.php&amp;s=".trim($tmp[0])."\">&nbsp;".trim($tmp[0]).". season </option>\n";}
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table><br />";
}



if($include_check == "bXnqwa") {

    $g = "data/stats/teams".$current_season.".txt";
    if (file_exists($g)) {$stats_season = $current_season;} else {$stats_season = $current_season-1;}
    if ((!IsSet($s)) || $s == "") {$s = $stats_season;}	
    
    parseseasonlist_teamstats();
    
    if (($sort1 == "") || !isset($sort1)) {$sort1 = "none";}
    if (($sort2 == "") || !isset($sort2)) {$sort2 = "none";}
    parsestats($s, $sort1 = $sort1, $sort2 = $sort2, $hiligt = $hilight);
    
    /*This is the old order of columns:
    Name GD SF SA SD S% G% GAA SO USG UAG SHG SHGA PPG PP% PPGA PK% FOW% PP PEN
    
    new order:
    Name GD SO SF SA SD S% G% GAA FOW% USG UAG SHG SHGA PPG PP PP% PPGA PEN PK%*/
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
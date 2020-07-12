<?php

function parseteamsearch($team1, $team2)
{
	$f = fopen("data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {

			if ($team1 == trim($tmp[1])) {
				$team_name1 = "<a class=\"tblhd\" href=\"sc.php?id=teams.php&team=$tmp[1]\">" . strtoupper($tmp[2])."</a>";
				}
            elseif ($team1 == "atl") {
                $team_name1 = "<a class=\"tblhd\" href=\"sc.php?id=teams.php&team=atl\">ATLANTA THRASHERS</a>";
            }
			if ($team2 == trim($tmp[1])) {
				$team_name2 = "<a class=\"tblhd\" href=\"sc.php?id=teams.php&team=$tmp[1]\">" . strtoupper($tmp[2])."</a>";
				}
            elseif ($team2 == "atl") {
                $team_name2 = "<a class=\"tblhd\" href=\"sc.php?id=teams.php&team=atl\">ATLANTA THRASHERS</a>";
            }
			
		}
	}fclose($f);
	echo "$team_name1</th><th width=\"9%\" align=\"center\">vs.</th><th colspan=\"2\" align=\"left\" width=\"45%\" >$team_name2";
}
function parseteamname1($team1)
{
	if($team1 == "atl") {echo "Atlanta Thrashers";} else {
	   $f = fopen("data/default/teams_list.txt", "r");
	   while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team1 == trim($tmp[1])) {
				echo "$tmp[2]";
				}
    		}
	   }fclose($f);
    }
}
function parseteamname2($team2)
{
    if($team2 == "atl") {echo "Atlanta Thrashers";} else {
        $f = fopen("data/default/teams_list.txt", "r");
        while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) != "") {
			if ($team2 == trim($tmp[1])) {
				echo "$tmp[2]";
				}
		  }
	   }    
    }
	
}


function parseteamscompare($team1, $team2,$type) {global $team_name1, $team_name2;
	$upload_dir = "data/schedule/";
	if ($type == "reg") {$n1 = "schedule";} elseif ($type == "po") {$n1 = "playoff";}
	if ($type == "po") {
		$t = "Playoff season";
	} else {
		$t = "Regular season";
	}
	$n2 = ".txt";
	$x = File ("data/default/season.txt");
	$xx = count ($x)-1;
	$z = 1;
	$c = 0;
	echo "<table class=\"overview\" align=\"center\">\n<tr><th title=\"season\" width=\"11%\">$t</th><th colspan=\"2\" width=\"35%\" align=\"right\">";
	parseteamsearch($team1, $team2);
	echo "</th></tr>";$p = 0; $q = 0;
	for ($i = 0; $i < $xx; $i++) {
		$tmp1 = explode("|",$x[$i]);
		if (trim($tmp1[0]) != "") {
		$f2 = $n1.$tmp1[0].$n2; 
        if(($i<27) && ($team1 == "wpg")) {$team1 = "atl";}
        if(($i<27) && ($team2 == "wpg")) {$team2 = "atl";}
		if (file_exists($upload_dir.$f2)) {
			$f = fopen($upload_dir.$f2,"r");
			while(!feof($f)) {
				$tmp = explode("|",fgets($f,2000));
				if (trim($tmp[0]) != "") {
					if ((($team1 == $tmp[8]) || ($team1 == $tmp[9])) && (($team2 == $tmp[8]) || ($team2 == $tmp[9]))) {
						if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
							echo "<td colspan=\"2\" align=\"left\">&nbsp;<a class=\"text1\" href=\"sc.php?id=schedule.php&s=$tmp1[0]&type=$type\">$tmp1[0]. ";
							if ($tmp[0] == "Conference Quarterfinals") {echo "Conf 1/4F";}
							if ($tmp[0] == "Conference Semifinals") {echo "Conf 1/2F";}
							if ($tmp[0] == "Conference Finals") {echo "Conf Finals";}
							if ($tmp[0] == "Stanley Cup Finals") {echo "SC Finals";}
							echo "</a></td>";
							if ($team1 == $tmp[8]) {echo "<td width=\"25%\" align=\"right\"><a class=\"text1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[3]\">";
							parseteamname1($team1);
                            echo "</a></td><td align=\"center\" width=\"9%\">";
                            if($tmp[10] > $tmp[11]) {echo "<span class=\"textgreen\">$tmp[10] : $tmp[11]</span>";} 
                            elseif($tmp[10] < $tmp[11]) {echo "<span class=\"textred\">$tmp[10] : $tmp[11]</span>";}
                            else {echo "$tmp[10] : $tmp[11]";}
							
                            echo "</td><td align=\"left\"><a class=\"text1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[4]\">";
							parseteamname2($team2);
							echo "</a></td><td width=\"9%\"><a class=\"note\" target=\"_blank\" href=\"http://orico.wz.cz/ha-tools/en?team=$tmp[3]&c=team-comp&team_2=$tmp[4]\">ha-tools</a>&nbsp;</td></tr>"; if($tmp[10] > $tmp[11]) {$win1[$c]=1;} if($tmp[11] > $tmp[10]) {$loss1[$c]=1;} if(($tmp[10] !== "?") && ($tmp[10] == $tmp[11])) {$tie1[$c]=1;} $p = $p + $tmp[10]; $q = $q + $tmp[11];}
							else {echo "<td align=\"right\" width=\"25%\"><a class=\"text1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[4]\">";
							parseteamname1($team1);echo "</a></td><td align=\"center\" width=\"9%\">";
                            if($tmp[11] > $tmp[10]) {echo "<span class=\"textgreen\">$tmp[11] : $tmp[10]</span>";} 
                            elseif($tmp[11] < $tmp[10]) {echo "<span class=\"textred\">$tmp[11] : $tmp[10]</span>";}
                            else {echo "$tmp[10] : $tmp[11]";}
							
                            echo "</td><td align=\"left\"><a class=\"text1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$tmp[3]\">";
							parseteamname2($team2);
							echo "</a></td><td width=\"9%\"><a class=\"note\" target=\"_blank\" href=\"http://orico.wz.cz/ha-tools/en?team=$tmp[4]&c=team-comp&team_2=$tmp[3]\">ha-tools</a>&nbsp;</td></tr>\n";if($tmp[11] > $tmp[10]) {$win1[$c]=1;} if($tmp[10] > $tmp[11]) {$loss1[$c]=1;} if(($tmp[10] !== "?") && ($tmp[10] == $tmp[11])) {$tie1[$c]=1;} $p = $p + $tmp[11]; $q = $q + $tmp[10]; } 
					} $c++;
				} 
			}fclose($f);
		} 
	}
	}
	$win1 = count($win1); $loss1 = count($loss1);$tie1 = count($tie1); 
	echo "<tr class=\"sum\"><td align=\"center\" colspan=\"6\">";
	if (($win1 + $loss1 + $tie1) == 0) {echo "no games played";}
	else {
	echo "<a class=\"text1\" href=\"sc.php?id=teams.php&team=$team1\">";
	parseteamname1($team1);
	echo "</a>";
	echo " vs. ";
	echo "<a class=\"text1\" href=\"sc.php?id=teams.php&team=$team2\">";
	parseteamname2($team2);
	echo "</a>: $win1 wins - $loss1 losses - $tie1 ties ($p:$q)";}
	echo "</td></tr>\n";
	echo "</table><br />";
}


function parseteamscomparison($team1, $team2) {global $current_season;
    $upload_file1 = "data/teams/teams_details.txt";
    echo "<table class=\"sort-table\" width=\"95%\" align=\"center\">";
    if(File_exists($upload_file1)) {
        echo "<tr><th colspan=\"2\" align=\"right\">";parseteamsearch($team1, $team2); echo "</th></tr>";
        $f = fopen($upload_file1,"r");
    	while(!feof($f)) {
    		$tmp_str = explode("|",fgets($f,2000));
    		if (trim($tmp_str[0]) !== "") {
    		  if($team1 == $tmp_str[0]) {
    		      $goa[$team1] = $tmp_str[2];
                  $def[$team1] = $tmp_str[3];
                  $off[$team1] = $tmp_str[4];
                  $sho[$team1] = $tmp_str[5];
                  $pas[$team1] = $tmp_str[6];
                  $ai22[$team1] = $tmp_str[12];
                  $ag22[$team1] = $tmp_str[13];
                  $ai17[$team1] = $tmp_str[14];
                  $ag17[$team1] = $tmp_str[15];
                  $kpt[$team1] = $tmp_str[9];
    		  }
              if($team2 == $tmp_str[0]) {
    		      $goa[$team2] = $tmp_str[2];
                  $def[$team2] = $tmp_str[3];
                  $off[$team2] = $tmp_str[4];
                  $sho[$team2] = $tmp_str[5];
                  $pas[$team2] = $tmp_str[6];
                  $ai22[$team2] = $tmp_str[12];
                  $ag22[$team2] = $tmp_str[13];
                  $ai17[$team2] = $tmp_str[14];
                  $ag17[$team2] = $tmp_str[15];
                  $kpt[$team2] = $tmp_str[9];
    		  }
              
  		    }
        }fclose($f);
        
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Team captain</b></td><td width=\"21%\" align=\"center\"><a rel=\"shadowbox;&width=750;height=600;title=$kpt[$team1] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name=";$name = $kpt[$team1]; parseplayer_link($name); echo "\">$kpt[$team1]</a></td><td align=\"center\">-</td><td width=\"25%\" align=\"center\"><a rel=\"shadowbox;&width=750;height=600;title=$kpt[$team2] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name=";$name = $kpt[$team2]; parseplayer_link($name); echo "\">$kpt[$team2]</a></td><td align=\"center\">&nbsp;</td></tr>";
        echo "<tr class=\"hilitetr\"><td colspan=\"5\"><a class=\"hilite2\" href=\"sc.php?id=teams_addinfo.php\">teams strength</a></td></tr>";
        $goa[diff] = $goa[$team1] - $goa[$team2];
        if($goa[diff] >= 0) {$goa[diff] = "<span class=\"textgreen\">+$goa[diff]</span>";} else {$goa[diff] = "<span class=\"textred\">$goa[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Goalie strength</b></td><td width=\"21%\" align=\"center\">$goa[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$goa[$team2]</td><td align=\"center\">$goa[diff]</td></tr>";
        
        $def[diff] = $def[$team1] - $def[$team2];
        if($def[diff] >= 0) {$def[diff] = "<span class=\"textgreen\">+$def[diff]</span>";} else {$def[diff] = "<span class=\"textred\">$def[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Defense strength</b></td><td width=\"21%\" align=\"center\">$def[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$def[$team2]</td><td align=\"center\">$def[diff]</td></tr>";
                
        $off[diff] = $off[$team1] - $off[$team2];
        if($off[diff] >= 0) {$off[diff] = "<span class=\"textgreen\">+$off[diff]</span>";} else {$off[diff] = "<span class=\"textred\">$off[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Offense strength</b></td><td width=\"21%\" align=\"center\">$off[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$off[$team2]</td><td align=\"center\">$off[diff]</td></tr>";
        
        $sho[diff] = $sho[$team1] - $sho[$team2];
        if($sho[diff] >= 0) {$sho[diff] = "<span class=\"textgreen\">+$sho[diff]</span>";} else {$sho[diff] = "<span class=\"textred\">$sho[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Shooting strength</b></td><td width=\"21%\" align=\"center\">$sho[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$sho[$team2]</td><td align=\"center\">$sho[diff]</td></tr>";
        
        $pas[diff] = $pas[$team1] - $pas[$team2];
        if($pas[diff] >= 0) {$pas[diff] = "<span class=\"textgreen\">+$pas[diff]</span>";} else {$pas[diff] = "<span class=\"textred\">$pas[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Passing strength</b></td><td width=\"21%\" align=\"center\">$pas[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$pas[$team2]</td><td align=\"center\">$pas[diff]</td></tr>";
        
        $ai22[diff] = $ai22[$team1] - $ai22[$team2];
        if($ai22[diff] >= 0) {$ai22[diff] = "<span class=\"textgreen\">+$ai22[diff]</span>";} else {$ai22[diff] = "<span class=\"textred\">$ai22[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;AI 22 avg</b></td><td width=\"21%\" align=\"center\">".number_format($ai22[$team1],1)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($ai22[$team2],1)."</td><td align=\"center\">$ai22[diff]</td></tr>";
        
        $ag22[diff] = $ag22[$team1] - $ag22[$team2];
        if($ag22[diff] >= 0) {$ag22[diff] = "<span class=\"textred\">+$ag22[diff]</span>";} else {$ag22[diff] = "<span class=\"textgreen\">$ag22[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Age AI 22 avg</b></td><td width=\"21%\" align=\"center\">".number_format($ag22[$team1],1)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($ag22[$team2],1)."</td><td align=\"center\">$ag22[diff]</td></tr>";
        
        $ai17[diff] = $ai17[$team1] - $ai17[$team2];
        if($ai17[diff] >= 0) {$ai17[diff] = "<span class=\"textgreen\">+$ai17[diff]</span>";} else {$ai17[diff] = "<span class=\"textred\">$ai17[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;AI 17 avg</b></td><td width=\"21%\" align=\"center\">".number_format($ai17[$team1],1)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($ai17[$team2],1)."</td><td align=\"center\">$ai17[diff]</td></tr>";
        
        $ag17[diff] = $ag17[$team1] - $ag17[$team2];
        if($ag17[diff] >= 0) {$ag17[diff] = "<span class=\"textred\">+$ag17[diff]</span>";} else {$ag17[diff] = "<span class=\"textgreen\">$ag17[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Age AI 17 avg</b></td><td width=\"21%\" align=\"center\">".number_format($ag17[$team1],1)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($ag17[$team2],1)."</td><td align=\"center\">$ag17[diff]</td></tr>";
        
    }
    
    $g = ("data/standings/standings".$current_season.".txt");
	if (file_exists($g)) {$standing_season = $current_season;} else {$standing_season = $current_season-1;}
    $upload_file2 = "data/standings/standings".$standing_season.".txt";
    if(File_exists($upload_file2)) {
        $f2 = fopen($upload_file2,"r");
    	while(!feof($f2)) {
    		$tmp_sta = explode("|",fgets($f2,2000));
    		if (trim($tmp_sta[0]) !== "") {
    		  if($team1 == $tmp_sta[0]) {
    		      $win[$team1] = $tmp_sta[7];
                  $tie[$team1] = $tmp_sta[8];
                  $los[$team1] = $tmp_sta[9];
                  $poi[$team1] = $tmp_sta[11];
                  $div[$team1] = $tmp_sta[6];
                  $con[$team1] = $tmp_sta[5];
                  
    		  }
              if($team2 == $tmp_sta[0]) {
    		      $win[$team2] = $tmp_sta[7];
                  $tie[$team2] = $tmp_sta[8];
                  $los[$team2] = $tmp_sta[9];
                  $poi[$team2] = $tmp_sta[11];
                  $div[$team2] = $tmp_sta[6];
                  $con[$team2] = $tmp_sta[5];
     		  }
              
  		    }
        }fclose($f2);
        
        echo "<tr class=\"hilitetr\"><td colspan=\"5\"><a class=\"hilite2\" href=\"sc.php?id=teams_stats.php\">basic teams stats</a></td></tr>";
        $win[diff] = $win[$team1] - $win[$team2];
        if($win[diff] >= 0) {$win[diff] = "<span class=\"textgreen\">+$win[diff]</span>";} else {$win[diff] = "<span class=\"textred\">$win[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Wins</b></td><td width=\"21%\" align=\"center\">$win[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$win[$team2]</td><td align=\"center\">$win[diff]</td></tr>";
        
        $tie[diff] = $tie[$team1] - $tie[$team2];
        if($tie[diff] >= 0) {$tie[diff] = "<span class=\"textred\">+$tie[diff]</span>";} else {$tie[diff] = "<span class=\"textgreen\">$tie[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Ties</b></td><td width=\"21%\" align=\"center\">$tie[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$tie[$team2]</td><td align=\"center\">$tie[diff]</td></tr>";
        
        $los[diff] = $los[$team1] - $los[$team2];
        if($los[diff] >= 0) {$los[diff] = "<span class=\"textred\">+$los[diff]</span>";} else {$los[diff] = "<span class=\"textgreen\">$los[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Losses</b></td><td width=\"21%\" align=\"center\">$los[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$los[$team2]</td><td align=\"center\">$los[diff]</td></tr>";
        
        $poi[diff] = $poi[$team1] - $poi[$team2];
        if($poi[diff] >= 0) {$poi[diff] = "<span class=\"textgreen\">+$poi[diff]</span>";} else {$poi[diff] = "<span class=\"textred\">$poi[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Points</b></td><td width=\"21%\" align=\"center\">$poi[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$poi[$team2]</td><td align=\"center\">$poi[diff]</td></tr>";
        
        $div[diff] = - $div[$team1] + $div[$team2];
        if($div[diff] >= 0) {$div[diff] = "<span class=\"textgreen\">+$div[diff]</span>";} else {$div[diff] = "<span class=\"textred\">$div[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Division standings</b></td><td width=\"21%\" align=\"center\">$div[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$div[$team2]</td><td align=\"center\">$div[diff]</td></tr>";
        
        $con[diff] = - $con[$team1] + $con[$team2];
        if($con[diff] >= 0) {$con[diff] = "<span class=\"textgreen\">+$con[diff]</span>";} else {$con[diff] = "<span class=\"textred\">$con[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Conference standings</b></td><td width=\"21%\" align=\"center\">$con[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$con[$team2]</td><td align=\"center\">$con[diff]</td></tr>";
    }
    
    
    $g = ("data/stats/teams".$current_season.".txt");
	if (file_exists($g)) {$standing_season = $current_season;} else {$standing_season = $current_season-1;}
    $upload_file2 = "data/stats/teams".$standing_season.".txt";
    if(File_exists($upload_file2)) {
        $f2 = fopen($upload_file2,"r");
    	while(!feof($f2)) {
    		$tmp_sts = explode("|",fgets($f2,2000));
    		if (trim($tmp_sts[0]) !== "") {
    		  if($team1 == $tmp_sts[0]) {
    		      $gd[$team1] = $tmp_sts[1];
                  $sd[$team1] = $tmp_sts[5];
                  $s_p[$team1] = $tmp_sts[6];
                  $g_p[$team1] = $tmp_sts[7];
                  $so[$team1] = $tmp_sts[2];
                  $sh[$team1] = $tmp_sts[18];
                  $pkp[$team1] = $tmp_sts[19];
                  $pp[$team1] = $tmp_sts[15];
                  $ppp[$team1] = $tmp_sts[16];
                  
    		  }
              if($team2 == $tmp_sts[0]) {
    		      $gd[$team2] = $tmp_sts[1];
                  $sd[$team2] = $tmp_sts[5];
                  $s_p[$team2] = $tmp_sts[6];
                  $g_p[$team2] = $tmp_sts[7];
                  $so[$team2] = $tmp_sts[2];
                  $sh[$team2] = $tmp_sts[18];
                  $pkp[$team2] = $tmp_sts[19];
                  $pp[$team2] = $tmp_sts[15];
                  $ppp[$team2] = $tmp_sts[16];
     		  }
              
  		    }
        }fclose($f2);
        
        $gd[diff] = $gd[$team1] - $gd[$team2];
        if($gd[diff] >= 0) {$gd[diff] = "<span class=\"textgreen\">+$gd[diff]</span>";} else {$gd[diff] = "<span class=\"textred\">$gd[diff]</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Goals difference</b></td><td width=\"21%\" align=\"center\">$gd[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$gd[$team2]</td><td align=\"center\">$gd[diff]</td></tr>";
        
        $sd[diff] = $sd[$team1] - $sd[$team2];
        if($sd[diff] >= 0) {$sd[diff] = "<span class=\"textgreen\">+$sd[diff]</span>";} else {$sd[diff] = "<span class=\"textred\">$sd[diff]</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Shots difference</b></td><td width=\"21%\" align=\"center\">$sd[$team1]</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">$sd[$team2]</td><td align=\"center\">$sd[diff]</td></tr>";
        
        $s_p[diff] = $s_p[$team1] - $s_p[$team2];
        if($s_p[diff] >= 0) {$s_p[diff] = "<span class=\"textgreen\">+".number_format($s_p[diff],2)."%</span>";} else {$s_p[diff] = "<span class=\"textred\">".number_format($s_p[diff],2)."%</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Shots efficiency</b></td><td width=\"21%\" align=\"center\">".number_format($s_p[$team1],2)."%</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($s_p[$team2],2)."%</td><td align=\"center\">$s_p[diff]</td></tr>";
         
        $g_p[diff] = $g_p[$team1] - $g_p[$team2];
        if($g_p[diff] >= 0) {$g_p[diff] = "<span class=\"textgreen\">+".number_format($g_p[diff],2)."%</span>";} else {$g_p[diff] = "<span class=\"textred\">".number_format($g_p[diff],2)."%</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Goalies efficiency</b></td><td width=\"21%\" align=\"center\">".number_format($g_p[$team1],2)."%</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($g_p[$team2],2)."%</td><td align=\"center\">$g_p[diff]</td></tr>";
  
        $so[diff] = $so[$team1] - $so[$team2];
        if($so[diff] >= 0) {$so[diff] = "<span class=\"textgreen\">+".number_format($so[diff],0)."</span>";} else {$so[diff] = "<span class=\"textred\">".number_format($so[diff],0)."</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Shot-outs</b></td><td width=\"21%\" align=\"center\">".number_format($so[$team1],0)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($so[$team2],0)."</td><td align=\"center\">$so[diff]</td></tr>";
        
        echo "<tr class=\"hilitetr\"><td colspan=\"5\"><a class=\"hilite2\" href=\"sc.php?id=teams_stats.php\">special teams stats</a></td></tr>";

        
        $sh[diff] = $sh[$team1] - $sh[$team2];
        if($sh[diff] >= 0) {$sh[diff] = "<span class=\"textred\">+".number_format($sh[diff],0)."</span>";} else {$sh[diff] = "<span class=\"textgreen\">".number_format($sh[diff],0)."</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Times shorthanded</b></td><td width=\"21%\" align=\"center\">".number_format($sh[$team1],0)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($sh[$team2],0)."</td><td align=\"center\">$sh[diff]</td></tr>";
          
        $pkp[diff] = $pkp[$team1] - $pkp[$team2];
        if($pkp[diff] >= 0) {$pkp[diff] = "<span class=\"textgreen\">+".number_format($pkp[diff],2)."%</span>";} else {$pkp[diff] = "<span class=\"textred\">".number_format($pkp[diff],2)."%</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Penalty kill efficiency</b></td><td width=\"21%\" align=\"center\">".number_format($pkp[$team1],2)."%</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($pkp[$team2],2)."%</td><td align=\"center\">$pkp[diff]</td></tr>";
        
        $pp[diff] = $pp[$team1] - $pp[$team2];
        if($pp[diff] >= 0) {$pp[diff] = "<span class=\"textgreen\">+".number_format($pp[diff],0)."</span>";} else {$pp[diff] = "<span class=\"textred\">".number_format($pp[diff],0)."</span>";}
        echo "<tr class=\"even\"><td width=\"25%\"><b>&nbsp;Times powerplay</b></td><td width=\"21%\" align=\"center\">".number_format($pp[$team1],0)."</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($pp[$team2],0)."</td><td align=\"center\">$pp[diff]</td></tr>";
           
        $ppp[diff] = $ppp[$team1] - $ppp[$team2];
        if($ppp[diff] >= 0) {$ppp[diff] = "<span class=\"textgreen\">+".number_format($ppp[diff],2)."%</span>";} else {$ppp[diff] = "<span class=\"textred\">".number_format($ppp[diff],2)."%</span>";}
        echo "<tr><td width=\"25%\"><b>&nbsp;Powerplay efficiency</b></td><td width=\"21%\" align=\"center\">".number_format($ppp[$team1],2)."%</td><td align=\"center\">-</td><td width=\"25%\" align=\"center\">".number_format($ppp[$team2],2)."%</td><td align=\"center\">$ppp[diff]</td></tr>";
        
        
    }
  
    echo "</table>";
    
}



?>


<?
if($include_check == "bXnqwa") {
    if(strstr($_SERVER['REQUEST_URI'], "sc.php")) {echo "<div class=\"text\"><b>: teams comparison</b><p></div>";include ("teams_list_compare.php");}

	if ($team1 == $team2) {echo "<center><span class=\"text\">No games of $team1 vs $team2 played ever. make another selection</span></center>";} 
	elseif (($team1 == "x") || ($team2 == "y" )){ echo "";} 
	elseif ($team1 == "") {echo "<center><span class=\"text\">you have to choose team 1 for comparison</span></center>";}  
	elseif ($team2 == "") {echo "<center><span class=\"text\">you have to choose team 2 for comparison</span></center>";}
	else {
		echo "<br /><table align=\"center\" width=\"70%\"><tr>";
		echo "<td align=\"center\"><a href=\"sc.php?id=teams.php&team=$team1\"><img class=\"logo\" alt=\"team logo\" title=\"";
		parseteamname1($team1);
		echo "\" width=\"150px\" src=\"img/team_logo/pics/$team1.jpg\"></a></td>";
		echo "";
		echo "<td align=\"center\"><a href=\"sc.php?id=teams.php&team=$team2\"><img class=\"logo\" alt=\"team logo\" title=\"";
		parseteamname2($team2);
		echo "\" width=\"150px\" src=\"img/team_logo/pics/$team2.jpg\"></a></td>";
		
		echo "</tr></table><br />";
		parseteamscompare($team1, $team2, $type = "reg");
		parseteamscompare($team1, $team2, $type = "po");
        
        echo "<br /><br />";
        parseteamscomparison($team1, $team2);
        echo "<br /><br />";
	}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
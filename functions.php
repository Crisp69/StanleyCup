<?php
//KONTROLA HIGHLITERU
    if(Isset($hilight) || ($hilight == "")) {
        $link_team = $default_dir."/teams_list.txt";
    	$f_teams = fopen($link_team,"r");
        if($f_teams) {
            $teams_list = explode("|", fread($f_teams, filesize($link_team)));
        }
        if(!in_array($hilight, $teams_list)) {$hilight = "none";}
        
    }

//KONTROLA ZOZNAMU TIMOV
    if(Isset($team) || ($team == "")) {
        $link_team = $default_dir."/teams_list.txt";
    	$f_teams = fopen($link_team,"r");
        if($f_teams) {
            $teams_list = explode("|", fread($f_teams, filesize($link_team)));
            
        }
        if(!in_array($team, $teams_list)) {$team = "all";}
        
    }
//KONTROLA SEZON
    $add_list = array($schedule_season, "allstats");
    if(Isset($s) || ($s == "")) {
        $link_season = $default_dir."/season.txt";
    	$f_season = fopen($link_season,"r");
        if($f_season) {
            $season_list = explode("|", fread($f_season, filesize($link_season)));
        }
        $allstats = "allstats";
        $season_list[99999999] = $allstats;
        $season_list[99999998] = $schedule_season;
        if(!in_array($s, $season_list)) {$s = $current_season;}
        
    }
//KONTROLA AWARDS
    if(Isset($trophy) || ($trophy == "")) {
        $link_awards = $default_dir."/awards_list.txt";
    	$f_awards = fopen($link_awards,"r");
        if($f_awards) {
            $awards_list = explode("|", fread($f_awards, filesize($link_awards)));
        }
        if(!in_array(trim($trophy), $awards_list)) {$trophy = "stanleycup";}
        
    }
//KONTROLA SEASON TYPE
    if(Isset($type)) {
        $f_type = array("reg", "po");
        if(!in_array($type, $f_type)) {$type = "reg";}
    }

//KONTROLA POS
    if(Isset($pos) || ($pos == "")) {
        $f_pos = array("points", "goals", "defs", "goalies");
        if(!in_array($pos, $f_pos)) {$pos = "all";}
    }
	
//logout//

function parselogout_link($nick, $align) {
    echo "<table align=\"$align\"><tr><td><a class=\"note1\" href=\"sc.php?id=logout.php\"><img src=\"img/logout.png\" title=\"logout $nick\" alt=\"logout\"></a></td></tr></table>";
    
}
function parselogout_main($nick) {
	if(isset($_COOKIE["login_session"])) {
        $tmp_login = explode("|", $_COOKIE["login_session"]);
        if(file_exists("_tmp/".$tmp_login[0].".php")) {
            include ("_tmp/".$tmp_login[0].".php");
            if(trim($_COOKIE["login_session"]) == trim($l_session[$tmp_login[0]])) {
				echo "<div id=\"logout\">welcome $nick [<a class=\"note1\" href=\"sc.php?id=logout.php\">logout</a>]</div>";
			}
		}
	}
    else {
        echo "<div id=\"logout\">[<a class=\"note1\" href=\"sc.php?id=login.php\">login</a>]</div>";
    }
}

//team list//
function parseteamlogolist() {
	$upload_dir = "data/teams/";
	$c = 0;
	echo "<table align=\"center\"><tr>";
	$f = fopen($upload_dir."/teams.txt","r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if ((trim($tmp[0]) != "") && ($tmp[0] !="atl")) {
			
			echo "<td><a target=\"_blank\" rel=\"shadowbox;width=1100;height=600\" href=\"http://www.hockeyarena.net/index.php?p=public_team_info_basic.php&amp;team_id=$tmp[3]\"><img class=\"logo\" title=\"$tmp[1]\" width=\"28px\" alt=\"$tmp[1]\" src=\"img/team_logo/small/$tmp[0].png\"></a></td>\n";
			$c++;
			
		}
	}
	fclose($f);
			
	echo "</tr></table>";
}

//build list of teams in menu
function menu($conf_menu) {
    $upload_dir = "data/default/";
	$c = 0;
	$f = fopen($upload_dir."/teams_list.txt","r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) !== "") {
			if ($tmp[3] == $conf_menu) {
			 echo "<li><a class=\"c1\" href=\"sc.php?id=teams.php&amp;team=$tmp[1]\">$tmp[2]</a></li>\n";
			}
		}
	}
	fclose($f);
			
	echo "</tr></table>";
}

function menu_stats($conf_menu) {global $s, $current_season, $type, $aaa, $sort, $active;
    $upload_dir = "data/default/";
	$c = 0;
	if(!isset($aaa) || ($aaa == "")) {$aaa = "all";}
	if(!isset($s) || ($s == "")) {$s = $current_season;}
	$h = ("data/stats/points".$s."po.txt");
	if (file_exists($h)) {$season_type = "po";} else {$season_type = "reg";}
    if (!IsSet($type) || ($type == "")) {$type = $season_type;}
    	
	$f = fopen($upload_dir."/teams_list.txt","r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) !== "") {
			if ($tmp[3] == $conf_menu) {
			echo "<li><a class=\"c1\" href=\"sc.php?id=stats.php&amp;team=$tmp[1]&amp;s=$s&amp;type=$type&amp;pos=$aaa&amp;sort=$sort&amp;active=$active\">$tmp[2]</a></li>\n";
			}
		}
	}
	fclose($f);
}

//SC winner//
function parsewinner() {
	$upload_dir = "data/data/";
	$c = 0;
	$f = fopen($upload_dir."/champs.txt","r");
	while(!feof($f) && ($c<1)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			echo "<a href=\"sc.php?id=teams.php&amp;team=$tmp[1]\"><img class=\"logo\" width=\"32px\" title=\"$tmp[2]\" alt=\"$tmp[2]\" src=\"img/team_logo/large/$tmp[1].gif\"></a>";
			$c++;
		}
	}
	fclose($f);
}

//schedule list
function parseseasonlist_schedule() {global $s, $current_season, $schedule_season, $season_type, $type, $team;
	$upload_dir = "data/default/";
	$n = "season.txt";
	if (!IsSet($team)) {$team = "all";}
	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose season...</option>";
	if ($current_season != $schedule_season) {echo "<option value=\"sc.php?id=schedule.php&amp;s=$schedule_season&amp;type=reg&amp;team=$team\">$schedule_season. season </option>";}
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if (!IsSet($type)) {$type = $season_type;}
			echo "<option value=\"sc.php?id=schedule.php&amp;s=".trim($tmp[0])."&amp;type=$type&amp;team=$team\">".trim($tmp[0]).". season </option>";
			$c++;
		}
	}
	fclose($f);
	echo "</select></td></tr></table><br />";
}

//standings list//
 function parseseasonlist_standings() {global $s, $current_season;
	$upload_dir = "data/default/";
	$n = "season.txt";
	
	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose season...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			$g = ("data/standings/standings".$current_season.".txt");
			if ((!file_exists($g)) && ($current_season == trim($tmp[1]))) {echo "";} else{
			echo "<option value=\"sc.php?id=standings.php&amp;s=".trim($tmp[0])."\">".trim($tmp[0]).". season </option>";
			$c++;
			}
		}
	}
	fclose($f);
	echo "</select></tr></table><br />";
}	


//stats list
function parseseasonlist_stats() {global $s;
	$upload_dir = "data/default/";
	$n = "season.txt";
	
	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose season...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			echo "<option value=\"sc.php?id=stats.php&amp;s=".trim($tmp[0])."\">".trim($tmp[0]).". season </option>";
			$c++;
		}
	}
	echo "<option value=\"sc.php?id=stats.php&amp;s=allstats&amp;team=all\">all stats </option>";
	fclose($f);
	echo "</select></td></tr></table>";
}	

//awards list//
function parseseasonlist_awards() {global $current_season;
	$upload_dir = "data/default/";
	$n = "season.txt";
	
	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose season...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			$g = ("data/awards/awards".$current_season.".txt");
			if ((!file_exists($g)) && ($current_season == trim($tmp[1]))) {echo "";} else{
			echo "<option value=\"sc.php?id=awards_season.php&amp;s=".trim($tmp[1])."\">".trim($tmp[0]).". season </option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</select></td></tr></table><br />";
}	

//manager stats
function parsemanagersearch() {
	$file = "data/teams/teams_history.txt";
    if (file_exists($file)) {
    	$f = fopen($file,"r");
    	$count[$nick] = 0;
    	while(!feof($f)) {
    		$tmp = explode("|",fgets($f,10000));
    		if (trim($tmp[0]) !== "") {if ($tmp[2] !== "<i>no manager</i>"){
    			$nick = strtolower($tmp[2])."|".$tmp[2];
    			$count[$nick] = $count[$nick] + 1;
    			if ($count[$nick] == 1) {$sort[] = $nick; }
    			
    			}
    		}
    	}
    	sort($sort);
    	echo "<table align=\"right\">";
    	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
    	foreach ($sort as $nick) {
    		$nicky = explode("|",$nick);
    		echo "<option value=\"sc.php?id=manager_stats.php&amp;manager=$nicky[1]\">".$nicky[1]."</option>";
    	}echo "</table>";
    }
}

//link na meno hraca//
function parseplayer_link($name) {
	$name = str_replace(" ", "+", $name);
    $name = preg_replace('/[^a-zA-Z0-9_ +-]/s', '-', $name);
	echo $name;
}

//highlight cookie
function parsehilight($hilight) {global $hilight, $id;
	
	$c = 0;
	echo "<table align=\"center\" width=\"95%\">";
	//echo "<tr><td align=\"center\"><span class=\"note\">highlight your team: </span></td></tr>";
    echo "<tr><td align=\"center\"><select class=\"listmain\" onchange=\"document.location.href=value;\"><option value=\"sc.php?id=$id&hilight=none\">choose team...&nbsp;</option>\n";
	$f = fopen("data/default/teams_list.txt","r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) !== "") {
			if (trim($tmp[1]) == trim($hilight)) {echo "<option SELECTED value=\"sc.php?".$_SERVER['QUERY_STRING']."&amp;hilight=".trim($tmp[1])."\">".trim($tmp[2])."</option>";}
			else {echo "<option value=\"sc.php?".$_SERVER['QUERY_STRING']."&amp;hilight=".trim($tmp[1])."\">".trim($tmp[2])."</option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table>";
}

function parseteamnamesearch($team_name) {
	$f = fopen("data/default/teams_list.txt", "r");
    if($team_name == "atl") {echo "<a href=\"sc.php?id=teams.php&team=atl\"><img width=\"25px\" alt=\"$tmp[1]\" title=\"$tmp[0]\" src=\"img/team_logo/small/atl.png\"></a></td><td><a class=\"text1\" href=\"sc.php?id=teams.php&team=atl\">Atlanta</a>";}
    else {
    	while (!feof($f)) {
    		$tmp = explode("|", fgets($f, 2000));
    		if (trim($tmp[0]) !== "") {
                if ($team_name == trim($tmp[1])) {
                    echo "<a href=\"sc.php?id=teams.php&team=$tmp[1]\"><img width=\"25px\" alt=\"$tmp[1]\" title=\"$tmp[0]\" src=\"img/team_logo/small/$tmp[1].png\"></a></td><td><a class=\"text1\" href=\"sc.php?id=teams.php&team=$tmp[1]\">" . $tmp[0]."</a>";
    			}
    		}
    	}
    }
}


//pocitadlo//
function counterAdd() {
	$c = 0;
	if (file_exists("counter.dat")) {
		$f = fopen("counter.dat","r");
		$c = fgets($f,16);
		$c++;
		fclose($f);
	}
	$f = fopen("counter.dat","w");
	fputs($f,$c);
	fclose($f);
}

function counterDisplay() {
	$f = fopen("counter.dat","r");
	$c = fgets($f,16);
	fclose($f);
	$add = "";
	if ($c<10) {$add = $add."0";}
	if ($c<100) {$add = $add."0";}
	if ($c<1000) {$add = $add."0";}
	if ($c<10000) {$add = $add."0";}
	if ($c<100000) {$add = $add."0";}
	return $add.$c;
}

?>
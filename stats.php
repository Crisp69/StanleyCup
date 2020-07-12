
<?php

if($include_check == "bXnqwa") {

    include ("stats_function.php");
    include ("stats_function_selector.php");
    
    $upload_dir = "data/stats";
    
    if ((!isset($pos) || $pos == "")) {
    	$pos = "all";
    }
    if (!isset($team) || $team == "") {
    	$team = "all";
    }
    if (!isset($active) || $active == "") {
    	$active = "all";
    }
    $g = ($upload_dir."/points".$current_season."reg.txt");
    if (file_exists($g)) {$stats_season = $current_season;} else {$stats_season = $current_season-1;}
    if (!isset($s) || $s == "") {
    	$s = $stats_season;
    }
    
    $h = ($upload_dir."/points".$stats_season."po.txt");
    if (file_exists($h)) {$season_type = "po";} else {$season_type = "reg";}
    if (!IsSet($type) || ($type == "")) {$type = $season_type;}
    
		
	
    $bbb = $type;
    $aaa = $pos;
    $err = "<center><span class=\"text\"><br /><b>[no stats available for your selection]</b></span></center><br />";
    if($s =="allstats") {parseactive($s, $active, $pos, $type, $sort, $team);}
    if($team !== "all") {$hilighted = "none";} else {$hilighted = $hilight;}
    echo "<br /><br />";
    if (($s == "allstats") && ($type == "po")) {
    	echo $err;
    } elseif (($pos == "all") && ($team == "all")) {
    	parsestats($s, $pos = "points", $type = $type, $team, $statscount = 20, $hilighted, $sort = "points", $page = 1, $active);echo "<br />";
    	parsestats($s, $pos = "points", $type = $type, $team, $statscount = 10, $hilighted, $sort = "goals", $page = 1, $active);echo "<br />";
    	parsestats($s, $pos = "defs", $type = $type, $team, $statscount = 10, $hilighted, $sort = "points", $page = 1, $active);echo "<br />";
    	parsestats($s, $pos = "goalies", $type = $type, $team, $statscount = 10, $hilighted, $sort = "svs_perc", $page = 1, $active);echo "<br />";
    } elseif (($pos == "all")) {
    	parsestats($s, $pos = "points", $type = $type, $team, $statscount = 20, $hilighted, $sort = "points", $page, $active);echo "<br />";
    	parsestats($s, $pos = "points", $type = $type, $team, $statscount = 10, $hilighted, $sort = "goals", $page, $active); echo "<br />";
    	parsestats($s, $pos = "defs", $type = $type, $team, $statscount = 10, $hilighted, $sort = "points", $page, $active);echo "<br />";
    	parsestats($s, $pos = "goalies", $type = $type, $team, $statscount = 10, $hilighted, $sort = "svs_perc", $page, $active);echo "<br />";
    } elseif (($pos == "defs") && (($s == "01") || ($s == "02") || ($s == "03") || ($s ==
    "04") || ($s == "05") || ($s == "06") || ($s == "07") || ($s == "08") || ($s ==
    	"09") || ($s == "allstats"))) {
    	echo $err;
    } else {
    	parsestats($s, $pos, $type, $team, $statscount = 50, $hilighted, $sort, $page, $active);
    		if (($pos == "goalies") && ($type == "reg") && ($s !== "allstats")) {echo "<div class=\"note\"><br />* goalie must play more than half of games to be qualified</div>";}
    		elseif (($pos == "goalies") && ($type == "reg") && ($s == "allstats")) {echo "<div class=\"note\"><br />* - goalie must play at least 22 games to be qualified</div>";}
            elseif (($pos == "goalies") && ($type == "po") && ($s != "allstats")) {echo "<div class=\"note\"><br />* - goalie must play at least 60 minutes to be qualified</div>";}
    }
    if (($s == "allstats") && (($pos !== "defs") && ($type !== "po"))) {echo "<div class=\"note\">† - player did not play in last season</div>";}
    echo "<br />";
    
    //echo "$s - $team - $aaa - $type";

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
    
?>

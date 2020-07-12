<?
if($include_check == "bXnqwa") {

    include("manager_stats_function.php");
    
    if ((IsSet($manager)) && ($manager !== "")) {
    	parsemanagersearch();
    	echo "<br /><div class=\"text\"><b>: manager stats</b></div>";
    	echo "<br /><table width=\"40%\" align=\"center\" class=\"awards\"><tr><td colspan=\"2\"><center><div class=\"headline\">- $manager -</div></center><p></td></tr><tr><td align=\"center\">";
    	echo "<b>Stanley Cup champion</b></td><td width=\"15%\">";
    	parseawards_count($manager, $award = "stanleycup");
    	echo "x</td></tr><tr><td align=\"center\"><b>Presidents' Trophy winner</b></td><td>";
    	parseawards_count($manager, $award = "pres");
    	echo "x</td></tr><tr><td align=\"center\"><b>Conference title</b></td><td>";
    	parseawards_count($manager, $award = "conf");
    	echo "x</td></tr><tr><td align=\"center\"><b>Division title</b></td><td>";
    	parsecount_div($manager);
    	echo "x</td></tr><tr><td align=\"center\"><b>Jack Adams Trophy</b></td><td>";
    	parseawards_count($manager, $award = "jack");
    	echo "x</td></tr><tr><td></td><td>&nbsp;</td></tr>";
    	echo "</table><br />";
    	
    	parsemanagerhistory($manager);
    	echo "<br />";
    	parseawards($manager);
    		
    	include("manager_stats_function_players.php");
    		
    	parsestats($s = "allstats", $pos = "points", $type = "reg", $manager = $manager, $statscount = 25);
    	echo "<br />";
    	parsestats($s = "allstats", $pos = "goalies", $type = "reg", $manager = $manager, $statscount = 5); 
    	echo "<span class=\"note\">goalie must play at least 22 games to be qualified</span>";
    }
    else {
    	echo "<br /><div class=\"text\"><b>: manager stats</b></div>";
    	echo "<br /><center>Choose a manager from the list:<br /><br />";
    	echo "<table align=\"center\"><tr><td>";
    	parsemanagersearch();
    	echo "</td></tr></table></center>";
   	}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
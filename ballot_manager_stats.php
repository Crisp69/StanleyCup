<?

if($include_check == "bXnqwa") {

    include("manager_stats_function.php");
    
    if ((IsSet($manager)) && ($manager !== "")) {
    	
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
    
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>

<br />
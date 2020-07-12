<?
if($include_check == "bXnqwa") {
    if (!isset($pos)) {
    	$pos = "points";
    }
    if (isset($name)) {
        if(!isset($s)) {$s = "alltime";}
        
        //echo "s = $s, name = $name, pos = $pos";
        include("player_stats_function.php");
        if(($s == "alltime")) {
            if((isset($id_player)) && ($id_player !="")) {
            echo "<table width=\"99%\" align=\"center\"><tr><td class=\"menu_small\"><span class=\"textgrey\"><b>all time record</b></span> | <a class=\"texthilite\" href=\"jquery.php?id=player_stats.php&amp;pos=$pos&amp;name=$name&amp;id_player=$id_player&amp;s=$current_season\">this season games</a></td></tr></table><br /><br />";}
        	parsestats($pos = $pos, $type = "reg", $statscount = 1000, $name);
        	parsestats($pos = $pos, $type = "po", $statscount = 1000, $name);
        	echo "<br />";
        	parseawards($name);
        	}
        elseif($s == $current_season) {
            if((isset($id_player)) && ($id_player !="")) {
            echo "<table width=\"99%\" align=\"center\"><tr><td class=\"menu_small\"><a class=\"texthilite\" href=\"jquery.php?id=player_stats.php&amp;pos=$pos&amp;name=$name&amp;id_player=$id_player\">all time record</a> | <span class=\"textgrey\"><b>this season games</b></span></td></tr></table><br /><br />";}
            parseplayerstats_name($id_player, $pos);
            }
        else {"bbb";}    
        }
    else {
    	echo "Error! No player selected";
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}


?>
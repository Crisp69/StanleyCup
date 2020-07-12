<?php
//hlavna stranka, id!=news a magazine
function mainrightcolumn() {global $id, $include_check, $current_season;
    echo "<div id=\"columnright\">";
	echo "<div class=\"hilite\"><a href=\"sc.php?id=pics.php\" class=\"hilite\">ice girls</a></div><center>"; 
	include("rotate_script.php"); 
	echo "</center></div>";	
    echo "<div id=\"columnright\"><div class=\"hilite\"><a rel=\"shadowbox;&width=770;height=250;\" class=\"hilite\" href=\"jquery.php?id=data/highlighter.html\">highlight your team</a></div>";
    parsehilight($hilight);
    echo "</div>";

	if($id != "bo.php") {
		echo "<div id=\"columnright\">";
		echo "<div class=\"hilite\"><a href=\"sc.php?id=bo.php\" class=\"hilite\">betting office</a></div><center>"; 
		include("function_bo_short.php");
        parse_bo_total_short($s);
		echo "</center></div>";	
	}
    
	echo "<div id=\"columnright\">";
	echo "<div class=\"hilite\"><a href=\"sc.php?id=news.php\" class=\"hilite\">news</a></div>";
	include("function_news_short.php");
	parsenews_short();
	echo "</div>";
	
	echo "<div id=\"columnright\">";
	echo "<div class=\"hilite\"><a href=\"sc.php?id=magazine.php\" class=\"hilite\">magazine</a></div>";
	include ("function_magazine_short.php"); 
	parsemagazine_short();
	echo "</div>";
	
    if($id != "stars.php") {
		echo "<div id=\"columnright\"><div class=\"hilite\"><a href=\"sc.php?id=stars.php\" class=\"hilite\">stars of the night</a></div>";
		include("function_stars_short.php");
		parsestar_short();
		echo "</div>";
	}
    
	if($id !== "stats.php") {
		echo "<div id=\"columnright\"><div class=\"hilite\"><a href=\"sc.php?id=stats.php\" class=\"hilite\">players stats</a></div>";
		include("function_stats_short.php");
		echo "</div>";
	}
    			
	//echo "<div id=\"columnright\"><div class=\"hilite\">links</div>";
	//include("function_links.php"); 
	//echo "</div>";
}

//hlavna stranka, id==news a magazine
function mainrightcolumn_news() {global $id, $include_check, $current_season;
    echo "<div id=\"columnright\"><div class=\"hilite\"><a href=\"sc.php?id=pics.php\" class=\"hilite\">ice girls</a></div>"; 
	include("rotate_script.php"); 
	echo "</div>";
    
    echo "<div id=\"columnright\"><div class=\"hilite\"><a rel=\"shadowbox;&width=500;height=250;\" class=\"hilite\" href=\"jquery.php?id=data/highlighter.html\">highlight your team</a></div>";
    parsehilight($hilight);
    echo "</div>";
    
    echo "<div id=\"columnright\"><div class=\"hilite\"><a href=\"sc.php?id=stars.php\" class=\"hilite\">stars of the night</a></div>";
	include("function_stars_short.php");
	parsestar_short();
	echo "</div>";
    
	echo "<div id=\"columnright\"><div class=\"hilite\"><a href=\"sc.php?id=stats.php\" class=\"hilite\">players stats</a></div>";
	include("function_stats_short.php");
	echo "</div>";


}

//hlavna stranka, id==news a magazine
function mainleftcolumn_news() {global $id, $include_check, $s;
	echo "<div id=\"columnleft\">";
	if($id == "news.php") {
		echo "<div class=\"hilite\"><a href=\"sc.php?id=magazine.php\" class=\"hilite\">magazine</a></div>";
		include("function_magazine_short.php");
		parsemagazine_short();
		} 
	elseif($id == "magazine.php") {
		echo "<div class=\"hilite\"><a href=\"sc.php?id=news.php\" class=\"hilite\">news</a></div>"; 
		include("function_news_short.php");
		parsenews_short();
		}
	echo "</div>";
    
    echo "<div id=\"columnleft\">";
	echo "<div class=\"hilite\"><a href=\"sc.php?id=bo.php\" class=\"hilite\">betting office</a></div><center>"; 
	include("function_bo_short.php");
    parse_bo_total_short($s);
	echo "</center></div>";	            

	/*echo "<div id=\"columnleft\"><div class=\"hilite\"><a href=\"sc.php?id=data/pollarchive.html\" class=\"hilite\">stanley cup poll</a></div>"; 
			echo "<table class=\"poll\" align=\"center\" width=\"95%\"><tr><td align=\"left\" class=\"tdpoll\">";
			include ("data/poll/poll.php");
			echo "<p></td></tr></table>";
	echo "</div>";*/
	
	updates(); 
	
	echo "<div id=\"columnleft\"><div class=\"hilite\">links</div>";
	include("function_links.php"); 
	echo "</div>";

}

$stats_pages = array("stats.php" => "players stats", "teams_stats.php" => "teams stats", "manager_stats.php" => "managers stats", "stats_income.php" => "game income");
$teams_pages = array("teams.php" => "teams", "teams_addinfo.php" => "teams strength", "teams_compare.php" => "teams comparison");
$awards_pages = array("awards_season.php" => "by season", "awards.php" => "by trophy", "stars.php" => "stars of the night", "ballot.php" => "awards ballot");
$sc_pages = array("rules.php" => "about", "reg.php" => "registration");

$submenu_pages = array_merge(array_keys($stats_pages), array_keys($teams_pages), array_keys($awards_pages), array_keys($sc_pages));


function submenu(){global $id, $stats_pages, $awards_pages, $teams_pages, $submenu_pages, $sc_pages;
    if(in_array($id, array_keys($stats_pages))){$submenu = $stats_pages; $submenu_name = "stats";}
    if(in_array($id, array_keys($awards_pages))){$submenu = $awards_pages; $submenu_name = "awards";}
    if(in_array($id, array_keys($teams_pages))){$submenu = $teams_pages; $submenu_name = "teams";}
    if(in_array($id, array_keys($sc_pages))){$submenu = $sc_pages; $submenu_name = "teams";}
    echo "|";
    foreach ($submenu as $key => $value) {
        if($id == $key) {echo " <a href=\"sc.php?id=$key\" class=\"textgrey\"><b>$value</a></b> |";} else {echo " <a href=\"sc.php?id=$key\" class=\"texthilite\">$value</a> |";}}
    
}

function updates() {global $current_season;
    $update_file = "data/data/update".$current_season.".txt";
	
	if(File_Exists($update_file)) {
	echo "<div id=\"columnleft\"><div class=\"hilite\">update log</div>";
	echo "<table class=\"poll\" width=\"95%\" align=\"center\">\n";
    $c = 0;
	$z = 1;
    $f = fopen($update_file,"r");
	while(!feof($f) && $c < 10) {
		$tmp = explode("|",fgets($f,10000));
        if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
		if($tmp[0] !="") {
			$ext = "";$txt = "new ";
			if($tmp[1]!="magazine") {$ext = ".php"; $txt = "";}
			echo "<td align=\"left\" width=\"35%\"><span class=\"date\" title=\"".date("d M Y H:i:s", $tmp[0])."\">";
			$date1 = date("dM", $tmp[0]);
			$date2 = date("dM", time());
			if($date1 == $date2) {echo date("H:i:s", $tmp[0]);} else {echo date("dMy", $tmp[0]);}
			echo "</span></td><td align=\"left\" width=\"65%\"><a title=\"".date("d M Y H:i:s", $tmp[0])."\" class=\"date\" href=\"sc.php?id=$tmp[2]$ext\">$txt$tmp[1]</a></span></td>";
			echo "</tr>";$c++;            
			}
        }
    echo "</table>";echo "</div>";
    }
}


?>
<?


global $pos, $s, $team, $type, $current_season, $sort;
		$upload_dir = "data/stats";
		
		if (!IsSet($pos)) {$pos = "all";}
		if (!IsSet($team)) {$team = "all";}
		$h = ($upload_dir."/points".$current_season."reg.txt");
		if (file_exists($h)) {$stats_season = $current_season;} else {$stats_season = $current_season-1;}
		if (!isset($s)) {$s = $stats_season;}
		
		$g = ($upload_dir."/points".$stats_season."po.txt");
		if (file_exists($g)) {$season_type = "po";} else {$season_type = "reg";}
		if (!IsSet($type)) {$type = $season_type;}
		
		if (($s == $stats_season) && ($season_type == "reg") && ($type == "po")) {$type = "reg"; echo "<center><span class=\"text\"><br /><b>[no stats available for $s. season - playoffs yet]</b></span></center><br />";}	

$help ="<div class=\"sample_popup\" id=\"popup\" style=\"display: none;\"><div id=\"popup_drag\"><img class=\"menu_form_exit\" id=\"popup_exit\" title=\"close\" src=\"img/form_exit.png\" alt=\"\" /></div><b>rk</b> - ranking<br /><b>M</b> - played matches<br /><b>G</b> - goals<br /><b>A</b> - asists<br /><b>P</b> - points total<br /><b>Perf</b> - average performance<br /><b>Shs</b> - shots<br /><b>Svs</b> - saves<br /><b>%</b> - saves percentage<br /><b>Shout</b> - Shot-outs<br /><b>1st, 2nd, 3rd</b> - star of the weekend selection</div>";
 	
 	
echo "<center>
<table class=\"select\" width=\"72%\" ><form method=\"post\" name=\"selector\" action=\"sc.php?id=stats.php\">
<tr>
<td align=\"center\" colspan=\"4\"><span class=\"text\">Make your selection</span></td>
</tr>
<tr>
<td align=\"left\" width=\"20%\" valign=\"top\" rowspan=\"2\">
<center><span class=\"whitedate\">Position</span></center>
<input ";
if ($pos=="all") {echo "checked=\"checked\"";} 
echo "name=\"pos\" type=\"radio\" value=\"all\" />
<span class=\"note\">overview</span><br />
<input ";
if ($pos=="points") {echo "checked=\"checked\"";}
echo "name=\"pos\" type=\"radio\" value=\"points\" />
<span class=\"note\">all skaters</span><br />
<input ";
if ($pos=="defs") {echo "checked=\"checked\"";}
echo "name=\"pos\" type=\"radio\" value=\"defs\" />
<span class=\"note\">defs</span><br />
<input  ";
if ($pos=="goalies") {echo "checked=\"checked\"";}
echo "name=\"pos\" type=\"radio\" value=\"goalies\" />
<span class=\"note\">goalies</span>
</td>
<td width=\"27%\" align=\"center\" valign=\"top\" rowspan=\"2\">
<span class=\"whitedate\">Choose team</span><br />";

parseteamslist_stats();
echo "</td>
<td width=\"27%\" valign=\"top\" align=\"center\" rowspan=\"2\">
<span class=\"whitedate\">Choose season</span><br />";


parseseasonlist_stats_detail();

echo "</td>
<td align=\"left\" width=\"26%\" valign=\"top\">


<span class=\"whitedate\">Season</span><br />
<input  ";
if ($type=="reg") {echo "checked=\"checked\"";}
echo "name=\"type\" type=\"radio\" value=\"reg\"/>
<span class=\"note\">regular season</span><br />
<input  ";
if ($type=="po") {echo "checked=\"checked\"";}
echo "name=\"type\" type=\"radio\" value=\"po\"/>
<span class=\"note\">playoffs</span>
</td>
<tr><td align=\"center\">
<input type=\"hidden\" name=\"sort\" value=\"$sort\">
<input type=\"hidden\" name=\"active\" value=\"$active\">

<input class=\"button\" type=\"submit\" value=\"-- SELECT --\" /></center>
<br /><br />
<a class=\"note1\" href=\"javascript:popup_show('popup', 'popup_drag', 'popup_exit');\">legend</a>
$help
</form>

</td>

</tr>
</table>
</center>
";


?>

<?
function parseteamslist_stats() {global $team;
	$upload_dir = "data/default/";
	$n = "teams_list.txt";
	
	$c = 0;
	echo "<table>";
	echo "<tr><td>&nbsp;<select size=\"7\" name=\"team\"class=\"list\">";
	echo "<option value=\"all\"";
	if ($team=="all") {echo "SELECTED ";}
	echo ">&nbsp;*all teams*</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {echo "<option SELECTED value=".trim($tmp[1]).">".trim($tmp[0])."</option>";}
			else {echo "<option value=".trim($tmp[1]).">".trim($tmp[0])."&nbsp;&nbsp;</option>";}
			$c++;
		}
	}
	fclose($f);
			echo "</select></td></tr></table>";
}


function parseseasonlist_stats_detail() {global $s, $current_season; 
	$upload_dir = "data/default/";
	$n = "season.txt";
	
	$c = 0;
	echo "<table>";
	echo "<tr><td>&nbsp;<select size=\"7\" name=\"s\" class=\"list\">";
	echo "<option value=\"allstats\"";
	if ($s=="allstats") {echo "SELECTED ";}
	echo ">*all stats* </option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			$g = ("data/stats/points".$current_season."reg.txt");
			if ((!file_exists($g)) && ($current_season == trim($tmp[1]))) {echo "";} else{
			if ($s==trim($tmp[0])) {echo "<option SELECTED value=".trim($tmp[0]).">".trim($tmp[0]).". season </option>";}
			else {echo "<option value=".trim($tmp[0]).">".trim($tmp[0]).". season&nbsp;&nbsp;</option>";}
			$c++;
			}
		}
	}

	fclose($f);
	echo "</select></td></tr></table>";

}

function parseactive($s, $active, $pos, $type, $sort, $team) {
    
    if($s == "allstats") {
        echo "<center>
        <table width=\"45%\" ><form method=\"post\" action=\"sc.php?id=stats.php\" name=\"active\">
        <tr><td>";
       	echo "<input type=\"radio\" ";
        if ($active=="active") {echo "checked=\"checked\"";}
    	echo "name=\"active\" value=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;team=$team&amp;type=$type&amp;sort=$sort&amp;active=active\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;active players only</span></td><td>";
    	echo "<input type=\"radio\" ";
    	if ($active !=="active") {echo " checked=\"checked\"";}
    	echo "name=\"active\" value=\"sc.php?id=stats.php&amp;s=$s&amp;pos=$pos&amp;team=$team&amp;type=$type&amp;sort=$sort\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;all players</span>";
    	echo "</form>";
    	echo "</td></tr></table></center>";
        
    }
}
?>
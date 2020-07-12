<?php
function parseteamslist_compare() {global $team1, $team2;
	$upload_dir = "data/default/";
	$n = "teams_list.txt";
 
	echo "<center>";
	echo "<table width=\"55%\" class=\"select\"><form method=\"post\" action=\"sc.php?id=teams_compare.php\" >";
	echo "<tr><td align=\"center\" colspan =\"3\"><span class=\"text\">Make your selection</span></td></tr> ";
	echo "<tr><td align=\"center\"><span class=\"whitedate\">Team 1</span></td><td align=\"center\"><span class=\"whitedate\">Team 2</span></td><td><span class=\"whitedate\">&nbsp;</span></td></tr>";
	echo "<tr><td align=\"center\">&nbsp;<select size=\"1\" name=\"team1\"class=\"list\">";
	$f = fopen($upload_dir.$n,"r");
	echo "<option value=\"\">&nbsp;choose team...</option>";
	
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team1 == trim($tmp[1])) {echo "<option SELECTED value=".trim($tmp[1]).">".trim($tmp[0])."</option>";}
			else {echo "<option value=".trim($tmp[1]).">".trim($tmp[0])."&nbsp;&nbsp;</option>"; }
			$c++;
		}
	}
	fclose($f);
	echo "</td><td align=\"center\">&nbsp;<select size=\"1\" name=\"team2\"class=\"list\">";
	echo "<option value=\"\">&nbsp;choose team...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team2 == trim($tmp[1])) {echo "<option SELECTED value=".trim($tmp[1]).">".trim($tmp[0])."</option>";}
			else {echo "<option value=".trim($tmp[1]).">".trim($tmp[0])."&nbsp;&nbsp;</option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</td><td valign=\"middle\">
	<input type=\"submit\" class=\"button\" value=\"-- SELECT --\" /></center>
</form></td>";
	echo "</tr><tr><td></td><td></td><td></td></tr></table></center><br />";
}
	
?>

<?
if($include_check == "bXnqwa") {

    if (!isset($team1)) {
    	$team1 = "x";
    }
    if (!isset($team2)) {
    	$team2 = "y";
    }
    parseteamslist_compare();
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
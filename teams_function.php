<?php


/*hlavna cast*/
function parseteams($team) {
	$upload_dir = "data/teams/";
	$n1 = "teams";
	$n2 = ".txt";

	echo "<table width=\"98%\" align=\"center\">\n";
	$f2 = $n1.$n2;
	$f = fopen($upload_dir.$f2,"r");
		$c = 0;
		$bbb = 0;
		while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {
				if ($team == trim($tmp[0])) {$bbb = $bbb + 1;
				echo "<tr class=\"rounded\">";
				echo "<th height=\"20px\" align=\"center\" colspan=\"4\"><a class=\"tblhd\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/index.php?p=public_team_info_basic.php&team_id=$tmp[3]\">$tmp[1]</a></th></tr><tr><td colspan=\"5\"><br /></td></tr>";			
				echo "<td width=\"17%\" rowspan=\"4\" valign=\"top\" align=\"left\"><img class=\"logo\" title=\"$tmp[1]\" alt=\"$tmp[1]\" src=\"img/team_logo/large/$tmp[0].gif\"></td>";
				echo "<td width=\"16%\" valign=\"top\" align=\"left\"><span class=\"note\">manager: </span></td><td><div class=\"text\"><b><a class=\"text\" href=\"sc.php?id=manager_stats.php&manager=$tmp[4]\">$tmp[4]</a></b></div></td>";
				echo"<td rowspan=\"6\" valign=\"top\" align=\"right\"><img class=\"logo\" title=\"$tmp[1]\" alt=\"$tmp[1]\" src=\"img/winners/star/$tmp[0].jpg\"></td></tr>";
				echo "<tr><td valign=\"middle\" align=\"left\"><span class=\"note\">division: </span></td><td><div class=\"text\">$tmp[2]</div></td></tr>";
				echo "<tr><td valign=\"middle\" align=\"left\"><span class=\"note\">country: </span></td><td><img class=\"logo\" title=\"$tmp[5]\" alt=\"$tmp[5]\" src=\"img/flags/$tmp[5].gif\"><span class=\"text\"> $tmp[5]</span></td></tr>";
				echo "<tr><td valign=\"top\" align=\"left\"><div class=\"note\">Stanley Cup history: </div></td><td valign=\"top\"><div class=\"text\"><b>Stanley Cup Champions:</b><br />$tmp[6]<p></div></tr>";
				echo "<tr><td colspan=\"2\" valign=\"top\"><a target=\"_blank\"href=\"http://orico.wz.cz/ha-tools/en?team=$tmp[3]&c=team-info\"><img class=\"logo\" src=\"img/ha-tools.gif\" alt=\"HA-tools\"></a><br />";
				echo "<td valign=\"top\" align=\"left\"><div class=\"text\">Presidents' Trophy:<br />$tmp[7]<p>";
				echo "</td></tr>";
				echo "<tr><td colspan=\"2\" rowspan=\"2\" valign=\"top\">";
				parseteamslist_compare_small();
				echo "</td><td>";
				
				if ($tmp[11]) {
				echo "Prince of Wales Trophy";}
				else {echo "Clarence S. Campbell Bowl";}
				echo " (Conference Title):<br />$tmp[8]</div><p>";
				echo "<div class=\"text\">Division Title:<br />$tmp[9]</div></td></tr>";
				
				}
			}
			$c++;
		}
	echo "</table>\n";if ($bbb !== 1) {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=teams.php\">";}
}


/*match-up history*/
function parseteamslist_compare_small() {global $team;
	$upload_dir = "data/default/";
	$n = "teams_list.txt";
	$team1 = $team;

	echo "<table>";
	echo "<tr><td><span class=\"text\">View history against:</span></td></tr> ";
	echo "<tr><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose team...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {echo "";}
			else {echo "<option value=\"sc.php?id=teams_compare.php&team1=$team&team2=".trim($tmp[1])."\">".trim($tmp[0])."</option>";}
			$c++;
		}
	}
	fclose($f);
echo "</select></td></tr></table><br />";

}

/*zoznam timov*/
function parseteamslist_teams() {global $id, $team, $detail;
	$upload_dir = "data/default/";
	$n = "teams_list.txt";
	
	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td><span class=\"note\">choose team: </span></td><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose team...</option>";
	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[1])) {echo "<option SELECTED value=\"sc.php?id=$id&team=".trim($tmp[1])."\">".trim($tmp[0])."</option>";}
			else {echo "<option value=\"sc.php?id=$id&team=".trim($tmp[1]); 
			if (Isset($detail)) {echo "&detail=$detail";}
			echo "\">".trim($tmp[0])."</option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</select></td></tr></table><br /><br />";

}	
	

/*preklikavanie na detail stats*/
function parsetype ($team, $detail) {global $team, $detail;
	
	echo "<form>";
	echo "<br /><table align=\"center\"><tr><td width=\"33%\">";
	echo "<input type=\"radio\" ";
	if ($detail=="stats_points") {echo "checked=\"checked\"";}
	echo "name=\"type\" value=\"sc.php?id=teams.php&team=$team&detail=stats_points\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;Top players</span></td><td width=\"33%\">";
	echo "<input type=\"radio\" ";
	if ($detail=="stats_goalies") {echo " checked=\"checked\"";}
	echo "name=\"type\" value=\"sc.php?id=teams.php&team=$team&detail=stats_goalies\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;Top Goalies</span></td><td width=\"33%\">";
	echo "<input type=\"radio\" ";
	if (($detail=="none") || !Isset($detail)) {echo " checked=\"checked\"";}
	echo "name=\"type\" value=\"sc.php?id=teams.php&team=$team\" onclick=\"document.location.href=value;\"><span class=\"note\">&nbsp;Team page</span>";
	echo "</td></tr></table>";
	echo "</form>";
	
}

function parsecaptain ($team, $hilight, $div) {

    $upload = "data/teams/teams_details.txt";
    $z = 1;
    if($team == "all") {echo "<table width=\"95%\" class=\"sort-table\" align=\"center\"><tr><th colspan=\"2\">team</th><th align=\"center\">Captain</th><th align=\"center\">1st Asistent</th><th align=\"center\">2nd Asistent</th></tr><tr>";} else {
    echo "<table width=\"95%\" class=\"awards\" align=\"center\"><tr><td align=\"center\"><b>Captain</b></td><td align=\"center\"><b>1st Asistent</b></td><td align=\"center\"><b>2nd Asistent</b></td></tr><tr>";}
    if(File_exists($upload)) {
        $f = fopen($upload,"r");
    	while(!feof($f)) {
    		$tmp = explode("|",fgets($f,2000));
    		if (trim($tmp[0]) !== "") {
    		  if(($team == $tmp[0])) {
                if($tmp[9] !== "-") {
                $name = $tmp[9];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[9] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[9]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}
                if($tmp[10] !== "-") {
                $name = $tmp[10];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[10] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[10]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}
                if($tmp[11] !== "-") {
                $name = $tmp[11];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[11] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[11]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}		      
    		  }
              if(($div[0] == "all") || ($div[0] != "select") && ($team == "all")) {
                $team_name = $tmp[0];
                if(trim($tmp[0]) == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                echo "<td width=\"30px\" align=\"right\">";parseteamnamesearch($team_name); echo "</td>";
                if($tmp[9] !== "-") {
                $name = $tmp[9];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[9] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[9]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}
                if($tmp[10] !== "-") {
                $name = $tmp[10];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[10] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[10]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}
                if($tmp[11] !== "-") {
                $name = $tmp[11];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[11] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[11]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td></tr>\n";}
              }
                if(($div[0] != "all") && in_array($tmp[16], $div) && ($team == "all")){
                $team_name = $tmp[0];
                if(trim($tmp[0]) == $hilight) {echo "<tr class=\"hilight\">"; if($z==2) {$z = 1;} else {$z++;}} else {if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}}
                echo "<td width=\"30px\" align=\"right\">";parseteamnamesearch($team_name); echo "</td>";
                if($tmp[9] !== "-") {
                $name = $tmp[9];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[9] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[9]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}
                if($tmp[10] !== "-") {
                $name = $tmp[10];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[10] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[10]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td>\n";}
                if($tmp[11] !== "-") {
                $name = $tmp[11];
                echo "<td align=\"center\"><a rel=\"shadowbox;&amp;width=750;height=600;title=$tmp[11] - all time stats\" class=\"text1\" href=\"jquery.php?id=player_stats.php&amp;pos=points&amp;name="; parseplayer_link($name = $name); echo "\">" . trim($tmp[11]) . "</a></td>\n";} else {echo "<td align=\"center\"><i>Not assigned</i></td></tr>\n";}
              }
            }
        }
    }Fclose($f);
    echo "</tr></table>";
}



?>
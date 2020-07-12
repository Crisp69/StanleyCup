<?php	
if($include_check == "bXnqwa") {

if ((!IsSet($team)) || ($team == "") || ($team == "all")) {
	echo "<br />";include "data/teams.html";
	} 
else {
	include ("teams_function.php");
	/*zoznam timov*/
	parseteamslist_teams();
    $div = array($divs_select, $divs[1], $divs[2], $divs[3], $divs[4], $divs[5], $divs[6]); //pre kapitana

	/*hlavna cast*/ 
	parseteams($team); echo "<hr><br />"; parsecaptain ($team, $hilight, $div); echo "<hr>";

		if(!isset($detail) && ($detail !== "stats_points") && ($detail !== "stats_goalies") || ($detail == "")){
			echo "<center><div class=\"headline\">Stanley Cup History</div><br /></center>";
			
			/*historia*/
			include("teams_function_history.php");
			parseteamshistory($team); echo "<hr>";
			
			echo "<br />";
			echo "<center><div class=\"headline\">Players Stats</div><br /></center>";
			$type = "reg";
			include("teams_function_stats.php");
			/*stats - akt sezona*/
			parsestats($s = $current_season, $pos = "points", $type, $team = $team, $statscount = 5, $detail); echo "<br />";
			parsestats($s = $current_season, $pos = "goalies", $type, $team = $team, $statscount = 1, $detail); echo "<br />";
			
			/*stats - all time*/
			parsestats($s = "allstats", $pos = "points", $type, $team = $team, $statscount = 5, $detail); echo "<br />";
			parsestats($s = "allstats", $pos = "goalies", $type, $team = $team, $statscount = 1, $detail); echo "<span class=\"note\">goalie must play at least 22 games to be qualified</span>";
			echo "<hr>";
			echo "<br /><center>";
			
			/*trofeje*/
			include("teams_function_awards.php");
			parseawards($team);
			echo "</center>";
		}
		
		/*stats - all time - body*/	
		elseif ($detail == "stats_points") {
			/*detail stats*/
			parsetype($team = $team, $detail);
			echo "<center><div class=\"headline\">Players Stats</div><br /></center>";
			$type = "reg";
			include("teams_function_stats.php");
			parsestats($s = "allstats", $pos = "points", $type, $team = $team, $statscount = 100, $detail);echo "<br />";
		}
		
		/*stats - all time - brankari*/
		elseif ($detail == "stats_goalies") {
			/*detail stats*/
			parsetype($team = $team, $detail);
			echo "<center><div class=\"headline\">Players Stats</div><br /></center>";
			
			$type = "reg";
			include("teams_function_stats.php");
			parsestats($s = "allstats", $pos = "goalies", $type, $team = $team, $statscount = 100, $detail); echo "<span class=\"note\">goalie must play at least 22 games to be qualified</span>";
		}
	}
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
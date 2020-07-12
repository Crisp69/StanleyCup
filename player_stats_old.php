<?
if (!isset($pos)) {
	$pos = "points";
}

if (isset($name)) {
	include("player_stats_function_old.php");
	parsestats($pos = $pos, $type = "reg", $statscount = 1000, $name);
	parsestats($pos = $pos, $type = "po", $statscount = 1000, $name);
	echo "<br />";
	parseawards($name);
	}
else {
	echo "Error! No player selected";
	}

?>
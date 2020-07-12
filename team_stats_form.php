<?php

if($include_check == "bXnqwa") {

	include("data/magazine/pass.php");
	$nick_lower = strtolower($nick);
	
	if (($password !== $password_main[$nick_lower]) || ((trim($nick)) == "")&& (($nick !=="sollu") || ($nick !== ""))) {
	echo "<p><form name=\"pass\" method=\"post\" >	
	HA nick:<br />
	<input type=\"text\" class=\"list\" name=\"nick\" ";
	if ($nick !== "") {echo "value=\"$nick\"";}
	echo " size=\"25\" /><p>
	password:<br />
	<input type=\"password\" class=\"list\" name=\"password\"";
	if ($password !== "") {echo "value=\"$password\"";}
	echo " size=\"25\" />
	<p>
	<input type=\"submit\" class=\"date\" value=\"-- LOGIN --\" />
	</form>
	<p>
	";}
	
	else {
		$nick = $nick;
		$password_main[$nick_lower] = $password_main[$nick_lower];
	/*
	echo "<table width=\"97%\"><tr><td valign=\"top\">";
	echo "<div class=\"headline\">Hello $nick!<p></div>";
	echo "<form name=\"input\" method=\"post\" action=\"sc.php?id=team_stats_submit.php\">

	<textarea type=\"text\" class=\"list\" name=\"text\" cols=\"80\" rows=\"20\" />";
	$text = Str_Replace("\t", "|", $text);
	echo "$text";
	echo "</textarea><p>
	
	<input type=\"hidden\" name=\"nick\" value=\"$nick\">
	<input type=\"hidden\" name=\"password\" value=\"$password\">
	<input type=\"hidden\" name=\"send\" value=\"ok\">
	<input type=\"submit\" class=\"date\" value=\"-- SUMBIT --\" />
	</form>
	<p></td>
	";
	echo "</td>";
	echo "</tr></table>";*/
	echo "teams stats update running automatically now";
	}
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}


?>

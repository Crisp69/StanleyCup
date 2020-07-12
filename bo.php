<!--

<div class="headline">TEST version 1.3.0</div>
<div class="note1">
<table width="95%">
<tr>
<td width="50%"><span class="note1">to-do:</span></td>
<td width="50%"><span class="note1">done:</span></td>
</tr>
<tr>
<td valign="top"><span class="note1">
<b>- GO LIVE on 22/02/2010</b> (if there will be no problem with PO games...)<br /> 


</span></td>
<td valign="top"><span class="note1">
- 1.3.0 - session/cookie for returning to page w/out login<br />
- 1.2.1 - short table of betting leaders on main page (now on BO page only)<br />
- 1.2.0 - automatic calculation running correctly<br />
- 1.1.2 - link on match report on HA to ticket<br />
- 1.1.1 - automatic calculation enhanced<br />
- 1.1.0 - sending password to HA mail in test<br />
- 1.0.2 - automatic calculation - almost perfect<br />
- 1.0.2 - daily and total tickets review enhanced<br />
- 1.0.1 - error on submit corrected<br />
- 1.0.1 - new error on submit corrected<br />

</span></td>
</tr>
</table>
<br />
</div>
-->
<?
function parseseasonlist_betting() {global $s, $current_season;
	$upload_dir = "data/default/";
	$n = "season.txt";

	$c = 0;
	echo "<table align=\"right\">";
	echo "<tr><td>&nbsp;<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">choose season...</option>";

	$f = fopen($upload_dir.$n,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if (($tmp[0] == "01") || ($tmp[0] == "02") || ($tmp[0] == "03") || ($tmp[0] == "04") || ($tmp[0] == "05") || ($tmp[0] == "06") || ($tmp[0] == "07") || ($tmp[0] == "08") || ($tmp[0] == "09") || ($tmp[0] == "10") || ($tmp[0] == "11") || ($tmp[0] == "12") || ($tmp[0] == "13") || ($tmp[0] == "14") || ($tmp[0] == "15") || ($tmp[0] == "16") || ($tmp[0] == "17") || ($tmp[0] == "18")) {echo "";} else {
			echo "<option value=\"sc.php?id=bo.php&s=".trim($tmp[0])."\">".trim($tmp[0]).". season </option>";}
			$c++;
		}
	}
	fclose($f);
	echo "</tr></table><br />";
}
?>
<?php
if($include_check == "bXnqwa") {
    
    echo "<div class=\"text\"><br /><b>: Stanley Cup - Betting office</b></div><br />";
    include ("data/pass/pass.php");
    parseseasonlist_betting();
    if(!isset($s)) {$s = $current_season;}
    
    	$nick_lower = strtolower($nick);
    	
    	if (($password != $password_main[$nick_lower]) || (trim($nick)) == "") {
        include("login_script.php");
            if($s==$current_season) {
    		echo "<hr><div class=\"note\"><b>help:</b><br /><br />you are betting on each match separately. for successful bet you gain 1 point, for successful bet on a tie game you gain 2 points. you lose 0.5 point for every unsuccessful bet. you can change your bet by submitting the same match with different bet again.</div>";
    
            echo "<br />";
            include("bo_list.php");
            
            parseschedule_bet($s, $type, $team, $nick, $continue = "none");
            }
            else {echo "<br />";}
        }
        else {
            	echo "<div class=\"headline\">Hello $nick!<p></div>";        
                include("bo_list.php");
                parseschedule_bet($s, $type, $team = $team_short[$nick], $nick, $continue = "ok");
                }
                
            
    echo "<hr><br />";
    include("bo_total_standings.php");
      
    parse_bo_total ($s);
    echo "<br />";
    if($s == $current_season) {
    parse_bo_last_round ($s);echo "</td>";}
    

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
    
?>
<?php
if($include_check == "bXnqwa") {
    echo "<b>: betting office - confirm your tickets</b><br /><br /><br />";
    if($continue == "yes") {
        if(Isset($nick)) {
            if(Isset($match)) {
            echo "<center><form name=\"ticket\" method=\"post\" action=\"sc.php?id=bo_submit.php\">"; 
            echo "<table align=\"center\"><tr>";
            $nrows = count($match);
            $i = 1;
            foreach ($_POST['date'] as $submits) {
                if($submit != "a") {
                    
                echo"<td align=\"center\" width=\"210px\"><div class=\"hilite\"><span class=\"hilite\">". str_replace(";","-",$submits)."</span></div><textarea class=\"readonly\" readonly=\"readonly\" name=\"aaa[$i]\" cols=\"25\" rows=\"15\">";
                
                foreach($_POST['match'] as $submit) {
                			$tmp = explode("|", $submit);
                            	if($submits == $tmp[0]){echo str_replace(";","-",$submits)."|".trim($tmp[1])."|".$tmp[2]."|".$tmp[3]."|\n";}
                }$i++;
                echo "</textarea></td><td></td>";
                }
            }
            
            echo "</tr></table><input type=\"hidden\" name=\"continue\" value=\"yes\">\n<br /><br /><input type=\"submit\" class=\"button\" value=\"-- CONFIRM --\">";
            
            echo "</form><br /><form name=\"back\" method=\"post\" action=\"sc.php?id=bo.php\"><input type=\"hidden\" name=\"nick\" value=\"$nick\"><input type=\"hidden\" name=\"continue\" value=\"yes\">\n<input type=\"submit\" class=\"button\" value=\"-- RESET --\"></form></center>";
            }
            else {echo "invalid input!<br /><br />please try again <a href=\"sc.php?id=bo.php\">here</a>";}
        } else {echo "You have been logged out due to innactivity!<br /><br />please try again <a href=\"sc.php?id=bo.php\">here</a>";}
    } else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=bo.php\">";}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
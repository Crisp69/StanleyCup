<?php
if($include_check == "bXnqwa") {

    if($ok !=="ok") {
            echo "<b>: lost password form</b><br /><br />Type your nick and calculate antispam below. Your Stanley Cup password will be sent to your HA mail automatically.<br /><br /><b>Please do not leave this page, until you are redirected to your HA inbox!!!</b><br /><br />";
            echo "<form name=\"pass\" method=\"post\" target=\"_blank\" action=\"sc.php?id=lost_pass_login.php\"><table width=\"55%\"><tr><td>";
            echo "HA nick:</td>";
            echo "<td><input type=\"text\" class=\"list\" name=\"nick\" ";
            if ($nick !== "") {echo "value=\"$nick\"";}
            echo " size=\"25\" /></td></tr>";
            echo "<tr><td>";
            $aa = rand(1,5);
    		$bb = rand(1,5);
    		$cc = $aa + $bb;
    		echo "<script type=\"text/javascript\"><!--
    		document.write(\"count: $aa plus $bb =</td><td><input type='text' class='list' name='dd' size='2' />&nbsp;\")//--></script>
    		<input type=\"hidden\" name=\"d\" value=\"$cc\"></td></tr>";
            echo "<input type=\"hidden\" name=\"ok\" value=\"ok\"></td></tr>";
            echo "<tr><td>&nbsp;</td><td valign=\"bottom\">";
            echo "<script type=\"text/javascript\"><!--
    		document.write(\"<input type='submit' class='button' value='-- SEND PASSWORD --' />\")//--></script>
        	</td></tr></table></form><br />";
            echo "<noscript><span class='mag_title_new'>You have to enable JavaScript to continue!</span></noscript>";
    }

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
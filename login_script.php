<SCRIPT LANGUAGE="JavaScript" type="text/javascript"><!--
function check(formular)
{
	
	if (formular.nick.value=="")
    {
        alert("type your nick!");
        formular.nick.focus();
        return false;
    }
    else if (formular.password.value=="")
    {
        alert("type your password!");
        formular.password.focus();
        return false;
    }
    else 
        return true;
}
// -->
</SCRIPT>
<?php
if($include_check == "bXnqwa") {

    echo "<form name=\"pass\" method=\"post\" onSubmit=\"return check(this)\" action=\"sc.php?id=login.php\"><table width=\"70%\"><tr><td width=\"33%\">";
    echo "HA nick:</td><td>";
    echo "SC password:</td><td>&nbsp;</td></tr><tr>";
    echo "<td><input type=\"text\" class=\"list\" name=\"nick\" ";
    if ($nick !== "") {echo "value=\"$nick\"";}
    echo " size=\"25\" /></td>";
    echo "<td width=\"33%\"><input type=\"password\" class=\"list\" name=\"password\"";
    if ($password !== "") {echo "value=\"$password\"";}
    echo " size=\"25\" /></td>";
    echo "<td width=\"33%\"><a href=\"sc.php?id=lost_pass.php\" class=\"note1\">lost password?</a></td></tr>";
    echo "<tr><td><input type=\"checkbox\" name=\"login_remember\" /> <span class=\"note\">remember for 14 days</span></td>";
    echo "<td align=\"center\" valign=\"bottom\" width=\"110px\">
    <input type=\"submit\" class=\"button\" value=\"-- LOGIN --\" /></form></td><td>&nbsp;</td>";
    echo "</tr></table>";

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
    
?>

<?php
if($include_check == "bXnqwa") {
	include ("data/pass/pass.php");
	$nick_lower = strtolower($nick);
    	$orig_page1 = $_SERVER['HTTP_REFERER'];
	if (($nick != "") && isset($password) && ($password != "") && ($password == $password_main[$nick_lower])) {
        $orig_page = $_SERVER['HTTP_REFERER'];
        //echo $orig_page;
        if(($orig_page != "http://stanleycup.crash.sk/sc.php?id=logout.php") && ($orig_page != "http://stanleycup.crash.sk/sc.php?id=login.php")) {
        echo "<META HTTP-EQUIV=Refresh CONTENT=\"0 URL=$orig_page\">";} else {echo "<META HTTP-EQUIV=Refresh CONTENT=\"0 URL=sc.php\">";}
    }
    elseif(!isset($nick) && !isset($password)) {
        include ("login_script.php");
    }
    else {if(!isset($nick) || !isset($password) || ($nick == "") || ($password == "")) {
        include ("login_script.php");
    }echo "<hr>unsuccessful login!!! <a href=\"sc.php?id=lost_pass.php\" >lost password?</a><br /><br />please make sure, that you have cookies and javascript enabled on your browser!<br /><br />only Stanley Cup managers can access this page!<br /><br />-> <a href=\"$orig_page1\" >back</a>";
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}
        
?>
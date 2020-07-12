
<?php

if($include_check == "bXnqwa") {
    if (isset($nick)) {
    $orig_page = $_SERVER['HTTP_REFERER'];parselogout_main($nick);
    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; \">";}
    else {echo "you were logged out successfully!<br /><br /><hr>";include("login_script.php");}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
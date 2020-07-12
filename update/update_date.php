<?php
//echo mktime(22, 00, 00, date("m")  , date("d"), date("Y"))."<br/>";
//echo time();

if(mktime(22, 00, 00, date("m")  , date("d"), date("Y")) < (time())) {
    $tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y")); echo "<span class=\"note\">update: ".date("d.m.Y", $tmp_yesterday)."</span><br /><br />";}
    else {$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d")-4, date("Y")); echo "<span class=\"note\">update: ".date("d.m.Y", $tmp_yesterday)."</span><br /><br />";}


//$tmp_yesterday = mktime(0, 0, 0, 2  , 29, date("Y"));

?>
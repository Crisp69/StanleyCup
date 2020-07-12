<?php
function randomstring() {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $string  = $chars{ rand(0,62) };
        for($i=1;$i<40;$i++){
            $string .= $chars{rand(0,62)};
        }
    return($string); 
}

include ("data/pass/pass.php");
$nick_lower = strtolower($nick);
	
	if (($nick != "") && isset($password) && ($password != "") && ($password == $password_main[$nick_lower])) {
        
        $string_login = $nick."|".randomstring()."|14|";
        if($login_remember == "on") {$expire=time()+60*60*14*24;$end_login=14;} else {$expire=time()+60*30;$end_login=0;}
        $string_login = $nick."|".randomstring()."|".$end_login."|";
        setcookie("login_session", $string_login, $expire);
        $fp_login = FOpen ("_tmp/".$nick.".php", "w");
        	FWrite ($fp_login, "<? \$l_session[\"".$nick."\"] = \"".$string_login."\";?>");
        	FClose ($fp_login);
            if(!isset($_COOKIE["SC_highlighter"])) {
                $hilight = $team_short[$nick_lower];
                include("_setcookie_highlighter.php");
            }
    }
    
    if(isset($_COOKIE["login_session"])) {
        $tmp_login = explode("|", $_COOKIE["login_session"]);
        if(file_exists("_tmp/".$tmp_login[0].".php")) {
            include ("_tmp/".$tmp_login[0].".php");
            if(trim($_COOKIE["login_session"]) == trim($l_session[$tmp_login[0]])) {
                if($tmp_login[2] == "14") {$expire=time()+60*60*14*24;} else {$expire=time()+60*30;}
                setcookie("login_session", $_COOKIE["login_session"], $expire);
                $nick = $tmp_login[0]; $password = $password_main[strtolower($tmp_login[0])];
            }
        }
    }
    

?>
<?php


    if(!isset($hilight) || $hilight == "") {    
        if(isset($_COOKIE["SC_highlighter"])) {
            $hilight = $_COOKIE["SC_highlighter"];
        }
    }
    
    if(($hilight == "atl")) {$hilight = "wpg";}

    if(isset($hilight) && ($hilight !== "")) {
        $expire=time()+60*60*24*70;
        setcookie("SC_highlighter", $hilight, $expire);
        
    }


?>
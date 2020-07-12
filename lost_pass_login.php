<?
function parse_login() {
    $upload_dir = ($_SERVER['DOCUMENT_ROOT']);
        
        $cookie_file = "update/tmp/cookie/cookie.txt";
        if (!file_exists($cookie_file)) {$fp_cookie_file = FOpen ($cookie_file, "w"); FClose ($fp_cookie_file);}
        
        //prefix = "http://beta.hockeyarena.net/en";
        $prefix = "http://www.hockeyarena.net/en";
        
        $user_id = "sollu"; 
        $user_password = "badams";
        $my_team = "9441";
        
        $url = "$prefix/index.php?p=security_log.php";
        
        $LOGINURL = "$url";
        $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (affgrabber)";
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$LOGINURL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_VERBOSE, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, "$cookie_file");
        curl_setopt($ch, CURLOPT_COOKIEJAR, "$cookie_file");
        $result = curl_exec ($ch);
        curl_close ($ch);
        
        // post the login data 
        
        $LOGINURL = "$url";
        $POSTFIELDS = "&nick=". $user_id ."&password=". $user_password;
        
        // debugging
        //echo $LOGINURL.$POSTFIELDS;
        
        // not sure if this isneeded...
        
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$LOGINURL);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTFIELDS); 
        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1); 
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANYSAFE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // uncommenting the two below will give you debugging info...
        //    curl_setopt($ch, CURLOPT_HEADER, 1);
        //    curl_setopt($ch, CURLOPT_VERBOSE, 1); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        
        $result = curl_exec ($ch);
        curl_close ($ch); 
}

?>

<?php

if($include_check == "bXnqwa") {

    if(isset($_POST['nick']) && ($_POST['ok'] == "ok") && ($_POST['nick'] !="")) {
        if($_POST['dd'] == $d) {
                  
    
    
            $file = "data/teams/teams.txt";
            if(file_exists($file)) {
                $f = fopen($file, "r");
                while (!feof($f)) {
                    $tmp = explode("|", fgets($f, 2000));
                    if($tmp[0] !="") {
                        $nick_check = $tmp[4];
                        $nicks[] = $nick_check; 
                    }
                }
                if(in_array($nick, $nicks)) {
                    parse_login();
                    echo "please wait, password sending in progress";  
                    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=sc.php?id=lost_pass_snd.php&login=true&manager=$nick\">";
                    
                }
                else {echo "only Stanley Cup managers can access this page!<br /><a href=\"sc.php?id=reg.php\">registration</a>";}
            }
        }
        else {echo "calculate antispam correctly! <a href=\"sc.php?id=lost_pass.php\">back</a>"; }
        
    } elseif(($nick =="") && ($ok == "ok")) {echo "type your nick correctly!!! <a href=\"sc.php?id=lost_pass.php\">back</a>";}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
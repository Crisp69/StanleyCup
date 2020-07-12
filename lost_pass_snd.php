<?php
function parse_send($nick, $text) {
    $upload_dir = ($_SERVER['DOCUMENT_ROOT']);
        
        $cookie_file = "update/tmp/cookie/cookie.txt";
        if (!file_exists($cookie_file)) {$fp_cookie_file = FOpen ($cookie_file, "w"); FClose ($fp_cookie_file);}
        
        //prefix = "http://beta.hockeyarena.net/en";
        $prefix = "http://www.hockeyarena.net/en";
        
        $user_id = "sollu"; 
        $user_password = "badams";
        $my_team = "9441";
        
        $url = "$prefix/index.php?p=manager_mail_new_mail_sql.php";
        
        $LOGINURL = "$url";
        $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (affgrabber)";
        /*$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$LOGINURL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_VERBOSE, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, "$cookie_file");
        curl_setopt($ch, CURLOPT_COOKIEJAR, "$cookie_file");
        $result = curl_exec ($ch);
        curl_close ($ch);
        */
        // post the login data 
        
        $LOGINURL = "$url";
        $POSTFIELDS = "&whom=".$nick."&text=". $text ."&subject=Stanley Cup password&return_url=";
        
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
        //echo $result;
}
?>

<?

if($include_check == "bXnqwa") {

    if(isset($manager) && ($login == "true")) {
        $IP = $_SERVER['REMOTE_ADDR'];
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
                if(in_array($manager, $nicks)) {
                    $nick = $manager;
                    $psw_file = "data/pass/pass.php"; 
                    include ($psw_file);
                    if($nick !=="") {
                        $nick_lower = strtolower($nick);
                        if(!isset($password_main[$nick_lower])) {
                            $length = 6;
                    		$letters = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM12345678901234567890";
                    		$s = "";
                    		$lettersLength = strlen($letters)-1;
                    		for($i = 0 ; $i < $length ; $i++)
                    			{$s .= $letters[rand(0,$lettersLength)];}
                    		
                    		$password_main[$nick_lower] = $s; 
                    		$team_short[$nick_lower] = $team;
                    		
                    					$write = "<?\$password_main[".$nick_lower."] = \"".$s."\";\$team_short[".$nick_lower."] = \"".$team."\";?>\n";
                                        //chmod($psw_file, 777);
                    					
                    					if ((File_Exists($psw_file)) && (Count(File($psw_file))!==0)) {
                    							$fp_psw_file = FOpen ($psw_file, "r");
                    							$data_psw_file = FRead ($fp_psw_file, FileSize($psw_file));
                    							FClose($fp_psw_file); }
                    							$fp_psw_file = FOpen ($psw_file, "w");
                    							FWrite ($fp_psw_file, $write.$data_psw_file);
                    							FClose ($fp_psw_file);
                                        //chmod($psw_file, 604);
                        	}
                            if(isset($password_main[$nick_lower])) {
                                $text = "Your Stanley Cup credentials are:\n\n nick: $nick\n password: $password_main[$nick_lower]\n\n\nthis message was sent to you based on your reguest at Stanley Cup page. If you did not ask for sending a password to you, somebody requested password for your nick, and this password was sent to your HA mail only.\n\n this request came from IP: $IP\n\n\nsollu\nwww.stanleycup.crash.sk";
    
                                parse_send($nick, $text);
                                echo "password sent to your HA mail, you are being redirected, please wait";
                                echo "<br /><br />if redirect does not work, click <a href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail.php\">here</a>";
                                
                                $login = "redirect";
                                if ($login=="redirect") {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=http://www.hockeyarena.net/sk/index.php?p=manager_mail.php\">";}
                    
                            }
                    }
                    
                }else {echo "only Stanley Cup managers can access Stanley Cup ballot!<br /><a href=\"sc.php?id=reg.php\">registration</a>";}
            }
        
    } elseif(!isset($nick) || ($nick =="") || ($login !=="true")) {echo "an error occured, please try again: <a href=\"sc.php?id=lost_pass.php\">back</a>";}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
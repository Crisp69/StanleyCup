<?php

$upload_dir = ($_SERVER['DOCUMENT_ROOT']);


$cookie_file = "tmp/cookie/cookie.txt";
if (!file_exists($cookie_file)) {$fp_cookie_file = FOpen ($cookie_file, "w"); FClose ($fp_cookie_file);}

//prefix = "http://beta.hockeyarena.net/en";
$prefix = "http://www.hockeyarena.net/en";

$user_id = "nick"; 
$user_password = "password";
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
?>
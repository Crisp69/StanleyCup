<?php
########################################################################
# Edit-Point 4.00 Beta - Simple Content Management System
# Copyright (c)2005-2008 Todd Strattman
# strattman@gmail.com
# http://covertheweb.com/edit-point/
# License: LGPL
########################################################################
// Config.php is the main configuration file.
include('config.php');
// Password file.
if (is_file("$datadir/upload_pass.php")) {
include ("$datadir/upload_pass.php");
}
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}
// Password protection.
// Random string generator.
function randomstring($length){
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$string  = $chars{ rand(0,62) };
	for($i=1;$i<$length;$i++){
		$string .= $chars{ rand(0,62) };
	}
	return $string;
}
if ($password_protect == "on") {
	session_start();
	if(!empty($_POST['pass_hash_upload'])) {
		// Crypt, hash, and store password in session.
		$_SESSION['pass_hash_upload'] = crypt(md5($_POST['pass_hash_upload']), md5($_POST['pass_hash_upload']));
		// Crypt random string with random string seed for agent response.
		$string_agent = crypt($_SESSION['random'], $_SESSION['random']);
		// Hash crypted random string for random string response.
		$string_string = md5($string_agent);
		// Hash and concatenate md5/crypted random string and password hash posts.
		$string_response = md5($string_string . $_POST['pass_hash2']);
		// Concatenate agent and language.
		$agent_lang = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
		// Hash crypted agent/language concatenate with random string seed for check against post.
		$agent_response = md5(crypt(md5($agent_lang), $string_agent));
	// Check crypted pass against stored pass. Check random string and pass hashed concatenate against post. Check hashed and crypted agent/language concatenate against post.
	} if (($_SESSION['pass_hash_upload'] != $upload_password) || ($_POST['pass_string_hash'] != $string_response) || ($_POST['agenthash'] != $agent_response)) {
		// Otherwise, give login.

		// Set random string session.
		$_SESSION['random'] = randomstring(40);
		// Crypt random string with random string seed.
		$rand_string = crypt($_SESSION['random'], $_SESSION['random']);
		// Concatenate agent and language.
		$agent_lang = getenv('HTTP_USER_AGENT').getenv('HTTP_ACCEPT_LANGUAGE');
		// Crypt agent and language with random string seed for form submission.
		$agent = crypt(md5($agent_lang), $rand_string);
		// Form md5 and encrypt javascript.
		echo "$p
		<b>$l_global13</b>
		$p2
		<script language=\"JavaScript\" type=\"text/javascript\" src=\"jscripts/crypt/sha256.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\" src=\"jscripts/crypt/md5.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\">
		function obfuscate() {
			document.form1.pass_hash_upload.value = hex_sha256(document.form1.pass_upload.value);
			document.form1.pass_hash2.value = hex_md5(document.form1.pass_upload.value);
			document.form1.string_hash.value = hex_md5(document.form1.string.value);
			document.form1.pass_string_hash.value =  hex_md5(document.form1.string_hash.value  + document.form1.pass_hash2.value);
			document.form1.agenthash.value = hex_md5(document.form1.agent.value);
			document.form1.pass_upload.value = \"\";
			document.form1.string.value = \"\";
			document.form1.agent.value = \"\";
			document.form1.jscript.value = \"on\";
			return true;
		}
		</script>
		<form action=\"edit.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
		$p
		<input name=\"jscript\" type=\"hidden\" value=\"off\" />
		<input name=\"pass_hash_upload\" type=\"hidden\" value=\"\" />
		<input name=\"pass_hash2\" type=\"hidden\" value=\"\" />
		<input name=\"string_hash\" type=\"hidden\" value=\"\" />
		<input name=\"pass_string_hash\" type=\"hidden\" value=\"\" />
		<input name=\"agenthash\" type=\"hidden\" value=\"\" />
		<input name=\"string\" type=\"hidden\" value=\"$rand_string\" />
		<input name=\"agent\" type=\"hidden\" value=\"$agent\" />
		<input type=\"password\" name=\"pass_upload\" />
		<input type=\"submit\" value=\"$l_global14\" />
		$p2
		</form>";
		exit();
	}
} else {
}
// End password protection.

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>STANLEY CUP - HockeyArena.net Tournament</title>
<?include("header.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=Utf-8" >
</head>
<body>
<div class="text">


<?

echo "<center>";

echo "<form name=\"file\" method=\"post\" >\n";

echo "<table >";
echo "<tr><td>file:&nbsp;</td><td><input type=\"text\" class=\"list\" name=\"file\" size=\"40\" ";
	if ($file !== "") {echo "value=\"$file\"";}
	echo "/>&nbsp;</td>";
echo "<td>password:&nbsp;</td><td><input type=\"text\" class=\"list\" name=\"pass\"";
	if ($password !== "") {echo "value=\"$pass\"";}
	echo " size=\"25\" />&nbsp;";
echo "</td><td>&nbsp;
	<input type=\"submit\" class=\"date\" value=\"-- RUN --\" />
	</form><p></td></tr></table><br />"; 
    
if (((($pass == "svatos") && ($file == "data/teams/teams_list_stats.txt")) || (($pass == "bonjovi") && ($file !== ""))) && ($continue1 !== "yes")) {
    echo "<form name=\"edit\" method=\"post\">\n
    <textarea type=\"text\" class=\"list\" name=\"text\" cols=\"120\" rows=\"35\" />";
    
    $file_edit = $_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file;
    if (file_exists($file_edit)) {
        $f = fopen($file_edit,"r");
        while(!feof($f)) {
        $tmp = fgets($f,2000);
            echo $tmp;
        }
    }
    echo "</textarea>";
   	echo "<input type=\"hidden\" name=\"continue1\" value=\"yes\">";
    echo "<input type=\"hidden\" name=\"file\" value=\"$file\">";
    echo "<input type=\"hidden\" name=\"pass\" value=\"$pass\">";
	echo "<br /><br /><input type=\"submit\" class=\"date\" value=\"-- WRITE --\" />";
    echo "</form>";
    
}

if (((($pass == "svatos") && ($file == "data/teams/teams_list_stats.txt")) || (($pass == "bonjovi") && ($file !== ""))) && ($continue1 == "yes")) {
    echo "<textarea type=\"text\" class=\"list\" name=\"text\" cols=\"120\" rows=\"35\" />";
    echo "$text";
    echo "</textarea>";
    
    	if ((File_Exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file)) && (Count(File($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file))!==0)) {
    	$fp_old = FOpen ($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file, "r");
    	$data_old = FRead ($fp_old, FileSize($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file));
    	FClose($fp_old); 
        $file_backup = $file."_backup.txt";
        $fp_old = FOpen ($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file_backup, "w");
    	FWrite ($fp_old, $data_old);
    	FClose ($fp_old);} 
        
                
    unlink($_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file);
    
    $file_write = $_SERVER['DOCUMENT_ROOT']."/stanleycup/".$file;
	$write = StripSlashes($text);
			$fp = FOpen ($file_write, "w");
			FWrite ($fp, $write);
			FClose ($fp);

}
echo "</center>";
?>

</div>
</body>
</html>

<?
include("settings.php");
include("header.php");
?>
<div id="page"><!--<div class="tdmain">-->
<?
$time = time();
$current_time = date("H:i:s d.m.Y", $time);

$IP = $_SERVER['REMOTE_ADDR'];
if (($IP == "127.0.0.1") || ($IP == "188.167.89.135") || ($IP == "212.5.222.203") || ($IP == "212.5.222.197") || ($IP == "212.5.222.203")) {
	$upload_dir_log = "data/_log/";
	if (!isset($id_log)) {$id_log = "log.txt";}
	$z = 1;
	$f2_log = $id_log;
	echo "<br />$current_time<br />";
	echo "<table align=\"center\"><tr><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">&nbsp;choose file...</option>";
	


	$dir_handle = opendir($upload_dir_log);
	if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir_log/$file";
		if (((is_file($upload_files)) && ($file!=".htaccess"))) {
			$upload_name_sort[] = $file;
		}
	}
	arsort($upload_name_sort);
	foreach ($upload_name_sort as $file) echo "
	

	<option value=\"log.php?id_log=$file\">$file</option>
	";
	}
	closedir($dir_handle);
	echo "</select></td></tr><tr><td align=\"center\">";
	echo "<form name=\"refresh\" method=\"post\" action=\"log.php\"><input type=\"hidden\" name=\"id_log\" value=\"$id_log\"><input type=\"submit\" class=\"date\" value=\"-- REFRESH --\" /></form></td></tr></table>";
	echo "<table width=\"95%\" align=\"center\"><tr><td align=\"center\" width=\"33%\"><a target=\"_blank\" href=\"msg.php\">message send</a></td><td align=\"center\" width=\"33%\"><a target=\"_blank\" href=\"admin/upload.php\">admin</a></td><td align=\"center\" width=\"33%\"><a target=\"_blank\" href=\"update/upload.php\">update</a></td></tr></table>";
	if (file_exists("$upload_dir_log$f2_log")) {
	$x = File ($upload_dir_log.$f2_log);
	$f = fopen($upload_dir_log.$f2_log,"r");
		echo "<br /><table class=\"overview\" align=\"center\">\n";
	echo "<tr><th >date</th><th>IP</th><th >page</th><th >browser</th><th>ban</th></tr>";

	$c = 1;
		while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) != "") {
				if(trim($tmp[3]) == "chuj") {echo "";} else {
				if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
			echo "<td align=\"left\" width=\"17%\">$c. $tmp[0]</td><td width=\"12%\" align=\"center\"><a target=\"_blank\" class=\"text\" href=\"http://www.hockeyarena.net/sk/index.php?p=gm_ip_info.php&ip=$tmp[1]\">$tmp[1]</a><br /><a target=\"_blank\" class=\"note\" href=\"http://whois.domaintools.com/$tmp[1]\">who is</a>&nbsp;&nbsp;<a target=\"_blank\" class=\"note\" href=\"http://www.stopforumspam.com/search?q=$tmp[1]\">spam</a></td><td colspan=\"2\" align=\"left\"><a class=\"text\" target=\"_blank\" href=\"sc.php?id=$tmp[2]$tmp[3]\">sc.php?id=$tmp[2]$tmp[3]</a>"; if (Isset($tmp[6]) && (trim($tmp[6]) != "") && ((trim($tmp[6]) != "none -") && (trim($tmp[6]) != "none - all"))) {echo " || $tmp[6]";} echo "<br />";
			if ((trim($tmp[5]) == "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)") && ($tmp[1] != "195.168.239.201")) {echo "<span class=\"notered\">$tmp[5]</a></td>";} elseif($tmp[1] == "195.168.239.201") {echo "<span class=\"note\">$tmp[5]</a> - toto je lordik!!!</td>";}  else {echo "<span class=\"note\">$tmp[5]</a></td>";}
			$ip_banned = $tmp[1];
			$ip_ban ="block/ip_ban.php";
			$ip_check = fopen($ip_ban, "r");
			$contents_ban = fread($ip_check, filesize($ip_ban));
	
			if(stristr($contents_ban,$ip_banned) !== false) {echo "<td></td></tr>";} else {
			echo "<td><form method=\"post\" name=\"ban\"><input type=\"hidden\" name=\"ok\" value=\"ok\"><input type=\"hidden\" name=\"ban\" value=\"$tmp[1]\">\n<input type=\"submit\" class=\"date\" value=\"- BAN -\"/></form></td></tr>
			
			";}
			}
			}$c++; 
		}fclose($f); 
}echo "</table><br /><br />";
if ($ok == "ok") {
	$write = "<? //".$ban."?>\n";
	

	$ban_file = "block/ip_ban.php";
	
	if ((File_Exists($ban_file)) && (Count(File($ban_file))!==0)) {
			$fp_ban_file = FOpen ($ban_file, "r");
			$data = FRead ($fp_ban_file, FileSize($ban_file));
			FClose($fp_ban_file); }
		
		
			$fp_write_ban_file = FOpen ($ban_file, "w");
			FWrite ($fp_write_ban_file, $write.$data);
			FClose ($fp_write_ban_file);
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=log.php?id_log=$id_log\">";
	
}



}

else {
	$upload_dir_log = "data/_log/";
	if (!isset($id_log)) {$id_log = "log.txt";}
	$z = 1;
	$f2_log = $id_log;

	echo "<table align=\"center\"><tr><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">&nbsp;choose file...</option>";
	


	$dir_handle = opendir($upload_dir_log);
	if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir_log/$file";
		if (((is_file($upload_files)) && ($file!=".htaccess"))) {
			$upload_name_sort[] = $file;
		}
	}
	arsort($upload_name_sort);
	foreach ($upload_name_sort as $file) echo "
	

	<option value=\"log.php?id_log=$file\">$file</option>
	";
	}
	closedir($dir_handle);
	echo "</select></td></tr><tr><td align=\"center\">";
	echo "<form name=\"refresh\" method=\"post\" action=\"log.php\"><input type=\"hidden\" name=\"id_log\" value=\"$id_log\"><input type=\"submit\" class=\"date\" value=\"-- REFRESH --\" /></form></td></tr></table>";
	if (file_exists("$upload_dir_log$f2_log")) {
	$x = File ($upload_dir_log.$f2_log);
	$f = fopen($upload_dir_log.$f2_log,"r");
		echo "<br /><table class=\"overview\" align=\"center\">\n";
	echo "<tr><th >date</th><th>page</th></tr>";

	$c = 0;
		while(!feof($f)) {
			$tmp = explode("|",fgets($f,2000));
			if (trim($tmp[0]) !== "") {
				if(trim($tmp[3]) == "chuj") {echo "";} else {
				if ($z==2) {echo "<tr>"; $z=1;} else {echo "<tr class=\"even\">"; $z++;}
			echo "<td align=\"left\">$tmp[0]</td><td align=\"left\"><a class=\"text\" target=\"_blank\" href=\"sc.php?id=$tmp[2]$tmp[3]\">sc.php?id=$tmp[2]$tmp[3]</a></td></tr>
			";}
			}$c++; 
		}fclose($f); 
}echo "</table><br /><br />";




	


}
	echo "<table align=\"center\"><tr><td><select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">&nbsp;choose file...</option>";

	foreach ($upload_name_sort as $file) echo "
	

	<option value=\"log.php?id_log=$file\">$file</option>
	";
	$upload_dir_log = "data/_log/";
	closedir($dir_handle);
	echo "</select></td></tr><tr><td align=\"center\">";
	echo "<form name=\"refresh\" method=\"post\" action=\"log.php\"><input type=\"hidden\" name=\"id_log\" value=\"$id_log\"><input type=\"submit\" class=\"date\" value=\"-- REFRESH --\" /></form></td></tr></table>";


?>
<? $include_check = "bXnqwa"; include("tracker.php");?>

</div><!--</div>-->
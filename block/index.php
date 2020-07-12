<?php

$time_q = time();
$date_input_q = date("H:i:s d.m.Y", $time_q);
$IP = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];


$log_i = $date_input_q."|".$IP."|".$browser."\n";
$file_log = "_log/log.txt";
$write_log = $log_i;
if (($IP !== "127.0.0.1") && ($IP !== "185.216.253.148") && ($IP !== "212.5.222.197") && ($IP !== "212.5.222.203") && ($IP !== "66.249.65.99")) {
$size = Count(File($file_log));
if ($size > 1000) {
	$arch_time = time();
	$arch_time = date("Ymd_His", $arch_time);
	$file_log_arch = "_log/".$arch_time."_log.txt";
				$fp_log = FOpen ($file_log, "r");
				$data_log_arch = FRead ($fp_log, FileSize($file_log));
				FClose($fp_log); 
				$fp_log_arch = FOpen ($file_log_arch, "w");
				FWrite ($fp_log_arch, $data_log_arch);
				FClose ($fp_log_arch);
				unlink($file_log);
}

			if ((File_Exists($file_log)) && (Count(File($file_log))!==0)) {
				$fp_log = FOpen ($file_log, "r");
				$data_log = FRead ($fp_log, FileSize($file_log));
				FClose($fp_log); }
				$fp_log = FOpen ($file_log, "w");
				FWrite ($fp_log, $write_log.$data_log);
				FClose ($fp_log); 




}

$ban = $_SERVER['REMOTE_ADDR'];

$write = "<? //".$ban."?>\n";

$ban_file = "ip_ban.php";
		$ip_check = fopen($ban_file, "r");
		$contents_ban = fread($ip_check, filesize($ban_file));
		$IP = $_SERVER['REMOTE_ADDR'];
		$tmp_ip = explode(".",$IP);
		$IP_blok = $tmp_ip[0].".".$tmp_ip[1].".".$tmp_ip[2].".???";
		if((stristr($contents_ban,$IP) !== false) || ($IP_blok == "94.102.59.???") || ($IP_blok == "212.235.106.???") || ($IP_blok == "93.174.94.???") || ($IP_blok == "93.174.93.???")){	

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=http://stanleycup.crash.sk/ban.php\">";
	
	
}
else {
	
	if ((File_Exists($ban_file)) && (Count(File($ban_file))!==0)) {
			$fp_ban_file = FOpen ($ban_file, "r");
			$data = FRead ($fp_ban_file, FileSize($ban_file));
			FClose($fp_ban_file); }
		
		
			$fp_write_ban_file = FOpen ($ban_file, "w");
			FWrite ($fp_write_ban_file, $write.$data);
			FClose ($fp_write_ban_file);
			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=http://stanleycup.crash.sk/ban.php\">";
			}



?>
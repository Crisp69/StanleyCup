<?php
if($include_check == "bXnqwa") {

	if(IsSet($nick) && IsSet($text) && ($send == "ok")) {
	$IP = $_SERVER['REMOTE_ADDR'];
	$date_input = date("d.m.Y", $time);
    
    $magazine_file = "data/magazine/$edit_id.txt";
    $fa = fopen ($magazine_file,"r");
	while(!feof($fa)) {
    	$tmp = explode("|",fgets($fa,2000));
		if (trim($tmp[0]) != "") {
    	      $picture_input = trim($tmp[3]);
	    }
    }fclose($fa);
    
    
	//if ((trim($picture) !== "") && (trim($picture) !== "http://")) {$picture_input = "<img class=\"magazine\" align=\"left\" width=\"$width px\" alt=\"picture\" title=\"".trim($title)."\" src=\"".trim($picture)."\">";}
				
		
        $file = $magazine_file;
        $file_backup = "data/magazine/".$edit_id."_backup.txt";
		$write = StripSlashes(trim($title) ."|" . $date_input ."|". $nick ."|". $picture_input ."|". $text . "|". $IP ."\n");
			if ((File_Exists($file)) && (Count(File($file))!==0)) {
				$fp = FOpen ($file, "r");
				$data = FRead ($fp, FileSize($file));
				FClose($fp); }
                
                $fp_backup = FOpen ($file_backup, "w");
				FWrite ($fp_backup, $data);
				FClose ($fp_backup); 
		
				$fp = FOpen ($file, "w");
				FWrite ($fp, $write);
				FClose ($fp); 
				
	
	$mail = "sollu17@gmail.com";
	$message = "Title: ". $title."; Author: ".$nick. "; IP: " . $IP. "\n\n". trim($title) ."|" . $date_input ."|". $nick ."|". $picture_input ."|". $text . "|". $IP ;
	$header = "From: SC admin <admin@crash.sk>";
	mail($mail, "Stanley Cup Article", $message, $header);
	
	echo "<hr>";
	echo "<br /><center>Your article was added successfully<p>
	<form name=\"ok\" method=\"post\" action=\"sc.php?id=magazine.php\">
	<input type=\"submit\" class=\"date\" value=\"-- OK --\" />
	</form>
	
	</center>";}
	else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=magazine.php\">";}


}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
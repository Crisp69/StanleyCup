<?php

if($include_check == "bXnqwa") {

	if(IsSet($nick) && IsSet($text) && ($send == "ok")) {
	$IP = $_SERVER['REMOTE_ADDR'];
	$date_input = date("d.m.Y", $time);
	if ((trim($picture) !== "") && (trim($picture) !== "http://")) {$picture_input = "<img class=\"magazine\" align=\"left\" width=\"$width px\" alt=\"picture\" title=\"".trim($title)."\" src=\"".trim($picture)."\">";}
        
		$file_counter = "data/magazine/magazine.txt";
        if(file_exists($file_counter)) {$count = Count(file($file_counter))+1;} else {$count = 1;}
        
        if ($send == "ok") {$write_counter = stripslashes($count."|".$date_input."|".trim($title)."|".$nick."\n");
            if ((File_Exists($file_counter)) && (Count(File($file_counter))!==0)) {
				$fp_counter = FOpen ($file_counter, "r");
				$data_counter = FRead ($fp_counter, FileSize($file_counter));
				FClose($fp_counter); }
		
		
				$fp_counter = FOpen ($file_counter, "w");
				FWrite ($fp_counter, $write_counter.$data_counter);
				FClose ($fp_counter);
                
                $update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
                if (File_exists($update_file)) {
                	$old_update_file = FOpen($update_file, "r");
                	$data_old_update_file = FRead ($old_update_file, filesize($update_file));
                fclose($old_update_file);}
                $update_text = time()."|magazine|magazine.php&id_magazine=$count|\n";
                $yes_update_file = FOpen ($update_file, "w");
                FWrite ($yes_update_file, $update_text.$data_old_update_file);
                Fclose ($yes_update_file); 
        
        
        $file = "data/magazine/".$count.".txt";
		$write = StripSlashes(trim($title) ."|" . $date_input ."|". $nick ."|". $picture_input ."|". $text . "|". $IP ."\n");
			if ((File_Exists($file)) && (Count(File($file))!==0)) {
				$fp = FOpen ($file, "r");
				$data = FRead ($fp, FileSize($file));
				FClose($fp); }
		
		
				$fp = FOpen ($file, "w");
				FWrite ($fp, $write.$data);
				FClose ($fp); 
	   }
	$mail = "sollu17@gmail.com";
	$message = "Title: ". $title."; Author: ".$nick. "; IP: " . $IP. "\n\n". trim($title) ."|" . $date_input ."|". $nick ."|". $picture_input ."|". $text . "|". $IP ;
	$header = "From: SC admin <admin@crash.sk>";
	mail($mail, "Stanley Cup Article", $message, $header);
	
	echo "<hr>";
	echo "<br /><center>Your article was added successfully<p>
	<form name=\"ok\" method=\"post\" action=\"sc.php?id=magazine.php\">
	<input type=\"submit\" class=\"date\" value=\"-- OK --\" />
	</form>
	
	</center>";
    }
	else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=magazine.php\">";}

}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}


?>
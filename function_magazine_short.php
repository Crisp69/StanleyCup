<?php

function parsemagazine_short() {
	$upload_dir = "data/magazine";
	if (File_Exists($upload_dir."/magazine.txt")) {
	$magazine = file($upload_dir."/magazine.txt");
	$count = Count($magazine);
    
   	$z = 0;
    $f = fopen($upload_dir."/magazine.txt","r");
	while(!feof($f)) {
		$tmp_date = explode("|",fgets($f,10000));
		if (trim($tmp_date[0]) !== "") {$date = explode(".",trim($tmp_date[1]));
            if (mktime(0,0,0,$date[1],$date[0]+7,$date[2]) > (time())) {
                $z = $z + 1;
            }
        }
    }fclose($f);
    
    if($z > 3) {$z = $z-1;} else {$z = 2;}

	/*echo "<a class=\"mag\" href=\"sc.php?id=magazine.php\"><img title=\"Stanley Cup Magazine\" alt=\"Stanley Cup Magazine\" class=\"logo\" src=\"img/scmagazine2.jpg\"></a>";*/
	for ($i=0;$i<=$z;$i++) {
	   $c = 0;
		$tmp = explode("|",$magazine[$i]);
		if (trim($tmp[0]) != "") {$id_magazine = $count - $i;
        $article_file = "data/magazine/".$id_magazine.".txt"; 
    	    if(file_exists($article_file)) {
    	        $fa = fopen($article_file,"r");
             	while(!feof($fa)&& $c<=1) {
            		$tmp = explode("|",fgets($fa,10000));
                    if ($tmp[0] !=="") {
                			$nick = strtolower(trim($tmp[2]));
                			$date = explode(".",$tmp[1]);
                			if (mktime(0,0,0,$date[1],$date[0]+4,$date[2]) > (time())) {echo "<div class=\"mag_title_new\"><a class=\"mag_title_new\" href=\"sc.php?id=magazine.php&amp;id_magazine=$id_magazine\">".trim($tmp[0])."</a></div>";}
                			else {echo "<div class=\"mag_title\"><a class=\"mag_title\" href=\"sc.php?id=magazine.php&amp;id_magazine=$id_magazine\">".trim($tmp[0])."</a> </div>";}
                				include("data/pass/pass.php");
                				$upload_dir_counter = "data/magazine/counter/";
                				$n = $upload_dir_counter."mag_".$id_magazine.".dat";
                				if (file_exists("$n")) {
                				$fx = fopen("$n","r");
                				$c = fgets($fx,16);
                				fclose($fx);
                				$a= $c+1;
                				}
                				else {$a = 0;}
                    if ($team_short[$nick] =="") {echo "<div class=\"date\">".trim($tmp[1]).": $tmp[2]<br />$a&nbsp;views";} else { 
                			echo "<div class=\"date\">".trim($tmp[1]).": $tmp[2]|".strtoupper($team_short[$nick])."<br />$a&nbsp;views";}
                		$uu = "data/magazine/comments/". $id_magazine .".txt";
                		if(file_exists($uu)) {
                		$count_uu = file($uu);	
                		$count_uu = count($count_uu);
                		} else {$count_uu = 0;}
                		echo " | $count_uu comments ";
                		
                			echo "<p></div>";}$c++;
                    }fclose($fa);
               }			
			
			
		}
		
	}
	echo "<br /><a class=\"date\" title=\"Stanley Cup Magazine\" href=\"sc.php?id=magazine_form.php\"><b>Write your own articles here!</b></a><br />&nbsp;<p>";
}
}
	

?>
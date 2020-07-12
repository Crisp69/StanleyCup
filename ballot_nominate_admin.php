<?php
if($include_check == "bXnqwa") {

    $continue = $continue;
    $nick = $nick;
    
    if (($continue !== "yes") || ($nick !== "admin")) {
    	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php?id=ballot.php\">";
    }
    else {
    
    $nominate_form = $nominate_form;
    $trophy = $trophy;
    $file = "data/ballot/$trophy.txt";
    $write = $nominate_form;
    	if ((File_Exists($file)) && (Count(File($file))!==0)) {
    		$fp = FOpen ($file, "r");
    		$data = FRead ($fp, FileSize($file));
    		FClose($fp); }
    
    
    		$fp = FOpen ($file, "w");
    		FWrite ($fp, $write.$data);
    		FClose ($fp);
    
    echo "<form name=\"ok\" method=\"post\" action=\"sc.php?id=ballot.php&trophy=$trophy\">
    <input type=\"hidden\" name=\"nick\" value=\"$nick\">
    <input type=\"hidden\" name=\"password\" value=\"$password\">
    <input type=\"submit\" class=\"date\" value=\"-- OK --\" />
    </form>";
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
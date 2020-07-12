<script type="text/javascript" src="js/jquery.autogrow.js"></script>
<?php

if($include_check == "bXnqwa") {

	include("data/pass/pass.php");
	$nick_lower = strtolower($nick);
	
	if (($password !== $password_main[$nick_lower]) || ((trim($nick)) == "") || (!isset($edit_id)) || ($edit_id == "")) {
	echo "<a class=\"text1\"href=\"sc.php?id=magazine.php\"><b>Stanley Cup magazine</b></a><p><form name=\"pass\" method=\"post\" action=\"sc.php?id=magazine_form.php\">	
	HA nick:<br />
	<input type=\"text\" class=\"list\" name=\"nick\" ";
	if ($nick !== "") {echo "value=\"$nick\"";}
	echo " size=\"25\" /><p>
	password:<br />
	<input type=\"password\" class=\"list\" name=\"password\"";
	if ($password !== "") {echo "value=\"$password\"";}
	echo " size=\"25\" />
	<p>
	<input type=\"submit\" class=\"button\" value=\"-- LOGIN --\" />
	</form>
	<p>
	Only Stanley Cup managers are allowed to add articles to this web. Type your HA nick and Stanley Cup password to login. If you do not have your password or you have any problems with login, please contact <a class=\"text1\" target=\"_blank\" rel=\"shadowbox;width=1100;height=600\"  href=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_form.php&whom=sollu&subject=Stanley Cup login\">sollu</a>.<p><hr><b>MAGAZINE RULES:</b><br />You are allowed to write about anything you find interesting, but please try to restrain from complete spam and using bad language. thank you
	";}
	
	
	else {
	    parselogout_link($nick, $align = "right");
	    $edit_id = $edit_id;
		$nick = $nick;
		$password_main[$nick_lower] = $password_main[$nick_lower];
	
    
	echo "<table width=\"97%\"><tr><td valign=\"top\">";
	echo "<div class=\"headline\">Hello $nick!&nbsp;<form name=\"new\" method=\"post\" action=\"sc.php?id=magazine_form.php\"><input type=\"hidden\" name=\"nick\" value=\"$nick\"><input type=\"hidden\" name=\"password\" value=\"$password\"><input class=\"date\" type=\"submit\" value=\"-- BACK TO NEW ARTICLE FORM --\" /></form><p></div>";

    
    // EDIT EXISTING ARTICLE SELECT FORM
    echo "<center><b>Edit existing article:</b>";
    $f = fopen("data/magazine/magazine.txt","r");
	echo "<form name=\"edit\" method=\"post\" action=\"sc.php?id=magazine_edit.php\"><select size=\"1\" name=\"edit_id\"class=\"list\"><option value=\"err\">choose article...</option>";
	
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
		  if ($nick == trim($tmp[3])) { 
			echo "<option value=\"".trim($tmp[0])."\">".trim($tmp[2])." ($tmp[1])&nbsp;&nbsp;</option>"; 
			$c++;
            }
		}
	}
	fclose($f);
	echo "
	</select><input type=\"hidden\" name=\"nick\" value=\"$nick\"><input type=\"hidden\" name=\"password\" value=\"$password\"><br><input class=\"date\" type=\"submit\" value=\"-- EDIT --\" /></form></center><br /><br />";
    
    if($edit_id !== "err") {
    
    //EDIT EXISTING ARTICLE
    $magazine_file = "data/magazine/$edit_id.txt";
    $fa = fopen ($magazine_file,"r");
	while(!feof($fa)) {
    	$tmp_mag = explode("|",fgets($fa,2000));
    	if (trim($tmp_mag[0]) !== "") {
    	  if ($nick == trim($tmp_mag[2])) {$edit = "ok";}
          }
       }fclose($fa);
       
    if ($edit == "ok") {
        
        $text = Str_Replace("|", " ", $text);
    	$text = Str_Replace("\'", "'", $text);
    	$title = Str_Replace("\'", "'", $title);
    	$title = Str_Replace("|", " ", $title);	
    	
        echo "<form name=\"input\" method=\"post\" >
        
    	title - not editable!:<br />
    	<input type=\"text\" class=\"readonly\" name=\"title\" readonly=\"readonly\"";
    	if (($title == "") || !Isset($title)) {
        	$fa = fopen ($magazine_file,"r");
        	while(!feof($fa)) {
            	$tmp = explode("|",fgets($fa,2000));
            	if (trim($tmp[0]) != "") {
        		      echo " value=\"$tmp[0]\"";
      	      }
            }fclose($fa);
        }
        else {echo "value=\"$title\"";}
    	echo " size=\"62\" /><p>
    	
    	text:<br />
    	<textarea type=\"text\" class=\"list expand200-5000\" name=\"text\" cols=\"47\" rows=\"12\" />";
    	if (($text == "") || !Isset($text)) {
        	$fa = fopen ($magazine_file,"r");
        	while(!feof($fa)) {
            	$tmp = explode("|",fgets($fa,20000));
        		if (trim($tmp[0]) != "") {
        		      $tmp[4] = Str_Replace(" <br /> ","\n", $tmp[4]);
        		      echo "$tmp[4]";
                }
            }fclose($fa);
        }
        else {echo "$text";}
        echo "</textarea><p>";
    	
    	echo "<input type=\"hidden\" name=\"time\" value=\"".time()."\">
    	<input type=\"hidden\" name=\"edit_id\" value=\"$edit_id\">
    	<input type=\"submit\" class=\"date\" value=\"-- PREVIEW --\" />
    	</form>
    	<p></td>
    	";
    
    	
    	echo "<td></td><td valign=\"top\"><br /><b>HELP:</b><p>Title - type the title of your article, will be displayed in the list of articles<p>Text - type text of your article, you are allowed to use following html tags:<p>&lt;b&gt;text&lt;/b&gt; - for <b>bold</b><br />&lt;i&gt;text&lt;/i&gt; - for <i>italic</i><br />&lt;u&gt;text&lt;/u&gt; - for <u>underline</u><br />use ENTER for new line<p>add links tiping www.something.com or http://www.something.com<p>Link to picture - add here a link to a picture from other web, starting with http://<p>width of the picture - type width of the picture in px (try 100-200, max 640)<p><span class=\"mag_title_new\">Max width of the picture is 640px</span><p>clicking PREVIEW, you will see how your article will look at the page, you can now make changes, <b>Always PREVIEW before submitting!!!</b><p>clicking SUBMIT, you will add your article to the web
    	</td>";
    	echo "</tr></table>";
    	
    	$text = trim($text);
    	$text = HTMLSpecialChars($text);
    	$text = Str_Replace("\n"," <br /> ", $text);
    
    	$znak = 30;		//dlouha slova delit po .. znacich
        $slovo = Split("[[:blank:]]+", $text);		//rozdeleni textu na slova
    	for($y=0;$y<Count($slovo);$y++):
    		$slovo[$y] = Trim($slovo[$y]);			//odstraneni mezer na konci slova
    		if (Strlen($slovo[$y])<=$znak):			//nebudeme delit
    			if (EregI("^(www\..+\..{2,3})$", $slovo[$y])):		//jedna se odkaz typu www......
    				$odkaz = EregI_Replace("^(www\..+\..{2,3})$", "<a href=http://\\1>\\1</a> ", $slovo[$y]);
    			elseif (EregI("^(http://.+\..{2,3})$", $slovo[$y]))://jedna se odkaz typu http://.......
    				$odkaz = EregI_Replace("^(http://.+\..{2,3})$", "<a href=\\1>\\1</a> ", $slovo[$y]);
    			else:
    				$odkaz = $slovo[$y] . " ";						//jedna se o normalni slovo
    			endif;
    			$celek .= $odkaz;					//spojime vsechny slova opet dohromady
    		else:
    			$delit = Ceil(StrLen($slovo[$y])/$znak);	//delime dlouhe slovo
    			for($z=0;$z<$delit;$z++):
    			$cast = Substr($slovo[$y], $z*$znak, $znak);
    			$celek .= $cast . " - ";					//na konec jednotlivych casti pridame pomlcku
    			endfor;
    		endif;
    	endfor;
    	
    	$text = Str_Replace("&lt;b&gt;", "<b>", $celek);
    	$text = Str_Replace("&lt;/b&gt;", "</b>", $text);
    	
    	$text = Str_Replace("&lt;i&gt;", "<i>", $text);
    	$text = Str_Replace("&lt;/i&gt;", "</i>", $text);
    	
    	$text = Str_Replace("&lt;u&gt;", "<u>", $text);
    	$text = Str_Replace("&lt;/u&gt;", "</u>", $text);
    	$text = Str_Replace("&lt;BR /&gt; &lt;BR /&gt;", "<p>", $text);
    	$text = Str_Replace("|", " ", $text);
    	$text = Str_Replace("\'", "'", $text);
    	$title = Str_Replace("\'", "'", $title);
    	$title = Str_Replace("|", " ", $title);
    	
    	$date_input = date("d.m.Y", $time);
    	
    	if ((trim($title) =="") && (trim($text) =="")) {echo "type your article above";}
    		elseif (trim($title) =="") {echo "<div class=\"headline\">ERROR: TITLE MISSING</div>";}
    		elseif (trim($nick) =="") {echo "<div class=\"headline\">ERROR: YOUR NICK MISSING</div>";}
    		elseif (trim($text) =="") {echo "<div class=\"headline\">ERROR: TEXT MISSING</div>";}
    		else {
    			echo "<hr><div class=\"headline\">$title</div>";
    			echo "<div class=\"note\">$date_input | $nick <br />From  $team_full[$nick]<p> 
    			<p></div>";  
    			echo "<table width=\"95%\"><tr><td>";
                	$fa = fopen ($magazine_file,"r");
                	while(!feof($fa)) {
                    	$tmp = explode("|",fgets($fa,2000));
                		if (trim($tmp[0]) != "") {
                    	      echo "$tmp[3]";
                	    }
                    }fclose($fa);
    			echo "<div class=\"text\">$text</div><br />";$ok="ok";
    			echo "</td></tr></table>"; 
    			echo "<hr>";
    	}
    	
    	//<br /><img src=\"img/team_logo/small/$team_full[$nick].png\">
    	
    	if ($ok == "ok") {
    	   
                echo "<form name=\"form\" method=\"post\" action=\"sc.php?id=magazine_edit_submit.php\">";
                echo "<input type=\"hidden\" name=\"edit_id\" value=\"$edit_id\">";
                echo "<input type=\"hidden\" name=\"taem\" value=\"$team_full[$nick]\">";
                echo "<input type=\"hidden\" name=\"title\" value=\"$title\">";
                echo "<input type=\"hidden\" name=\"time\" value=\"$time\">";
                echo "<input type=\"hidden\" name=\"text\" value=\"$text\">";
                echo "<input type=\"hidden\" name=\"send\" value=\"ok\">";
                echo "<input class=\"date\" type=\"submit\" value=\"-- SUBMIT --\" />
                </form>";
				
            }
			}		
	    }else {echo "</td></tr></table><center>wrong input!</center>";}
	
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>
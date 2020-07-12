<?include("settings.php");?><link rel="stylesheet" <?echo $css;?> type="text/css" media="screen" title="default"><div class="tdmain">
<a class="text1" href="sc.php"> StanleyCup </a>
<?php

if (((($pass !== "farcry") || ($user !== "Trsto" )) && (($pass !== "farcry") || ($user !== "Trsto" ))) || (trim($user)) == "") {
	echo "<table><tr><td>";
	echo "<form name=\"pass\" method=\"post\" >user:<br />
		<input type=\"text\" class=\"list\" name=\"user\" ";
		if ($nick !== "") {echo "value=\"$user\"";}
		echo " size=\"25\" /><p>";
		echo "password:<br />
		<input type=\"password\" class=\"list\" name=\"pass\"";
		if ($password !== "") {echo "value=\"$pass\"";}
		echo " size=\"25\" />";
		echo "<p>
		<input type=\"submit\" class=\"date\" value=\"-- LOGIN --\" />
		</form><p></td></tr></table>";
}
else {

	echo "<table width=\"100%\"><tr><td width=\"50%\"><center><div class=\"text\">message text english:</div><form name=\"text_input\" method=\"post\">";
	echo "<textarea type=\"text\" class=\"list\" name=\"text\" cols=\"80\" rows=\"8\" />";
	echo "$text";
	echo "</textarea><br /><br />";
	echo "<div class=\"text\">message text slovak:</div><textarea type=\"text\" class=\"list\" name=\"text_sk\" cols=\"80\" rows=\"8\" />";
	echo "$text_sk";
	echo "</textarea><br />";
	echo "<input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"pass\" value=\"$pass\"><input type=\"hidden\" name=\"ok\" value=\"ok\">\n<br /><input type=\"submit\" class=\"date\" value=\"-- SUBMIT --\" /></form></center><td>";
	
	
if($ok=="ok") {
	$text = $text;
	echo "<td width=\"10%\"></td><td><p><form name=\"generate\" method=\"post\">";
	$file = "data/teams/teams.txt";
	echo "<table width=\"95%\" align=\"center\">";
	if(file_exists($file)) {
		$f = fopen($file, "r");
		$z=3;
		while (!feof($f)) {
			$tmp = explode("|", fgets($f, 2000));
			if($tmp[4] !== $user) {
				if (trim($tmp[0]) != "") {
					if ($z==3) {echo "<tr>"; $z=1;} else {$z++;}
					echo "<td><div class=\"text\"><input name=\"nickteam\" value=\"$tmp[4];$tmp[0]\" type=\"radio\"";
					if($nickteam == $tmp[4].";".$tmp[0]) {echo " checked=\"checked\">";} else {echo ">";}
					echo "&nbsp;$tmp[4]</div></td>";
					if ($z==3) {echo "</tr>";}
				}
			}
		} 
		fclose($f);
	}echo "";
	

$tmp_nickteam = explode(";",$nickteam);
$nick = $tmp_nickteam[0];
$team = $tmp_nickteam[1];

echo "</table><center><br />
<table><tr><td><span class=\"text\">Generate password: </span></td>
<td><input name=\"gen_pass\" value=\"yes\" type=\"radio\"";
if($gen_pass == "yes") {echo " checked=\"checked\">";} else {echo ">";} 
echo"&nbsp;<span class=\"text\">YES</span></td>
<td><input name=\"gen_pass\" value=\"no\" type=\"radio\"";
if($gen_pass == "no") {echo " checked=\"checked\">";} else {echo ">";} 
echo"&nbsp;<span class=\"text\">NO</span></td></tr></table>

<br /><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"pass\" value=\"$pass\"><input type=\"hidden\" name=\"ok\" value=\"ok\">\n<input type=\"hidden\" name=\"text\" value=\"$text\">\n<input type=\"hidden\" name=\"text_sk\" value=\"$text_sk\">\n<input type=\"submit\" class=\"date\" value=\"-- SUBMIT --\" /></form></center></td></tr></table><hr>";

if ($gen_pass == "yes") {
include ("data/pass/pass.php");
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
					$psw_file = "data/ballot/data/pass.php";
					if ((File_Exists($psw_file)) && (Count(File($psw_file))!==0)) {
							$fp_psw_file = FOpen ($psw_file, "r");
							$data_psw_file = FRead ($fp_psw_file, FileSize($psw_file));
							FClose($fp_psw_file); }
							$fp_psw_file = FOpen ($psw_file, "w");
							FWrite ($fp_psw_file, $write.$data_psw_file);
							FClose ($fp_psw_file);
                    //chmod($psw_file, 604);
	
	
	}
	
	if (isset($password_main[$nick_lower])) {
			echo "<center>send message:<p>";
			echo "<textarea type=\"text\" name=\"msg_text\" cols=\"100\" rows=\"15\" />";
			$orig_text_en = "$text\n\nick = $nick\npassword = $password_main[$nick_lower]\n\n$user\nstanleycup.crash.sk\n\n***************************************** \n\n";
			if($text_sk !== "") {$orig_text_sk = "$text_sk\n\nnick = $nick\npassword = $password_main[$nick_lower]\n\n$user\nstanleycup.crash.sk\n\n";}
			$orig_text = $orig_text_en.$orig_text_sk;
			echo "$orig_text";
			echo "</textarea><br />";
			echo "<form method=\"post\" action=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_sql.php\" target=\"_blank\">";
			echo "<input name=\"text\" type=\"hidden\" value=\"$orig_text\">";
			echo "<input name=\"whom\" type=\"hidden\" value=\"$nick\">";
			echo "<input name=\"subject\" type=\"hidden\" value=\"Stanley Cup\">";
			echo "<br /><input type=\"submit\" class=\"date\" value=Pošli></form></center>";
		
				
		
		
		}
	}
}	
else {	
			echo "<center>send message:<p>";
			echo "<textarea type=\"text\" name=\"msg_text\" cols=\"100\" rows=\"15\" />";
			$orig_text_en = "$text\n\n$user\nstanleycup.crash.sk\n\n*****************************************\n\n";
			if($text_sk !== "") {$orig_text_sk = "$text_sk\n\n$user\nstanleycup.crash.sk\n\n";}
			$orig_text = $orig_text_en.$orig_text_sk;
			echo "$orig_text";		
			echo "</textarea><br />";
			echo "<form method=\"post\" action=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_sql.php\" target=\"_blank\">";
			echo "<input name=\"text\" type=\"hidden\" value=\"$orig_text\">";
			echo "<input name=\"whom\" type=\"hidden\" value=\"$nick\">";
			echo "<input name=\"subject\" type=\"hidden\" value=\"Stanley Cup\">";
			echo "<br /><input type=\"submit\" class=\"date\" value=Pošli></form></center>";
			}



} else {echo "</tr></table>";}
}
?>

</div>


<!--

hi!
as Stanley Cup 15 champion is known, i would like to invite you to our popular players award ballot. last trophy without this season winner in famous Conn Smythe for playoffs Most Valuable Player.


http://stanleycup.crash.sk/sc.php?id=ballot.php

please use you nick and password bellow to login and vote.

Ahoj,
kedze vitaz Stanley Cupu 15 je uz znamy, chcel by som ta pozvat do oblubeneho hlasovania o hracske trofeje - posledna cena, ktora nema svojho majitela tuto sezonu je Conn Smythe Trophy pre najuzitocnejsieho hraca playoff.


http://stanleycup.crash.sk/sc.php?id=ballot.php

prihlasis sa a hlasovat mozes s heslom a nickom:
-->


<!-- 
function CheckAllINBOX() {
  for (var i = 0; i < document.FormMsgsINBOX.elements.length; i++) {
    if(document.FormMsgsINBOX.elements[i].type == 'checkbox'){
      document.FormMsgsINBOX.elements[i].checked =         !(document.FormMsgsINBOX.elements[i].checked);
    }
  }
}
//-->
<!--</script><a href="javascript:void(0)" onclick="CheckAllINBOX();">Oznacit všetko</a>
</td>-->



<!--
Hi,
as regular season of Stanley Cup 16 is now over, I would like to invite you to our famous annual awards ballot. First step is to nominate your players for:

- Hart Memorial Trophy (tournaments regular season MVP)
- Calder Memorial Trophy (best U20 player)

please go to: http://stanleycup.crash.sk/sc.php?id=ballot.php

to nominate 1 of your players in each cathegory, deadline for your nomination is: 20:00, 31.07.2009. Remember, if you do not nominate your players, the cannot win! :)

please use you nick and password bellow to login and vote.

nick = acapone
password = 7wCXiO

sollu
stanleycup.crash.sk

***************************************** 

Ahoj,
kedze zakladna cast Stanley Cupu 16 je uz za nami, pozyvam ta na nase slavne hlasovanie o vyrocne ceny. Ako prve je potrebne aby si nominoval tvojich hracov na:

- Hart Memorial Trophy (najuzitocnejsi hrac turnaja)
- Calder Memorial Trophy (najlepsi U20 hrac)

chod na: http://stanleycup.crash.sk/sc.php?id=ballot.php

a nominuj 1 z tvojich hracov v kazdej kategorii, deadline pre nominacie je 20:00, 31.07.2009. Pamataj, ak nenominujes svojich hracov, tak nemozu vyhrat! :)

prihlasis sa a hlasovat mozes s heslom a nickom:


nick = acapone
password = 7wCXiO

sollu
stanleycup.crash.sk

-->

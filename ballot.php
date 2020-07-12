<?
if($include_check == "bXnqwa") {
    
    include ("data/ballot/data/ballot_action.php");
    include ("data/pass/pass.php");
    //TO DO: 	
    //			dorobit sezonu???
    //			casovanie do ballot_action
    //			bill masterson
    
    
    	$nick_lower = strtolower($nick);
    	
    	if (($password !== $password_main[$nick_lower]) || (trim($nick)) == "") {
    	
        include("login_script.php");
        
    		echo "<br /><table width=\"95%\"><tr><td>";echo "<p></td><td valign=\"top\" align=\"left\">Current process:";
    				
    		if ($action == "1") {echo " nomination for <a href=\"sc.php?id=awards.php&trophy=hart\">Hart Memorial Trophy</a> <br />and <a href=\"sc.php?id=awards.php&trophy=calder\">Calder Memorial Trophy</a><p><div class=\"headline\">deadline for nominations: $deadline_nomination!</div></td></tr></table>";}
    		elseif ($action == "2") {echo " annual awards voting<p><div class=\"headline\">Deadline for voting: $deadline_regular!</div></td></tr></table>";
    			include("ballot_vote_function.php");
    			parsevote($trophy = "hart", $nick = "all"); 
    			parsevote($trophy = "calder", $nick = "all");
    			parsevote($trophy = "jack", $nick = "all"); 
    			parsevote($trophy = "vezina", $nick = "all");
    			parsevote($trophy = "james", $nick = "all");
    			parsevote($trophy = "frank", $nick = "all");
    			parsevote($trophy = "bill", $nick = "all");
				parsevote($trophy = "lady", $nick = "all");
    		}
    		elseif ($action == "3") {echo " <a href=\"sc.php?id=awards.php&trophy=conn\">Conn Smythe Trophy</a> voting<p><div class=\"headline\">deadline for voting: $deadline_conn!</div></td></tr></table>";
    			include("ballot_vote_function.php");
    			parsevote($trophy = "conn", $nick = "all"); 
    		}
    		else {echo " no voting open!</td></tr></table>";
    			include("ballot_result_function.php");
    			parseresult($trophy = "conn");
    			parseresult($trophy = "hart");
    			parseresult($trophy = "calder"); 
    			parseresult($trophy = "jack");
    			parseresult($trophy = "vezina");
    			parseresult($trophy = "james");
    			parseresult($trophy = "frank");
    			parseresult($trophy = "bill");
				parseresult($trophy = "lady", $nick = "all");
    		}
    	}
    	
    	else {
    	    //parselogout_link($nick, $align = "right");$password_main[$nick_lower] = $password_main[$nick_lower];
    		$nick = $nick;
    		
    		$team_short[$nick] = $team_short[$nick_lower];
    		echo "<div class=\"headline\">Hello $nick!<p></div>";
    		
    		if ($action == "1") {
    			if($nick !== "admin") {
    			include("ballot_nominate_function.php");
    			parsenominate($trophy = "hart", $team = $team_short[$nick], $nick = $nick);
    			parsenominate($trophy = "calder", $team = $team_short[$nick], $nick = $nick);}
    			elseif($nick == "admin") {
    				include("ballot_nominate_admin_function.php");
    				parseselect_admin($trophy, $nick);
    				if((time()>$dead_regular) && !isset($trophy) && (time() < $start_conn)) {$trophy = "conn";}
    				elseif(!isset($trophy)) {$trophy = "jack";}
    				parsenominate_admin($trophy, $nick = $nick);
    		
    			}
    		}
    		elseif ($action == "2") {include("ballot_vote_function.php");
    			if($nick !== "admin") {
    				$nick = $nick;
					echo "Results will be available here at "; if ($trophy == "conn") {echo "$deadline_conn<br /><br />";} else {echo "$deadline_regular<br /><br />";}
    				parsevote($trophy = "hart", $nick = $nick); 
    				parsevote($trophy = "calder", $nick = $nick);
    				parsevote($trophy = "jack", $nick = $nick); 
    				parsevote($trophy = "vezina", $nick = $nick);
    				parsevote($trophy = "james", $nick = $nick);
    				parsevote($trophy = "frank", $nick = $nick);
    				parsevote($trophy = "bill", $nick = $nick);
					parsevote($trophy = "lady", $nick = $nick);
    			}
				elseif($nick == "admin") {
    				include("ballot_result_function.php");
					parseresult($trophy = "conn");
    				parseresult($trophy = "hart");
    				parseresult($trophy = "calder"); 
    				parseresult($trophy = "jack");
    				parseresult($trophy = "vezina");
    				parseresult($trophy = "james");
    				parseresult($trophy = "frank");
    				parseresult($trophy = "bill");
					parseresult($trophy = "lady");
				}
    		}
    		elseif ($action == "3") {
  		        if($nick !== "admin") {
        			include("ballot_vote_function.php");
					$trophy = "conn";
					echo "Results will be available here at "; if ($trophy == "conn") {echo "$deadline_conn<br /><br />";} else {echo "$deadline_regular<br /><br />";}
        			parsevote($trophy = "conn", $nick = $nick);
                    }
                elseif($nick == "admin") {
    				include("ballot_result_function.php");
					parseresult($trophy = "conn");
                    }
    		}
    		elseif ($action == "4") {echo "No voting open, here are the results of latest ballot:<p>";
    			if($nick == "admin") {
    				include("ballot_nominate_admin_function.php");
    				parseselect_admin($trophy, $nick);
    				if((time()>$dead_regular) && !isset($trophy) && (time() < $start_conn)) {$trophy = "conn";}
    				elseif(!isset($trophy)) {$trophy = "jack";}
    				parsenominate_admin($trophy, $nick = $nick);
    		
    			}
    			else {
    				include("ballot_result_function.php");
    				parseresult($trophy = "conn");
    				parseresult($trophy = "hart");
    				parseresult($trophy = "calder"); 
    				parseresult($trophy = "jack");
    				parseresult($trophy = "vezina");
    				parseresult($trophy = "james");
    				parseresult($trophy = "frank");
    				parseresult($trophy = "bill");
					parseresult($trophy = "lady");
    			}
    }
    	
    }
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sc.php\">";}

?>

<?php
	class interclubs
	{
		public static function viewTeams()
		{
			$request = new BDD();
			
			$sql = "SELECT * FROM teams WHERE 1";
			$values = array();
			
			$return = $request->_request($sql, $values);
			
			$teams = array();
			
			// On tri
			for($i = 0; $i < count($return); $i++)
			{
				$teams[] = array(
					"id" => $return[$i]["id"],
					"name" => $return[$i]["name"],
					"players" => explode(",", $return[$i]["players"]),
					"classements" => explode(",", $return[$i]["classements"])
				);
			}
			
			
			// On affiche
			for($i = 0; $i < count($teams); $i++)
			{
				echo "<div class='team' onclick='interclubs.viewMatches(\"{$teams[$i]["id"]}\", \"{$teams[$i]["name"]}\")'>";
				
				echo "<div class='name'><span>{$teams[$i]["name"]}</span></div>";
				
				echo "<div class='players'>";
				
				for($a = 0; $a < count($teams[$i]["players"]);$a++)
				{
					echo "<span><b>{$teams[$i]["players"][$a]}</b><br /><br /><i>".strtoupper($teams[$i]["classements"][$a])."</i></span>";
				}
				
				echo "</div>";
				
				echo "</div>";
			}
		}
		
		public static function viewMatches($params)
		{
			$id = base64_decode($params);
			
			$request = new BDD();
			
			$sql = "SELECT * FROM matches WHERE team_id = ?";
			$values = array($id);
			
			$return = $request->_request($sql, $values);
			
			echo "<div id='matches'>";
			
			for($i = 0; $i < count($return); $i++)
			{
				if($return[$i]["isVictory"] == 0)
				{
					$issue = "defeat";
				}
				else if($return[$i]["isVictory"] == 1)
				{
					$issue = "victory";
				}
				else
				{
					$issue = "pending";
				}
				
				echo "
					<div class='match $issue'>
						<span class='type'>{$return[$i]["type"]}</span>
						<span class='date'>Le {$return[$i]["date"]}</span>
						<span class='name'>Rencontre n°".($i + 1)." contre <b>{$return[$i]["name"]}</b></span>
						<span class='issue'></b></span>
					</div>
				";
			}
			
			echo "</div>";
		}
	}
?>
<?php
	class tournaments
	{
		private static function readXML($url)
		{
			$objects = array("title","link","description","pubDate");
			
			if($chaine = file_get_contents($url))
			{
				$tmp = preg_split("/<\/?"."item".">/",$chaine);
				
				for($i=1;$i<sizeof($tmp)-1;$i+=2)
				{
					foreach($objects as $object) 
					{
						$tmp2 = preg_split("/<\/?".$object.">/",$tmp[$i]);
						
						$resultat[$i-1][] = utf8_encode($tmp2[1]);
					}
				}
				return $resultat;
			}
		}
		
		public static function getAllTournaments()
		{			
			$data = self::readXML("http://badiste.fr/rss.php?dep=37,72,49,86,36,41,18,45");
			
			$list = array();
			
			// On commence le tri du XML
			foreach($data as $k => $v)
			{
				$tournament = array();
				
				// Nom + lien vers badiste
				$tournament["name"] = htmlentities($v[0], ENT_QUOTES);
				$tournament["link_badiste"] = $v[1];
				
				$tmp = explode(".", $v[2]);
				
				// Date du tournoi
				$date = substr($tmp[0], 3, strpos($tmp[0], "(") - 4);
				$tournament["date"] = $date;
				
				// Durée du tournoi
				$duration = substr($tmp[0], strpos($tmp[0], "(") + 10, strpos($tmp[0], ").") - 1);
				$tournament["duration"] = $duration;
				
				// Club
				$club = substr($tmp[1], 8, strlen($tmp[1]));
				$tournament["club"] = $club;
				
				// Catégories
				$categories = explode(",", substr($tmp[2], 14, strlen($tmp[2])));
				$tournament["categories"] = $categories;
				
				// Tableaux disponibles
				$tables = explode(",", substr($tmp[3], 12, strlen($tmp[3])));
				$tournament["tables"] = $tables;
				
				// Date limite d'inscription
				$limit = substr($tmp[4], 29, strlen($tmp[4]));
				$tournament["limit"] = $limit;
				
				$list[] = $tournament;
			}
			
			// On affiche les tournois dans l'ordre des dates croissantes
			usort($list, function($a, $b)
			{
				// Transformation des dates
				$replace = array(
					"janvier" => "01",
					"février" => "02",
					"mars" => "03",
					"avril" => "04",
					"mai" => "05",
					"juin" => "06",
					"juillet" => "07",
					"août" => "08",
					"septembre" => "09",
					"octobre" => "10",
					"novembre" => "11",
					"décembre" => "12"
				);
				
				$day_a = explode(" ", $a["date"])[0];
				$month_a = str_replace(array_keys($replace), array_values($replace), explode(" ", $a["date"])[1]);
				$year_a = explode(" ", $a["date"])[2];
				
				$date_a = strtotime("{$year_a}-{$month_a}-{$day_a}");
				
				$day_b = explode(" ", $b["date"])[0];
				$month_b = str_replace(array_keys($replace), array_values($replace), explode(" ", $b["date"])[1]);
				$year_b = explode(" ", $b["date"])[2];
				
				$date_b = strtotime("{$year_b}-{$month_b}-{$day_b}");
				
				return $date_a <=> $date_b;
			});
						
			die(json_encode($list));
		}
		
		public static function getYoungsTournaments()
		{			
			$data = self::readXML("http://badiste.fr/rss.php?dep=18,33,28,36,41,45&categorie=jeune");
			
			$list = array();
			
			// On commence le tri du XML
			foreach($data as $k => $v)
			{
				$tournament = array();
				
				// Nom + lien vers badiste
				$tournament["name"] = htmlentities($v[0], ENT_QUOTES);
				$tournament["link_badiste"] = $v[1];
				
				$tmp = explode(".", $v[2]);
				
				// Date du tournoi
				$date = substr($tmp[0], 3, strpos($tmp[0], "(") - 4);
				$tournament["date"] = $date;
				
				// Durée du tournoi
				$duration = substr($tmp[0], strpos($tmp[0], "(") + 10, strpos($tmp[0], ").") - 1);
				$tournament["duration"] = $duration;
				
				// Club
				$club = substr($tmp[1], 8, strlen($tmp[1]));
				$tournament["club"] = $club;
				
				// Catégories
				$categories = explode(",", substr($tmp[2], 14, strlen($tmp[2])));
				$tournament["categories"] = $categories;
				
				// Tableaux disponibles
				$tables = explode(",", substr($tmp[3], 12, strlen($tmp[3])));
				$tournament["tables"] = $tables;
				
				// Date limite d'inscription
				$limit = substr($tmp[4], 30, strlen($tmp[4]));
				$tournament["limit"] = $limit;
				
				$list[] = $tournament;
			}
			
			// On affiche les tournois dans l'ordre des dates croissantes
			usort($list, function($a, $b)
			{
				// Transformation des dates
				$replace = array(
					"janvier" => "01",
					"février" => "02",
					"mars" => "03",
					"avril" => "04",
					"mai" => "05",
					"juin" => "06",
					"juillet" => "07",
					"août" => "08",
					"septembre" => "09",
					"octobre" => "10",
					"novembre" => "11",
					"décembre" => "12"
				);
				
				$day_a = explode(" ", $a["date"])[0];
				$month_a = str_replace(array_keys($replace), array_values($replace), explode(" ", $a["date"])[1]);
				$year_a = explode(" ", $a["date"])[2];
				
				$date_a = strtotime("{$year_a}-{$month_a}-{$day_a}");
				
				$day_b = explode(" ", $b["date"])[0];
				$month_b = str_replace(array_keys($replace), array_values($replace), explode(" ", $b["date"])[1]);
				$year_b = explode(" ", $b["date"])[2];
				
				$date_b = strtotime("{$year_b}-{$month_b}-{$day_b}");
				
				return $date_a <=> $date_b;
			});
						
			die(json_encode($list));
		}
		
		public static function register($params)
		{
			$rankings = array(
				"NC",
				"P12",
				"P11",
				"P10",
				"D9",
				"D8",
				"D7",
				"R6",
				"R5",
				"R4",
				"N3",
				"N2",
				"N1"
			);
			
			$categories = array(
				"NC/P12/P11/P10",
				"D9/D8",
				"D7/R6",
				"R5/R4",
				"N"
			);
            
            // Testons si le joueur est bien connecté
            $request = new BDD();
            if(!$request->_isLogged()) die("@error0");
			
			// Testons les champs
			$params = json_decode(base64_decode($params), true);
			
			if($params["tournament"]["name"] != "" && strlen($params["player"]["license"]) == 8 && $params["player"]["name"] != "" && $params["player"]["surname"] != "" && $params["player"]["rankingSimple"] != "" && $params["player"]["rankingDouble"] != "" && $params["player"]["rankingMixte"] != "" && in_array($params["player"]["rankingSimple"], $rankings) && in_array($params["player"]["rankingDouble"], $rankings) && in_array($params["player"]["rankingMixte"], $rankings))
			{
				// Si le joueur fait du simple
				if(array_key_exists("category", $params["simple"]))
				{
					// Test de la catégorie
					if(!in_array($params["simple"]["category"],$categories))
					{
						die("@error2");
					}
				}
				
				// Si le joueur fait du double
				if(array_key_exists("category", $params["double"]))
				{
					// Test de la catégorie
					if(!in_array($params["double"]["category"],$categories))
					{
						die("@error3");
					}
					
					// Test des champs du partenaire
					if(!strlen($params["double"]["license"]) == 8 || $params["double"]["name"] == "" || $params["double"]["surname"] == "" || !in_array($params["double"]["ranking"], $rankings))
					{
						die("@error4");
					}
				}
				
				// Si le joueur fait du double mixte
				if(array_key_exists("category", $params["mixte"]))
				{
					// Test de la catégorie
					if(!in_array($params["mixte"]["category"],$categories))
					{
						die("@error5");
					}
					
					// Test des champs du partenaire
					if(!strlen($params["mixte"]["license"]) == 8 || $params["mixte"]["name"] == "" || $params["mixte"]["surname"] == "" || !in_array($params["mixte"]["ranking"], $rankings))
					{
						die("@error6");
					}
				}
				
				// Tous les tests sont terminés, nous pouvons rentrer les informations dans la base de données
				$request = new BDD();
				
				// Statuts finaux
				$simple_cat = (array_key_exists("category", $params["simple"])) ? $params["simple"]["category"] : "";
				
				$double_cat = (array_key_exists("category", $params["double"])) ? $params["double"]["category"] : "";
				$double_license = (array_key_exists("category", $params["double"])) ? $params["double"]["license"] : "";
				$double_name = (array_key_exists("category", $params["double"])) ? $params["double"]["name"] : "";
				$double_surname = (array_key_exists("category", $params["double"])) ? $params["double"]["surname"] : "";
				$double_ranking = (array_key_exists("category", $params["double"])) ? $params["double"]["ranking"] : "";
				
				$mixte_cat = (array_key_exists("category", $params["mixte"])) ? $params["mixte"]["category"] : "";
				$mixte_license = (array_key_exists("category", $params["mixte"])) ? $params["mixte"]["license"] : "";
				$mixte_name = (array_key_exists("category", $params["mixte"])) ? $params["mixte"]["name"] : "";
				$mixte_surname = (array_key_exists("category", $params["mixte"])) ? $params["mixte"]["surname"] : "";
				$mixte_ranking = (array_key_exists("category", $params["mixte"])) ? $params["mixte"]["ranking"] : "";
				
				$sql = "INSERT INTO tournaments (id, hash, name, player_license, player_name, player_surname, player_rankingSimple, player_rankingDouble, player_rankingMixte, simple_category, double_category, double_partnerLicense, double_partnerName, double_partnerSurname, double_partnerRanking, mixte_category, mixte_partnerLicense, mixte_partnerName, mixte_partnerSurname, mixte_partnerRanking) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$values = array(
					null,
					$params["hash"],
					$params["tournament"]["name"],
					$params["player"]["license"],
					$params["player"]["name"],
					$params["player"]["surname"],
					$params["player"]["rankingSimple"],
					$params["player"]["rankingDouble"],
					$params["player"]["rankingMixte"],
					$simple_cat,
					$double_cat,
					$double_license,
					$double_name,
					$double_surname,
					$double_ranking,
					$mixte_cat,
					$mixte_license,
					$mixte_name,
					$mixte_surname,
					$mixte_ranking
				);
				
				$request->_request($sql, $values);
				
				die("@ok");
			}
			else
			{
				die("@error1");
			}
		}
		
		public static function viewPlayers($hash)
		{			
			$request = new BDD();
			
			$sql = "SELECT * FROM tournaments WHERE hash = ?";
			$values = array(base64_decode($hash));
			
			$return = $request->_request($sql, $values);
			
			die(json_encode($return));
		}
	}
?>
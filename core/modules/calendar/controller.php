<?php
	class calendar
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
		
		public static function getMonthEvents($params)
		{
			$months = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
			
			$params = base64_decode($params);
			$month = explode("/", $params)[0];
			$year = explode("/", $params)[1];
			
			// Récupération des tournois
			$data = self::readXML("http://badiste.fr/rss.php?dep=37,72,49,86,36,41,18,45");
//			$data = self::readXML("http://badiste.fr/rss.php");
			
			// On fait le tri dans le tableau reçu
			foreach($data as $k => $v)
			{
				$date = str_replace("Le ", "", substr($v[2], 0, strpos($v[2], "(")));
				
				$date_inscription = str_replace("d'inscription : ", "", substr($v[2], strpos($v[2], "d'inscription : "), strlen($v[2])-1));
				$tableaux = substr($v[2], strpos($v[2], "tableaux : "), strpos($v[2], ". date"));
				
				// Si ce n'est pas le bon mois
				if(!strpos($date, "{$months[$month - 1]} {$year}") && !strpos($date_inscription, "{$months[$month - 1]} {$year}"))
				{
				}
				else
				{
					$data[$k]["date"] = $date;
					$data[$k]["limite_inscription"] = $date_inscription;
					$data[$k]["tableaux"] = $tableaux;
				}
				
				if(strpos($date, "{$months[$month - 1]} {$year}") || strpos($date_inscription, "{$months[$month - 1]} {$year}"))
				{
					if(strpos($date, "{$months[$month - 1]} {$year}"))
					{
						$data[$k]["date"] = $date;
						$data[$k]["limite_inscription"] = "";
					}
					else
					{
						$data[$k]["date"] = "";
						$data[$k]["limite_inscription"] = $date_inscription;
					}
				}
				else
				{
					unset($data[$k]);
				}
				
			}
			
//			var_dump($data);
			
			// Récupération des dates importantes dans la base de données
			$request = new BDD();
			
			$sql = "SELECT * FROM dates WHERE date LIKE ?";
			$values = array("%{$month}/{$year}%");
			
			$data_2 = $request->_request($sql, $values);
			
			$result = json_encode(array(
				"tournaments" => $data,
				"dates" => $data_2
			));
			
			// On renvoi au client les résultats
			die($result);
		}
	}
?>
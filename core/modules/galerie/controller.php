<?php
	class galerie
	{
		public static function viewAll()
		{
			$request = new BDD();
			
			$data = array_chunk(
				$request->_request("SELECT * FROM albums WHERE 1 ORDER BY date DESC", array()),
				4
			);
			
			for($i = 0; $i < count($data); $i++)
			{
				echo "<span>";
				
				for($a = 0; $a < count($data[$i]); $a++)
				{
					echo "
						<p data-id='{$data[$i][$a]["id"]}' onclick='galerie.getImagesFromAlbum({$data[$i][$a]["id"]}, \"{$data[$i][$a]["name"]}\");'>
							<img src='public/images/galerie/album.png' /><br /><br />
							<b>{$data[$i][$a]["name"]}</b><br /><br />
							{$data[$i][$a]["date"]}
						</p>
					";
				}
				
				echo "</span>";
			}
		}
		
		public static function getImagesFromAlbum($params)
		{
			$id = base64_decode($params);
			
			$request = new BDD();
			
			$data = $request->_request("SELECT * FROM galerie WHERE album = ?", array($id));
			
			array_unshift($data, "new");
			
			$data = array_chunk($data, 6);
			
			for($i = 0; $i < count($data); $i++)
			{
				echo "<span>";
				
				for($a = 0; $a < count($data[$i]); $a++)
				{
					// Affichage du bouton "Ajouter"
					if($data[$i][$a] == "new")
					{
						echo "<p><img src='public/images/galerie/new.png' /><br /><input type='file' id='files' multiple /><br /><input type='button' value='Ajouter' onclick='galerie.upload();' /><br /><o></o></p>";
					}
					else
					{
                        $f = $data[$i][$a]["name"];
                        $name = substr($f, 0, strpos($f, "."));
                        $extension = substr($f, strpos($f, "."), strlen($f));
                        
						echo "<p><img onclick='galerie.zoom(this)' src='storage/galerie/{$name}_compressed{$extension}' /></p>";
					}
				}
				
				echo "</span>";
			}
		}
        
        public static function viewPrevious($params)
        {
            $name = base64_decode($params);
			
			$request = new BDD();
			
			$data = $request->_request("SELECT album FROM galerie WHERE name = ?", array($name));
            
            $id_album = $data[0]["album"];
            
            // On récupère l'ensemble des photos de l'album
            $data = $request->_request("SELECT name FROM galerie WHERE album = ?", array($id_album));
            $num = 0;
            
            foreach($data as $k => $v)
            {
                if($v["name"] == $name)
                {
                    $num = $k;
                    break;
                }
            }
            
            if($num != 0) die($data[$num - 1]["name"]);
            else die($data[count($data)-1]["name"]);
        }
        
        public static function viewNext($params)
        {
            $name = base64_decode($params);
			
			$request = new BDD();
			
			$data = $request->_request("SELECT album FROM galerie WHERE name = ?", array($name));
            
            $id_album = $data[0]["album"];
            
            // On récupère l'ensemble des photos de l'album
            $data = $request->_request("SELECT name FROM galerie WHERE album = ?", array($id_album));
            $num = 0;
            
            foreach($data as $k => $v)
            {
                if($v["name"] == $name)
                {
                    $num = $k;
                    break;
                }
            }
            
            if($num != count($data)-1) die($data[$num + 1]["name"]);
            else die($data[0]["name"]);
        }
		
		public static function addAlbum($params)
		{
			$name = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isMod() && !$request->_isAdmin()) die("@error0");
			
			$request->_request("INSERT INTO albums (id, name, date) VALUES (?, ?, ?)", array(null, $name, date("d/m/Y")));
		}
	}
?>
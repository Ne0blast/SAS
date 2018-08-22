<?php
	session_start();
	
	require("bdd.php");

	// Vérification des permissions
	$request = new BDD();
    if(!$request->_isLogged()) die("@error0");
	if(!$request->_isMod() && !$request->_isAdmin() && !$request->_isCA() && !$request->_isResp()) die("@error0");
	
	if(isset($_POST['id_album']))
	{
		// Pour chaque fichier, nous vérifions la taille, le type, etc...
		for($i = 0; $i < count($_FILES['pictures']['name']); $i++)
		{
			if($_FILES['pictures']['error'][$i] > 0)
			{
				die("@error1");
			}

			if(!getimagesize($_FILES['pictures']['tmp_name'][$i]))
			{
				die("@error2");
			}

			if(!in_array($_FILES['pictures']['type'][$i], array('image/png', "image/jpeg", "image/svg", "image/gif")))
			{
				die("@error3");
			}

			if($_FILES['pictures']['size'][$i] > pow(2, 20) * 10) // > 10 Mo
			{
				die("@error4");
			}

			if(file_exists('../storage/galerie/' . $_FILES['pictures']['name'][$i]))
			{
				die("@error5");
			}

			$name = $_FILES['pictures']['name'][$i];
			$token = hash("sha256", microtime(true));
			$extension = str_replace(".", "", substr($name, strrpos($name, "."), strlen($name)));

			if(!move_uploaded_file($_FILES['pictures']['tmp_name'][$i], "../storage/galerie/{$token}.{$extension}"))
			{
				die("@error6");
			}
            
            // Compression de l'image
            $img = imagecreatefromjpeg("../storage/galerie/{$token}.{$extension}");
            imagejpeg($img, "../storage/galerie/{$token}_compressed.{$extension}", 0);

			$request->_request("INSERT INTO galerie (id, name, extension, album) VALUES (?, ?, ?, ?)", array(null, "{$token}.{$extension}", $extension, $_POST['id_album']));
		}

		die("@ok");	
	}
	
	if(isset($_POST['plaquette_jeunes']))
	{
		if($_FILES['file']['error'] > 0)
		{
			die("@error1");
		}

		if(!in_array($_FILES['file']['type'], array("application/pdf")))
		{
			die("@error3");
		}

		if($_FILES['file']['size'] > pow(2, 20) * 20) // > 20 Mo
		{
			die("@error4");
		}

		if(file_exists('../storage/files/plaquette.pdf'))
		{
			unlink('../storage/files/plaquette.pdf');
		}
		
		if(!move_uploaded_file($_FILES['file']['tmp_name'], "../storage/files/plaquette.pdf"))
		{
			die("@error6");
		}
	}

	if(isset($_POST['calendrier_jeunes']))
	{
		if($_FILES['file']['error'] > 0)
		{
			die("@error1");
		}

		if(!in_array($_FILES['file']['type'], array("application/pdf")))
		{
			die("@error3");
		}

		if($_FILES['file']['size'] > pow(2, 20) * 20) // > 20 Mo
		{
			die("@error4");
		}

		if(file_exists('../storage/files/calendrier.pdf'))
		{
			unlink('../storage/files/calendrier.pdf');
		}
		
		if(!move_uploaded_file($_FILES['file']['tmp_name'], "../storage/files/calendrier.pdf"))
		{
			die("@error6");
		}
	}
?>
<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" lang="fr" type="text/html" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Saint-Avertin Sport Badminton</title>
        
        <link rel="icon" type="image/gif" href="public/images/logo.gif" />
		
		<link rel="stylesheet" type="text/css" href="public/css/general.css" />
		<link rel="stylesheet" type="text/css" href="public/css/pages.css" />
		<link rel="stylesheet" type="text/css" href="public/css/espace.css" />
        
		<link rel="stylesheet" type="text/css" href="public/css/espace_mobile.css" />
		
		<script type="text/javascript" src="public/js/espace.js"></script>
		<script type="text/javascript" src="public/js/filesaver.min.js"></script>
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body id="top">
		<header>
			<span onclick="document.location.href = 'index.php';" class="logo" style="width: 15vw;padding-left: 1vw;"><img src="public/images/logo.gif" /></span>
			<span onclick="document.location.href = 'news.php';" style="width: 8vw;">News</span>
			<span onclick="document.location.href = 'club.php';" style="width: 8vw;">Club</span>
			<span onclick="document.location.href = 'calendrier.php';" style="width: 8vw;">Calendrier</span>
			<span onclick="document.location.href = 'tournois.php';" style="width: 8vw;">Tournois</span>
			<span onclick="document.location.href = 'jeunes.php';" style="width: 8vw;">Jeunes</span>
			<span onclick="document.location.href = 'interclubs.php';" style="width: 8vw;">Interclub</span>
			<span onclick="document.location.href = 'galerie.php';" style="width: 8vw;">Galerie</span>
			<span class="selected" onclick="document.location.href = 'espace.php';" style="width: 8vw;">Mon espace</span>
		</header>
		
		<div id="page1">
			<div id="content_page1">
				<div id="title"><span>Mon espace</span></div>
				
				<div id="espace"></div>
				
				<div id="popup">
					<div class="title"><span></span></div>
					<div class="content"><span></span></div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			espace.init();
		</script>
	</body>
</html>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" lang="fr" type="text/html" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Saint-Avertin Sport Badminton</title>
        
        <link rel="icon" type="image/gif" href="public/images/logo.gif" />
		
		<link rel="stylesheet" type="text/css" href="public/css/general.css" />
		<link rel="stylesheet" type="text/css" href="public/css/pages.css" />
		<link rel="stylesheet" type="text/css" href="public/css/galerie.css" />
        
		<link rel="stylesheet" type="text/css" href="public/css/galerie_mobile.css" />
		
		<script type="text/javascript" src="public/js/galerie.js"></script>
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
			<span class="selected" onclick="document.location.href = 'galerie.php';" style="width: 8vw;">Galerie</span>
			<span onclick="document.location.href = 'espace.php';" style="width: 8vw;">Mon espace</span>
		</header>
		
		<div id="up"><span><img onclick="document.location.href = '#top';" src="public/images/index/up.png" /></span></div>
		<div id="plus"><span><img onclick="galerie.popup.open();" src="public/images/news/plus.png" /></span></div>
		
		<div id="page1">
			<div id="content_page1">
				<div id="title"><span>Galerie de photos</span></div>
				
				<div id="galerie"></div>
				
				<div id="popup">
					<span>
						<p>AJOUTER UN ALBUM</p><br /><br />
						<input type="text" placeholder="Nom de l'album..." />
						<input type="button" value="Créer" onclick="galerie.addAlbum();" /><br /><br />
						<input type="button" value="Fermer" onclick='galerie.popup.close();' />
					</span>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			galerie.init();
		</script>
	</body>
</html>
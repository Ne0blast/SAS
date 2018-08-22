<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" lang="fr" type="text/html" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Saint-Avertin Sport Badminton</title>
        
        <link rel="icon" type="image/gif" href="public/images/logo.gif" />
		
		<link rel="stylesheet" type="text/css" href="public/css/general.css" />
		<link rel="stylesheet" type="text/css" href="public/css/pages.css" />
		<link rel="stylesheet" type="text/css" href="public/css/calendrier.css" />
        
		<link rel="stylesheet" type="text/css" href="public/css/calendrier_mobile.css" />
		
		<script type="text/javascript" src="public/js/calendar.js"></script>
	</head>
	
	<body id="top">
		<header>
			<span onclick="document.location.href = 'index.php';" class="logo" style="width: 15vw;padding-left: 1vw;"><img src="public/images/logo.gif" /></span>
			<span onclick="document.location.href = 'news.php';" style="width: 8vw;">News</span>
			<span onclick="document.location.href = 'club.php';" style="width: 8vw;">Club</span>
			<span class="selected" onclick="document.location.href = 'calendrier.php';" style="width: 8vw;">Calendrier</span>
			<span onclick="document.location.href = 'tournois.php';" style="width: 8vw;">Tournois</span>
			<span onclick="document.location.href = 'jeunes.php';" style="width: 8vw;">Jeunes</span>
			<span onclick="document.location.href = 'interclubs.php';" style="width: 8vw;">Interclub</span>
			<span onclick="document.location.href = 'galerie.php';" style="width: 8vw;">Galerie</span>
			<span onclick="document.location.href = 'espace.php';" style="width: 8vw;">Mon espace</span>
		</header>
		
		<section id="page1">
			<div id="content_page1">
				<div id="title"><span>Calendrier</span></div>
				
				<div id="dates">
					<div id="date"><span></span></div>
					<div id="tournament"><span></span></div>
					<div id="limit"><span></span></div>
				</div>
				
				<div id="calendar">
					<table>
						<tr id="calendar_month_actions">
							<th colspan="7" style="border-bottom: 1px solid #212121;"><o></o><br /><img onclick="calendar.previousMonth();" src="public/images/calendrier/previous.png" /><img onclick="calendar.nextMonth();" src="public/images/calendrier/next.png" /></th>
						</tr>
						<tr id="days">
							<th>Lundi</th>
							<th>Mardi</th>
							<th>Mercredi</th>
							<th>Jeudi</th>
							<th>Vendredi</th>
							<th>Samedi</th>
							<th>Dimanche</th>
						</tr>
						<tr class="days"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="days"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="days"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="days"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="days"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="days"><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					</table>
				</div>
				
				<div id="legend">
					<span>
						<p class='circle circle-red'></p>DATE IMPORTANTE
						<p class='circle circle-blue'></p>TOURNOI
						<p class='circle circle-orange'></p>DATE LIMITE
					</span>
				</div>
			</div>
		</section>
		
		<script type="text/javascript">
			calendar.init();
		</script>
	</body>
</html>
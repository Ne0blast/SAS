<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" lang="fr" type="text/html" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Saint-Avertin Sport Badminton</title>
        
        <link rel="icon" type="image/gif" href="public/images/logo.gif" />
		
		<link rel="stylesheet" type="text/css" href="public/css/general.css" />
		<link rel="stylesheet" type="text/css" href="public/css/pages.css" />
		<link rel="stylesheet" type="text/css" href="public/css/news.css" />
        <link rel="stylesheet" type="text/css" href="public/css/news_mobile.css" />
		
		<script type="text/javascript" src="public/js/news.js"></script>
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body id="top">
		<header>
			<span onclick="document.location.href = 'index.php';" class="logo" style="width: 15vw;padding-left: 1vw;"><img src="public/images/logo.gif" /></span>
			<span class="selected" onclick="document.location.href = 'news.php';" style="width: 8vw;">News</span>
			<span onclick="document.location.href = 'club.php';" style="width: 8vw;">Club</span>
			<span onclick="document.location.href = 'calendrier.php';" style="width: 8vw;">Calendrier</span>
			<span onclick="document.location.href = 'tournois.php';" style="width: 8vw;">Tournois</span>
			<span onclick="document.location.href = 'jeunes.php';" style="width: 8vw;">Jeunes</span>
			<span onclick="document.location.href = 'interclubs.php';" style="width: 8vw;">Interclub</span>
			<span onclick="document.location.href = 'galerie.php';" style="width: 8vw;">Galerie</span>
			<span onclick="document.location.href = 'espace.php';" style="width: 8vw;">Mon espace</span>
		</header>
		
		<div id="up"><span><img onclick="document.location.href = '#top';" src="public/images/index/up.png" /></span></div>
		<div id="plus"><span><img onclick="news.add();" src="public/images/news/plus.png" /></span></div>
		
		<div id="page1">
			<div id="content_page1">
				<div id="title"><span>News et articles</span></div>
				
				<div id="news"></div>
				
				<div id="popup">
					<div class="title"><span><input type="text" placeholder="Titre de la news" />&nbsp;Tag : <i>Vie du club</i></span></div>
					
					<div class="content">
						<div class="toolbar">
							<span>
								<i onclick="news.editor.bold();" class="fa fa-bold"></i> 
								<i onclick="news.editor.italic();" class="fa fa-italic"></i> 
								<i onclick="news.editor.underline();" class="fa fa-underline"></i>  
								<i onclick="news.editor.aleft();" class="fa fa-align-left"></i> 
								<i onclick="news.editor.acenter();" class="fa fa-align-center"></i> 
								<i onclick="news.editor.aright();" class="fa fa-align-right"></i> 
								<i onclick="news.editor.ajustify();" class="fa fa-align-justify"></i> 
								<i onclick="news.editor.list();" class="fa fa-list"></i> 
								<i onclick="news.editor.link();" class="fa fa-link"></i> 
								<i onclick="news.editor.unlink();" class="fa fa-chain-broken"></i> 
								<i onclick="news.editor.table();" class="fa fa-table"></i> 
								<i onclick="news.editor.tag();" class="fa fa-tag"></i> 
							</span>
						</div>
						
						<iframe contenteditable="true" designMode="on"></iframe>
						
						<div class="min_popup">
							<span>
								<input type="text" placeholder="Lien..."/>&nbsp;
								<input type="button" value="Insérer" onclick="news.editor.insertLink();" />&nbsp;
								<input type="button" value="Fermer" onclick="news.editor.closeLinkPopup();" />
							</span>
						</div>
					</div>
					
					<div class="buttons"><span><input type="button" value="Sauvegarder" /> <input onclick="news.closePopup();" type="button" value="Fermer" /></span></div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			news.init();
			
			document.querySelector("iframe").onload = function()
			{
				this.contentDocument.contentEditable = true;
				this.contentDocument.designMode = "on";
				this.focus();
			}		
		</script>
	</body>
</html>
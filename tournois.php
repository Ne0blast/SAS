<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" lang="fr" type="text/html" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Saint-Avertin Sport Badminton</title>
        
        <link rel="icon" type="image/gif" href="public/images/logo.gif" />
		
		<link rel="stylesheet" type="text/css" href="public/css/general.css" />
		<link rel="stylesheet" type="text/css" href="public/css/pages.css" />
		<link rel="stylesheet" type="text/css" href="public/css/tournois.css" />
        
		<link rel="stylesheet" type="text/css" href="public/css/tournois_mobile.css" />
		
		<script type="text/javascript" src="public/js/tournaments.js"></script>
	</head>
	
	<body id="top">
		<header>
			<span onclick="document.location.href = 'index.php';" class="logo" style="width: 15vw;padding-left: 1vw;"><img src="public/images/logo.gif" /></span>
			<span onclick="document.location.href = 'news.php';" style="width: 8vw;">News</span>
			<span onclick="document.location.href = 'club.php';" style="width: 8vw;">Club</span>
			<span onclick="document.location.href = 'calendrier.php';" style="width: 8vw;">Calendrier</span>
			<span class="selected" onclick="document.location.href = 'tournois.php';" style="width: 8vw;">Tournois</span>
			<span onclick="document.location.href = 'jeunes.php';" style="width: 8vw;">Jeunes</span>
			<span onclick="document.location.href = 'interclubs.php';" style="width: 8vw;">Interclub</span>
			<span onclick="document.location.href = 'galerie.php';" style="width: 8vw;">Galerie</span>
			<span onclick="document.location.href = 'espace.php';" style="width: 8vw;">Mon espace</span>
		</header>
		
		<div id="up"><span><img onclick="document.location.href = '#top';" src="public/images/index/up.png" /></span></div>
		
		<section id="page1">
			<div id="content_page1">
				<div id="title"><span>Tournois</span></div>
				
				<div id="tournaments">
					<table>
						<tr>
							<th>Tournoi</th>
							<th>Date</th>
							<th>Durée</th>
							<th>Catégorie(s)</th>
							<th>Tableaux</th>
							<th>Date limite d'inscription</th>
							<th>Inscription</th>
						</tr>
					</table>
				</div>
				
				<div id="button_download_jeunes" onclick="window.open('storage/files/calendrier.pdf');"><span>Télécharger le calendrier des tournois Jeunes</span></div>
			</div>
		</section>
		
		<section id="page2">
			<div id="content_page2">
				<div id="title"><span>S'inscrire à un tournoi</span></div>
				
				<div id="register_tournaments">
					<div id="tournament_name"><span></span></div>
					
					<div id="title_you"><span>&Agrave; propos de vous</span></div>
					
					<div id="about_you">
						<span><input type="text" placeholder="Votre numéro de licence..." /></span>
						<span><input type="text" placeholder="Votre nom..." /></span>
						<span><input type="text" placeholder="Votre prénom..." /></span>
					</div>
					
					<div id="level_you">
						<span>
							Votre classement en <b>Simple</b><br />
							<select>
								<optgroup label="NC / P">
									<option value="NC">NC</option>
									<option value="P12">P12</option>
									<option value="P11">P11</option>
									<option value="P10">P10</option>
								</optgroup>
								<optgroup label="D">
									<option value="D9">D9</option>
									<option value="D8">D8</option>
									<option value="D7">D7</option>
								</optgroup>
								<optgroup label="R">
									<option value="R6">R6</option>
									<option value="R5">R5</option>
									<option value="R4">R4</option>
								</optgroup>
								<optgroup label="N">
									<option value="N3">N3</option>
									<option value="N2">N2</option>
									<option value="N1">N1</option>
								</optgroup>
							</select>
						</span>
						<span>
							Votre classement en <b>Double</b><br />
							<select>
								<optgroup label="NC / P">
									<option value="NC">NC</option>
									<option value="P12">P12</option>
									<option value="P11">P11</option>
									<option value="P10">P10</option>
								</optgroup>
								<optgroup label="D">
									<option value="D9">D9</option>
									<option value="D8">D8</option>
									<option value="D7">D7</option>
								</optgroup>
								<optgroup label="R">
									<option value="R6">R6</option>
									<option value="R5">R5</option>
									<option value="R4">R4</option>
								</optgroup>
								<optgroup label="N">
									<option value="N3">N3</option>
									<option value="N2">N2</option>
									<option value="N1">N1</option>
								</optgroup>
							</select>
						</span>
						<span>
							Votre classement en <b>Double Mixte</b><br />
							<select>
								<optgroup label="NC / P">
									<option value="NC">NC</option>
									<option value="P12">P12</option>
									<option value="P11">P11</option>
									<option value="P10">P10</option>
								</optgroup>
								<optgroup label="D">
									<option value="D9">D9</option>
									<option value="D8">D8</option>
									<option value="D7">D7</option>
								</optgroup>
								<optgroup label="R">
									<option value="R6">R6</option>
									<option value="R5">R5</option>
									<option value="R4">R4</option>
								</optgroup>
								<optgroup label="N">
									<option value="N3">N3</option>
									<option value="N2">N2</option>
									<option value="N1">N1</option>
								</optgroup>
							</select>
						</span>
					</div>
					
					<div id="title_partners"><span>&Agrave; propos de votre(vos) partenaire(s)</span></div>
					
					<div id="partners_you">
						<span>
							<fieldset>
								<legend><input type="checkbox" checked="false" name="simple" onclick="tournaments.checkboxes.trigger(this);" /><label for="simple">Je veux faire le <b>Simple</b></label></legend>
								Catégorie :
								<select>
									<optgroup label="P">
										<option name="P">NC/P12/P11/P10</option>
									</optgroup>
									<optgroup label="D">
										<option name="D9/D8">D9/D8</option>
										<option name="D7/R6">D7/R6</option>
									</optgroup>
									<optgroup label="R">
										<option name="R4/R5">R4/R5</option>
									</optgroup>
									<optgroup label="N">
										<option name="N3/N2/N1">N</option>
									</optgroup>
								</select>
							</fieldset>
						</span>
						
						<span>
							<fieldset>
								<legend><input type="checkbox" checked="false" name="double" onclick="tournaments.checkboxes.trigger(this);" /><label for="double">Je veux faire le <b>Double</b></label></legend>
								Catégorie :
								<select>
									<optgroup label="P">
										<option name="P">NC/P12/P11/P10</option>
									</optgroup>
									<optgroup label="D">
										<option name="D9/D8">D9/D8</option>
										<option name="D7/R6">D7/R6</option>
									</optgroup>
									<optgroup label="R">
										<option name="R4/R5">R4/R5</option>
									</optgroup>
									<optgroup label="N">
										<option name="N3/N2/N1">N</option>
									</optgroup>
								</select><br /><br />
								
								Partenaire :
								<input type="text" placeholder="Numéro de licence..." />&nbsp;
								<input type="text" placeholder="Nom..." />&nbsp;
								<input type="text" placeholder="Prénom..." /><br /><br />
								
								Classement partenaire :
								<select>
									<optgroup label="NC / P">
										<option value="NC">NC</option>
										<option value="P12">P12</option>
										<option value="P11">P11</option>
										<option value="P10">P10</option>
									</optgroup>
									<optgroup label="D">
										<option value="D9">D9</option>
										<option value="D8">D8</option>
										<option value="D7">D7</option>
									</optgroup>
									<optgroup label="R">
										<option value="R6">R6</option>
										<option value="R5">R5</option>
										<option value="R4">R4</option>
									</optgroup>
									<optgroup label="N">
										<option value="N3">N3</option>
										<option value="N2">N2</option>
										<option value="N1">N1</option>
									</optgroup>
								</select>
							</fieldset>
						</span>
						
						<span>
							<fieldset>
								<legend><input type="checkbox" checked="false" name="double_mixte" onclick="tournaments.checkboxes.trigger(this);" /><label for="double_mixte">Je veux faire le <b>Double Mixte</b></label></legend>
								Catégorie :
								<select>
									<optgroup label="P">
										<option name="P">NC/P12/P11/P10</option>
									</optgroup>
									<optgroup label="D">
										<option name="D9/D8">D9/D8</option>
										<option name="D7/R6">D7/R6</option>
									</optgroup>
									<optgroup label="R">
										<option name="R4/R5">R4/R5</option>
									</optgroup>
									<optgroup label="N">
										<option name="N3/N2/N1">N</option>
									</optgroup>
								</select><br /><br />
								
								Partenaire :
								<input type="text" placeholder="Numéro de licence..." />&nbsp;
								<input type="text" placeholder="Nom..." />&nbsp;
								<input type="text" placeholder="Prénom..." /><br /><br />
								
								Classement partenaire :
								<select>
									<optgroup label="NC / P">
										<option value="NC">NC</option>
										<option value="P12">P12</option>
										<option value="P11">P11</option>
										<option value="P10">P10</option>
									</optgroup>
									<optgroup label="D">
										<option value="D9">D9</option>
										<option value="D8">D8</option>
										<option value="D7">D7</option>
									</optgroup>
									<optgroup label="R">
										<option value="R6">R6</option>
										<option value="R5">R5</option>
										<option value="R4">R4</option>
									</optgroup>
									<optgroup label="N">
										<option value="N3">N3</option>
										<option value="N2">N2</option>
										<option value="N1">N1</option>
									</optgroup>
								</select>
							</fieldset>
						</span>
					</div>
					
					<div id="button"><span onclick="tournaments.saveRegistration();">S'inscrire</span></div>
				</div>
			</div>
		</section>
		
		<section id="page3">
			<div id="content_page3">
				<div id="title"><span>Participants au tournoi</span></div>
				
				<div id="tournament_name"><span></span></div>
				
				<div id="players">
					<table>
						<tr class="high_cat">
							<th colspan="6" style="border-right: 1px solid #006436;">INFORMATIONS JOUEUR</th>
							<th colspan="1" style="border-right: 1px solid #006436;">SIMPLE</th>
							<th colspan="5" style="border-right: 1px solid #006436;">DOUBLE</th>
							<th colspan="5">MIXTE</th>
						</tr>
						<tr class="medium_cat">
							<td>Licence</td>
							<td>Nom</td>
							<td>Prénom</td>
							<td>Class. simple</td>
							<td>Class. double</td>
							<td style="border-right: 1px solid #cccccc;">Class. mixte</td>
							<td style="border-right: 1px solid #cccccc;">Cat.</td>
							<td>Cat.</td>
							<td>Licence</td>
							<td>Nom</td>
							<td>Prénom</td>
							<td style="border-right: 1px solid #cccccc;">Class.</td>
							<td>Cat.</td>
							<td>Licence</td>
							<td>Nom</td>
							<td>Prénom</td>
							<td>Class.</td>
						</tr>
					</table>
				</div>
			</div>
		</section>
		
		<script type="text/javascript">
			tournaments.init();
			tournaments.checkboxes.init();
		</script>
	</body>
</html>
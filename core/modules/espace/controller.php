<?php
	class espace
	{
		/*
		*
		* FONCTION PRINCIPALE (REDIRECTION DE L'UTILISATEUR SUIVANT SON STATUT)
		*
		*/
		public static function viewPanel()
		{
			$request = new BDD();
			
			if($request->_isLogged())
			{
				if($request->_isAdmin())
				{
					self::showPanelAdmin();
				}
				else if($request->_isMod())
				{
					self::showPanelMod();
				}
				else if($request->_isCA())
				{
					self::showPanelCA();
				}
				else if($request->_isResp())
				{
					self::showPanelResp();
				}
				else
				{
					self::showPanelPublic();
				}
			}
			else
			{
				self::showPanelConnection();
			}
		}
		
		
		/*
		*
		* AFFICHAGE DES DIFFERENTES INFORMATIONS SUIVANT LES DROITS DE L'UTILISATEUR (ET LE STATUT)
		*
		*/
		protected static function showPanelAdmin()
		{		
			echo "
				<div id='tabs'>
					<span id='menu_informations' onclick='espace.trigger(\"informations\");' class='selected'>Mes informations</span>
					<span id='menu_members' onclick='espace.trigger(\"members\");'>Gestion des adhérents</span>
					<span id='menu_dates' onclick='espace.trigger(\"dates\");'>Gestion des dates</span>
					<span id='menu_teams' onclick='espace.trigger(\"teams\");'>Gestion des équipes</span>
					<span id='menu_matches' onclick='espace.trigger(\"matches\");'>Gestion des matches</span>
					<span id='menu_tournaments' onclick='espace.trigger(\"tournaments\");'>Gestion des tournois</span>
					<span id='menu_jeunes' onclick='espace.trigger(\"jeunes\");'>Gestion des tournois jeunes</span>
				</div>
				
				<div id='content_tabs'>
			";
			
			self::showContentInformations();
			self::showContentMembers();
			self::showContentDates();
			self::showContentTeams();
			self::showContentMatches();
			self::showContentTournaments();
			self::showContentJeunes();
			
			echo "
				</div>
			";
		}
		
		protected static function showPanelMod()
		{			
			echo "<div id='tabs'>
					<span id='menu_informations' onclick='espace.trigger(\"informations\");' class='selected'>Mes informations</span>
					<span id='menu_teams' onclick='espace.trigger(\"teams\");'>Gestion des équipes</span>
					<span id='menu_matches' onclick='espace.trigger(\"matches\");'>Gestion des matches</span>
				</div>
				
				<div id='content_tabs'>
			";
			
			self::showContentInformations();
			self::showContentTeams();
			self::showContentMatches();
			
			"
				</div>
			";
		}
		
		protected static function showPanelCA()
		{
			echo "<div id='tabs'>
					<span id='menu_informations' onclick='espace.trigger(\"informations\");' class='selected'>Mes informations</span>
					<span id='menu_members' onclick='espace.trigger(\"members\");'>Gestion des adhérents</span>
					<span id='menu_dates' onclick='espace.trigger(\"dates\");'>Gestion des dates</span>
					<span id='menu_tournaments' onclick='espace.trigger(\"tournaments\");'>Gestion des tournois</span>
				</div>
				
				<div id='content_tabs'>
			";
			
			self::showContentInformations();
			self::showContentMembersMinimal();
			self::showContentDates();
			self::showContentTournaments();
			
			echo "
				</div>
			";
		}
		
		protected static function showPanelResp()
		{
			echo "<div id='tabs'>
					<span id='menu_informations' onclick='espace.trigger(\"informations\");' class='selected'>Mes informations</span>
					<span id='menu_members' onclick='espace.trigger(\"members\");'>Gestion des adhérents</span>
					<span id='menu_dates' onclick='espace.trigger(\"dates\");'>Gestion des dates</span>
				</div>
				
				<div id='content_tabs'>
			";
			
			self::showContentInformations();
			self::showContentMembersMinimal();
			self::showContentDates();
			
			echo "
				</div>
			";
		}
		
		protected static function showPanelPublic()
		{
			$request = new BDD();
			
			echo "
				<div id='tabs'>
					<span onclick='espace.trigger(\"informations\");' class='selected'>Mes informations</span>
				</div>
				
				<div id='content_tabs'>
			";
			
			self::showContentInformations();
			
			echo "
				</div>
			";
		}
		
		protected static function showPanelConnection()
		{
			$request = new BDD();
			
			if($request->_isLogged()) die("@error");
			
			echo "
				<div id='connect'>
					<span>
						<p>Se connecter</p>
						<input type='mail' placeholder='Adresse mail...' /><br /><br />
						<input type='password' placeholder='Votre mot de passe...' /><br /><br />
						<button onclick='espace.connect();'>Se connecter</button><br /><br />
						<o></o>
					</span>	
				</div>
			";
		}
		
		
		/*
		*
		* CONTENU DE CHAQUE ONGLET (avec vérification des permissions à chaque fois)
		*
		*/
		protected static function showContentInformations()
		{
			$request = new BDD();
			
			$informations = $request->_request("SELECT * FROM users WHERE token = ?", array($_SESSION['session']['token']));
			
			$license = (strlen($informations[0]["license"]) != 8) ? "Non" : $informations[0]["license"];
			$certificate = ($informations[0]["certif"]) ? "Oui" : "Non";
			
			if(!$request->_isLogged()) die("@error");
			
			echo "
				<div class='content selected' id='tab_informations'>
					<div class='name'><span>".strtoupper($informations[0]["name"])." {$informations[0]["surname"]}</span></div>
					<div class='form'>
						<span>
							<p><i class='fa fa-home'></i> Adresse : <input type='text' placeholder='Adresse...' value='{$informations[0]["adress"]}' /> <input style='width:3vw;' type='text' placeholder='Code postal' value='{$informations[0]["postal"]}' /> <input type='text' placeholder='Ville...' value='{$informations[0]["city"]}' /> <i class='fa fa-save action' onclick='espace.informations.submitAdress();'></i></p>
						</span>
						<span>
							<p><i class='fa fa-envelope'></i> E-mail : <input type='mail' placeholder='E-mail...' value='{$informations[0]["mail"]}' /> <i class='fa fa-save action' onclick='espace.informations.submitMail();'></i></p>
						</span>
						<span>
							<p><i class='fa fa-phone'></i> Téléphone : <input type='text' placeholder='Téléphone...' value='{$informations[0]["phone"]}' /> <i class='fa fa-save action' onclick='espace.informations.submitPhone();'></i></p>
						</span>
						<span>
							<p><i class='fa fa-birthday-cake'></i> Date de naissance : <input type='text' placeholder='Date de naissance...' value='{$informations[0]["birth"]}' /> <i class='fa fa-save action' onclick='espace.informations.submitBirth();'></i></p>
						</span>
						<span>
							<p><i class='fa fa-address-card'></i> License : {$license}</p>
						</span>
						<span>
							<p><i class='fa fa-certificate'></i> Cerficat médical : {$certificate}</p>
						</span>
						<span>
							<p><i class='fa fa-lock'></i> Mot de passe : <input type='password' placeholder='Nouveau mot de passe...' /> <i class='fa fa-save action' onclick='espace.informations.submitPassword();'></i> (Si c'est votre première connexion, nous vous conseillons de changer votre mot de passe)</p>
						</span>
					</div>
				</div>
			";
		}
		
		protected static function showContentMembers()
		{
			$request = new BDD();
			
			if(!$request->_isAdmin()) die("@error");
			
			$members = $request->_request("SELECT * FROM users WHERE 1 ORDER BY name ASC", array());
			
			echo "
				<div class='content' id='tab_members'>
					<table>
						<tr>
							<th>Inscription ?</th>
							<th>Civilité</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Mail</th>
							<th>Téléphone</th>
							<th>Téléphone 2</th>
							<th>Adresse</th>
							<th>Code postal</th>
							<th>Ville</th>
							<th>Objectif</th>
							<th>Séance</th>
							<th>Licence</th>
							<th>Certificat</th>
							<th>Administrateur ?</th>
							<th>Modérateur ?</th>
							<th>Responsable séance ?</th>
							<th>Membre CA ?</th>
							<th>Attestation ?</th>
							<th>Paiement</th>
							<th>Carte SAS ?</th>
							<th style='background: #bf360c';>Actions</th>
						</tr>
			";
			
			for($i = 0; $i < count($members); $i++)
			{
				$inscription = ($members[$i]["inscription"]) ? "Oui" : "Non";
				$certif = ($members[$i]["certif"]) ? " checked" : "";
				$isAdmin = ($members[$i]["isAdmin"]) ? " checked" : "";
				$isMod = ($members[$i]["isMod"]) ? " checked" : "";
				$isResponsable = ($members[$i]["isResponsable"]) ? " checked" : "";
				$isCA = ($members[$i]["isCA"]) ? " checked" : "";
				$attestation = ($members[$i]["attestation"]) ? " checked" : "";
				$carteSAS = ($members[$i]["carte_sas"]) ? " checked" : "";
				
				echo "
					<tr id='member_{$members[$i]["id"]}'>
						<td><input type='text' value='{$inscription}' /></td>
						<td><input type='text' value='{$members[$i]["civilité"]}' /></td>
						<td><input type='text' value='{$members[$i]["name"]}' /></td>
						<td><input type='text' value='{$members[$i]["surname"]}' /></td>
						<td><input type='text' value='{$members[$i]["mail"]}' /></td>
						<td><input type='text' value='{$members[$i]["phone"]}' /></td>
						<td><input type='text' value='{$members[$i]["phone2"]}' /></td>
						<td><input type='text' value='{$members[$i]["adress"]}' /></td>
						<td><input type='text' value='{$members[$i]["postal"]}' /></td>
						<td><input type='text' value='{$members[$i]["city"]}' /></td>
						<td><input type='text' value='{$members[$i]["type"]}' /></td>
						<td><input type='text' value='{$members[$i]["seance"]}' /></td>
						<td><input type='text' value='{$members[$i]["license"]}' /></td>
						<td><input type='checkbox'{$certif} /></td>
						<td><input type='checkbox'{$isAdmin} /></td>
						<td><input type='checkbox'{$isMod} /></td>
						<td><input type='checkbox'{$isResponsable} /></td>
						<td><input type='checkbox'{$isCA} /></td>
						<td><input type='checkbox'{$attestation} /></td>
						<td><input type='text' value='{$members[$i]["type_paiement"]}' /></td>
						<td><input type='checkbox'{$carteSAS} /></td>
						<td style='background: #fbe9e7;'><i class='fa fa-save' onclick='espace.members.update(\"{$members[$i]["id"]}\");'></i>&nbsp;&nbsp;<i class='fa fa-trash' onclick='espace.members.delete(\"{$members[$i]["id"]}\");'></i></td>
					</tr>
				";
			}
			
			echo "
					</table>

					<div id='plus' onclick='espace.members.add();'><span><img src='public/images/news/plus.png' /></span></div>
					<div id='export'><span onclick='espace.members.export();'><img src='public/images/espace/export.png' /></span></div>
					<div id='mail'><span onclick='espace.members.mail();'><img src='public/images/espace/mail.png' /></span></div>
				</div>
			";
		}
		
		protected static function showContentMembersMinimal()
		{
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isResp()) die("@error");
			
			$members = $request->_request("SELECT * FROM users WHERE 1 ORDER BY name ASC", array());
			
			echo "
				<div class='content' id='tab_members'>
					<table>
						<tr>
							<th>Civilité</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Mail</th>
							<th>Téléphone</th>
							<th>Téléphone 2</th>
							<th>Objectif</th>
							<th>Séance</th>
							<th>Licence</th>
						</tr>
			";
			
			for($i = 0; $i < count($members); $i++)
			{				
				echo "
					<tr id='member_{$members[$i]["id"]}' style='font-size: 2vh;'>
						<td>{$members[$i]["civilité"]}</td>
						<td>{$members[$i]["name"]}</td>
						<td>{$members[$i]["surname"]}</td>
						<td>{$members[$i]["mail"]}</td>
						<td>{$members[$i]["phone"]}</td>
						<td>{$members[$i]["phone2"]}</td>
						<td>{$members[$i]["type"]}</td>
						<td>{$members[$i]["seance"]}</td>
						<td>{$members[$i]["license"]}</td>
					</tr>
				";
			}
			
			echo "
					</table>

					<div id='mail'><span onclick='espace.members.mail();'><img src='public/images/espace/mail.png' /></span></div>
				</div>
			";
		}
		
		protected static function showContentDates()
		{
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isResp()) die("@error");
			
			$dates = $request->_request("SELECT * FROM dates WHERE 1 ORDER BY date ASC", array());
			
			echo "
				<div class='content' id='tab_dates'>
					<table>
						<tr>
							<th>Nom</th>
							<th>Date</th>
							<th style='background: #bf360c';>Actions</th>
						</tr>
			";
			
			for($i = 0; $i < count($dates); $i++)
			{
				echo "
					<tr id='date_{$dates[$i]["id"]}'>
						<td><input type='text' value='{$dates[$i]["name"]}' /></td>
						<td><input type='text' value='{$dates[$i]["date"]}' /></td>
						<td><i onclick='espace.dates.save({$dates[$i]["id"]});' class='fa fa-save'></i><i onclick='espace.dates.delete({$dates[$i]["id"]});' class='fa fa-trash'></i></td>
					</tr>
				";
			}
			
			echo "
					</table>

					<div id='plus' onclick='espace.dates.add();'><span><img src='public/images/news/plus.png' /></span></div>
				</div>
			";
		}
		
		protected static function showContentTournaments()
		{
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA()) die("@error");
			
			$tournaments = $request->_request("SELECT * FROM tournaments WHERE 1 ORDER BY name ASC", array());
			
			echo "
				<div class='content' id='tab_tournaments'>
					<table>
						<tr>
							<th rowspan='2'>TOURNOI</th>
							<th style='border-left: 1px dotted #e0ffe6;' colspan='6'>INFORMATIONS JOUEUR</th>
							<th style='border-left: 1px dotted #e0ffe6;' colspan='1'>SIMPLE</th>
							<th style='border-left: 1px dotted #e0ffe6;' colspan='5'>DOUBLE</th>
							<th style='border-left: 1px dotted #e0ffe6;' colspan='5'>MIXTE</th>
						</tr>
						<tr>
							<th style='border-left: 1px dotted #e0ffe6;'>Licence</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Class. simple</th>
							<th>Class. double</th>
							<th>Class. mixte</th>
							<th style='border-left: 1px dotted #e0ffe6;'>Cat.</th>
							<th style='border-left: 1px dotted #e0ffe6;'>Cat.</th>
							<th>Licence</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Class.</th>
							<th style='border-left: 1px dotted #e0ffe6;'>Cat.</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Class.</th>
						</tr>
			";
			
			for($i = 0; $i < count($tournaments); $i++)
			{
				echo "
					<tr>
						<td>{$tournaments[$i]["name"]}</td>
						<td style='border-left: 1px dotted #888888;'>{$tournaments[$i]["player_license"]}</td>
						<td>{$tournaments[$i]["player_name"]}</td>
						<td>{$tournaments[$i]["player_surname"]}</td>
						<td>{$tournaments[$i]["player_rankingSimple"]}</td>
						<td>{$tournaments[$i]["player_rankingDouble"]}</td>
						<td>{$tournaments[$i]["player_rankingMixte"]}</td>
						<td style='border-left: 1px dotted #888888;'>{$tournaments[$i]["simple_category"]}</td>
						<td style='border-left: 1px dotted #888888;'>{$tournaments[$i]["double_category"]}</td>
						<td>{$tournaments[$i]["double_partnerLicense"]}</td>
						<td>{$tournaments[$i]["double_partnerName"]}</td>
						<td>{$tournaments[$i]["double_partnerSurname"]}</td>
						<td>{$tournaments[$i]["double_partnerRanking"]}</td>
						<td style='border-left: 1px dotted #888888;'>{$tournaments[$i]["mixte_category"]}</td>
						<td>{$tournaments[$i]["mixte_partnerName"]}</td>
						<td>{$tournaments[$i]["mixte_partnerSurname"]}</td>
						<td>{$tournaments[$i]["mixte_partnerRanking"]}</td>
					</tr>
				";
			}
			
			echo "
					</table>
				</div>
			";
		}
		
		protected static function showContentMatches()
		{
			$request = new BDD();
			
			if(!$request->_isMod() && !$request->_isAdmin()) die("@error");
			
			$matches = $request->_request("SELECT * FROM matches WHERE 1 ORDER BY team_id ASC", array());
			$teams = $request->_request("SELECT * FROM teams WHERE 1 ORDER BY id ASC", array());
			
			$matches_list = array();
			
			// Petit tri
			for($i = 0; $i < count($teams); $i++)
			{
				$matches_list["team_". $teams[$i]["id"]] = array();
			}
			
			for($i = 0; $i < count($matches); $i++)
			{				
				$matches_list["team_".$matches[$i]["team_id"]][] = $matches[$i];
			}
			
			$matches = $matches_list;
			
			echo "
				<div class='content' id='tab_matches'>
					<table>
						<tr>
							<th>Nom de l'équipe / Catégorie de l'équipe</th>
							<th>Type de rencontre</th>
							<th>Adversaire</th>
							<th>A domicile ?</th>
							<th>Victoire ?<br /><o style='font-size: 1.5vh;'>(0 = Non ; 1 = Oui ; 2 = Pas encore joué)</o></th>
							<th>News associée</th>
							<th>Date de la rencontre</th>
							<th style='background: #bf360c';>Actions</th>
						</tr>
			";
			
			for($i = 0; $i < count($teams); $i++)
			{
				if(array_key_exists("team_".$teams[$i]["id"], $matches))
				{
					$nb = count($matches["team_".$teams[$i]["id"]]) + 1;
				
					echo "
						<tr>
							<td class='team' rowspan='{$nb}'>{$teams[$i]["name"]}</td>
							<td colspan='7' class='add' onclick='espace.matches.add({$teams[$i]["id"]});'>Ajouter un match</td>
						</tr>
					";
					
					for($a = 0; $a < count($matches["team_".$teams[$i]["id"]]); $a++)
					{
						$isLocal = ($matches["team_".$teams[$i]["id"]][$a]["receive"] == 1) ? "checked" : "";

						echo "
							<tr id='match_{$matches["team_".$teams[$i]["id"]][$a]["id"]}'>
								<td><input type='text' value='{$matches["team_".$teams[$i]["id"]][$a]["type"]}' /></td>
								<td><input type='text' value='{$matches["team_".$teams[$i]["id"]][$a]["name"]}' /></td>
								<td><input type='checkbox' {$isLocal}/></td>
								<td><input type='text' value='{$matches["team_".$teams[$i]["id"]][$a]["isVictory"]}'</td>
								<td><input type='text' value='{$matches["team_".$teams[$i]["id"]][$a]["news_id"]}' /></td>
								<td><input type='text' value='{$matches["team_".$teams[$i]["id"]][$a]["date"]}' /></td>
								<td><i class='fa fa-save' onclick='espace.matches.update({$matches["team_".$teams[$i]["id"]][$a]["id"]})'></i><i class='fa fa-trash' onclick='espace.matches.delete({$matches["team_".$teams[$i]["id"]][$a]["id"]})'></i></td>
							</tr>
						";
					}	
				}
			}
			
			echo "
					</table>
				</div>
			";
		}
		
		protected static function showContentTeams()
		{
			$request = new BDD();
			
			if(!$request->_isMod() && !$request->_isAdmin()) die("@error");
			
			$teams = $request->_request("SELECT * FROM teams WHERE 1 ORDER BY id ASC", array());
			
			echo "
				<div class='content' id='tab_teams'>
					<table>
						<tr>
							<th>Nom de l'équipe / Catégorie de l'équipe</th>
							<th>Joueurs de l'équipe</th>
							<th>Classements</th>
							<th style='background: #bf360c';>Actions</th>
						</tr>
			";
			
			for($i = 0; $i < count($teams); $i++)
			{
				$members_team = explode(",", $teams[$i]["players"]);
				$classements_team = explode(",", $teams[$i]["classements"]);
				$nb = count($members_team) + 2;
				
				echo "
					<tbody id='team_{$teams[$i]["id"]}'>
						<tr>
							<td rowspan='{$nb}' class='team'>{$teams[$i]["name"]}</td>
							<td onclick='espace.teams.addMember({$teams[$i]["id"]});' colspan='3' class='add'>+ AJOUTER UN MEMBRE DANS L'EQUIPE</td>
						</tr>

						<tr>
							<td onclick='espace.teams.deleteTeam({$teams[$i]["id"]});' colspan='3' class='delete'>- SUPPRIMER L'EQUIPE</td>
						</tr>
				";
				
				for($a = 0; $a < count($members_team); $a++)
				{
					echo "
						<tr id='member_{$teams[$i]["id"]}_{$a}'>
							<td>{$members_team[$a]}</td>
							<td><input type='text' value='".strtoupper($classements_team[$a])."' /></td>
							<td><i onclick='espace.teams.updateMember({$teams[$i]["id"]}, {$a});' class='fa fa-save'></i>&nbsp;<i  onclick='espace.teams.deleteMember({$teams[$i]["id"]}, {$a});' class='fa fa-trash'></i></td>
						</tr>
					";
					
					if($a == count($members_team) - 1) echo "</tbody>";
				}
			}
			
			echo "
							
					</table>

					<div id='plus' onclick='espace.teams.addTeam();'><span><img src='public/images/news/plus.png' /></span></div>
				</div>
			";
		}
		
		protected static function showContentJeunes()
		{
			$request = new BDD();
			
			if(!$request->_isAdmin()) die("@error");
			
			echo "
				<div class='content' id='tab_jeunes'>
					<div>
						<span>
							Ajouter / Mettre à jour la plaquette du prochain tournoi Jeunes<br /><br /><input type='file' id='file1' name='file' /><br /><input onclick='espace.jeunes.upload_plaquette();' type='button' value='Uploader' /><br /><br /><o></o>
							Ajouter / Mettre à jour le calendrier des tournois Jeunes<br /><br /><input type='file' id='file2' name='file' /><br /><input onclick='espace.jeunes.upload_calendrier();' type='button' value='Uploader' /><br /><br /><p></p>
						</span>
					</div>
				</div>
			";
		}
		
		
		
		/*
		*
		* ACTIONS VIA LES ONGLETS
		*
		*/
		
		/* Mes informations */
		public static function updateInformationsAdress($params)
		{
			$params = base64_decode($params);
			
			$adress = explode(",", $params)[0];
			$postal = explode(",", $params)[1];
			$city = explode(",", $params)[2];
			
			$request = new BDD();
			
			if(!$request->_isLogged()) die("@error");
			
			$request->_request("UPDATE users SET adress = ?, postal = ?,city = ? WHERE token = ?", array($adress, $postal, $city, $_SESSION['session']['token']));
		}
		
		public static function updateInformationsMail($params)
		{
			$mail = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isLogged()) die("@error");
			
			$request->_request("UPDATE users SET mail = ? WHERE token = ?", array($mail, $_SESSION['session']['token']));
		}
		
		public static function updateInformationsPhone($params)
		{
			$phone = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isLogged()) die("@error");
			
			$request->_request("UPDATE users SET phone = ? WHERE token = ?", array($phone, $_SESSION['session']['token']));
		}
		
		public static function updateInformationsBirth($params)
		{
			$birth = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isLogged()) die("@error");
			
			$request->_request("UPDATE users SET birth = ? WHERE token = ?", array($birth, $_SESSION['session']['token']));
		}
		
		public static function updateInformationsPassword($params)
		{
			$mdp = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isLogged()) die("@error");
			
			$request->_request("UPDATE users SET password = ? WHERE token = ?", array(hash("sha512", $mdp), $_SESSION['session']['token']));
		}
		
		
		/* Gestion des adhérents */
		public static function updateMember($params)
		{
			$params = base64_decode($params);
			
			$id = explode(",", $params)[0];
			$inscription = explode(",", $params)[1];
			$civilité = explode(",", $params)[2];
			$name = explode(",", $params)[3];
			$surname = explode(",", $params)[4];
			$mail = explode(",", $params)[5];
			$phone = explode(",", $params)[6];
			$phone2 = explode(",", $params)[7];
			$adress = explode(",", $params)[8];
			$postal = explode(",", $params)[9];
			$city = explode(",", $params)[10];
			$type = explode(",", $params)[11];
			$seance = explode(",", $params)[12];
			$license = explode(",", $params)[13];
			$certif = explode(",", $params)[14];
			$isAdmin = explode(",", $params)[15];
			$isMod = explode(",", $params)[16];
			$isResponsable = explode(",", $params)[17];
			$isCA = explode(",", $params)[18];
			$attestation = explode(",", $params)[19];
			$type_paiement = explode(",", $params)[20];
			$carte_sas = explode(",", $params)[21];
			
			$request = new BDD();
			
			if(!$request->_isAdmin()) die("@error");
			
			$request->_request("UPDATE users SET inscription=?,civilité=?,name=?,surname=?,mail=?,phone=?,phone2=?,adress=?,postal=?,city=?,type=?,seance=?,license=?,certif=?,isAdmin=?,isMod=?,isResponsable=?,isCA=?,attestation=?,type_paiement=?,carte_sas=? WHERE id = ?", array(
				(int) filter_var($inscription, FILTER_VALIDATE_BOOLEAN), $civilité, $name, $surname, $mail, $phone, $phone2, $adress, $postal, $city, $type, $seance, $license, (int) filter_var($certif, FILTER_VALIDATE_BOOLEAN), (int) filter_var($isAdmin, FILTER_VALIDATE_BOOLEAN), (int) filter_var($isMod, FILTER_VALIDATE_BOOLEAN), (int) filter_var($isResponsable, FILTER_VALIDATE_BOOLEAN), (int) filter_var($isCA, FILTER_VALIDATE_BOOLEAN), (int) filter_var($attestation, FILTER_VALIDATE_BOOLEAN), $type_paiement, (int) filter_var($carte_sas, FILTER_VALIDATE_BOOLEAN), $id
			));
		}
		
		public static function deleteMember($params)
		{
			$id = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isAdmin()) die("@error");
			
			$request->_request("DELETE FROM users WHERE id = ?", array($id));
		}
		
		public static function addMember($params)
		{
			$params = base64_decode($params);
			
			$inscription = explode(",", $params)[0];
			$civilité = explode(",", $params)[1];
			$name = explode(",", $params)[2];
			$surname = explode(",", $params)[3];
			$mail = explode(",", $params)[4];
			$phone = explode(",", $params)[5];
			$phone2 = explode(",", $params)[6];
			$adress = explode(",", $params)[7];
			$postal = explode(",", $params)[8];
			$city = explode(",", $params)[9];
			$birth = explode(",", $params)[10];
			$type = explode(",", $params)[11];
			$seance = explode(",", $params)[12];
			$license = explode(",", $params)[13];
			$type_paiement = explode(",", $params)[14];
			$certif = explode(",", $params)[15];
			$isAdmin = explode(",", $params)[16];
			$isMod = explode(",", $params)[17];
			$isResponsable = explode(",", $params)[18];
			$isCA = explode(",", $params)[19];
			$attestation = explode(",", $params)[20];
			$carte_sas = explode(",", $params)[21];
			
			$request = new BDD();
			
			if(!$request->_isAdmin()) die("@error");
			
			$request->_request("INSERT INTO users (id,inscription,civilité,name,surname,mail,phone,phone2,adress,postal,city,birth,type,seance,license,type_paiement,certif,isAdmin,isMod,isResponsable,isCA,attestation,carte_sas,token,password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
				null,
				(int) filter_var($inscription, FILTER_VALIDATE_BOOLEAN),
				$civilité,
				$name,
				$surname,
				$mail,
				$phone,
				$phone2,
				$adress,
				$postal,
				$city,
				$birth,
				$type,
				$seance,
				$license,
				$type_paiement,
				(int) filter_var($certif, FILTER_VALIDATE_BOOLEAN),
				(int) filter_var($isAdmin, FILTER_VALIDATE_BOOLEAN),
				(int) filter_var($isMod, FILTER_VALIDATE_BOOLEAN),
				(int) filter_var($isResponsable, FILTER_VALIDATE_BOOLEAN),
				(int) filter_var($isCA, FILTER_VALIDATE_BOOLEAN),
				(int) filter_var($attestation, FILTER_VALIDATE_BOOLEAN),
				(int) filter_var($carte_sas, FILTER_VALIDATE_BOOLEAN),
				hash("sha512", microtime()),
				hash("sha512", $birth),
			));
			
			die("@ok");
		}
		
		public static function exportMembers()
		{
			$request = new BDD();
			
			if(!$request->_isAdmin()) die("@error");
			
			$members = $request->_request("SELECT * FROM users WHERE 1 ORDER BY name ASC", array());
			
			echo "
				<table>
					<tr>
						<th>Inscription ?</th>
						<th>Civilité</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Mail</th>
						<th>Téléphone</th>
						<th>Téléphone 2</th>
						<th>Adresse</th>
						<th>Code postal</th>
						<th>Ville</th>
						<th>Date de naissance</th>
						<th>Objectif</th>
						<th>Séance</th>
						<th>Licence</th>
						<th>Certificat</th>
						<th>Administrateur ?</th>
						<th>Modérateur ?</th>
						<th>Responsable séance ?</th>
						<th>Membre CA ?</th>
						<th>Attestation ?</th>
						<th>Paiement</th>
						<th>Carte SAS ?</th>
					</tr>
			";
			
			for($i = 0; $i < count($members); $i++)
			{
				echo "
					<tr>
						<td>{$members[$i]["inscription"]}</td>
						<td>{$members[$i]["civilité"]}</td>
						<td>{$members[$i]["name"]}</td>
						<td>{$members[$i]["surname"]}</td>
						<td>{$members[$i]["mail"]}</td>
						<td>{$members[$i]["phone"]}</td>
						<td>{$members[$i]["phone2"]}</td>
						<td>{$members[$i]["adress"]}</td>
						<td>{$members[$i]["postal"]}</td>
						<td>{$members[$i]["city"]}</td>
						<td>{$members[$i]["birth"]}</td>
						<td>{$members[$i]["type"]}</td>
						<td>{$members[$i]["seance"]}</td>
						<td>{$members[$i]["license"]}</td>
						<td>{$members[$i]["certif"]}</td>
						<td>{$members[$i]["isAdmin"]}</td>
						<td>{$members[$i]["isMod"]}</td>
						<td>{$members[$i]["isResponsable"]}</td>
						<td>{$members[$i]["isCA"]}</td>
						<td>{$members[$i]["attestation"]}</td>
						<td>{$members[$i]["type_paiement"]}</td>
						<td>{$members[$i]["carte_sas"]}</td>
					</tr>
				";	
			}
			
			echo "
				</table>
			";
		}
		
		public static function sendMail($params)
		{
			$params = base64_decode($params);
			
			$inscription = filter_var(explode("//////", $params)[0], FILTER_VALIDATE_BOOLEAN);
			$reinscription = filter_var(explode("//////", $params)[1], FILTER_VALIDATE_BOOLEAN);
			$hommes = filter_var(explode("//////", $params)[2], FILTER_VALIDATE_BOOLEAN);
			$dames = filter_var(explode("//////", $params)[3], FILTER_VALIDATE_BOOLEAN);
			$moins_9 = filter_var(explode("//////", $params)[4], FILTER_VALIDATE_BOOLEAN);
			$jeune = filter_var(explode("//////", $params)[5], FILTER_VALIDATE_BOOLEAN);
			$loisir = filter_var(explode("//////", $params)[6], FILTER_VALIDATE_BOOLEAN);
			$competition = filter_var(explode("//////", $params)[7], FILTER_VALIDATE_BOOLEAN);
			$title = explode("//////", $params)[8];
			$content = explode("//////", $params)[9];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isResp()) die("@error");
			
			$arg1 = ($inscription) ? "1" : "null";
			$arg2 = ($reinscription) ? "0" : "null";
			$arg3 = ($hommes) ? "M" : "null";
			$arg4 = ($dames) ? "Mme" : "null";
			$arg5 = ($moins_9) ? "-9ANS" : "null";
			$arg6 = ($jeune) ? "JEUNE" : "null";
			$arg7 = ($loisir) ? "LOISIR" : "null";
			$arg8 = ($competition) ? "COMPETITION" : "null";
			
			// Construction de la requête SQL			
			$mails = $request->_request(
				"SELECT mail FROM users WHERE (inscription = $arg1 OR inscription = $arg2) AND (civilité = '$arg3' OR civilité = '$arg4') AND (type = '$arg5' OR type = '$arg6' OR type = '$arg7' OR type = '$arg8')",
				array()
			);
			
			$liste_diffusion = "";
			
			for($i = 0; $i < count($mails); $i++)
			{
				$liste_diffusion .= $mails[$i]["mail"].",";
			}
			
			// Liste finale de diffusion
			$liste_diffusion = rtrim($liste_diffusion,", ");
			
			// Envoi du mail
			$to = $liste_diffusion;
			$subject = htmlspecialchars($title);
			$message = htmlspecialchars($content);
			$headers = 	'From: sasbad@hotmail.fr' . "\r\n" .
    					'Reply-To: webmaster@example.com' . "\r\n" .
    					'X-Mailer: PHP/' . phpversion();
			
			// Ne fonctionne pas en local (à tester sur un domaine)
			mail($to, $subject, $message, $headers);
		}
		
		
		/* Gestion des dates importantes */
		public static function addDate($params)
		{
			$params = base64_decode($params);
			
			$name = explode("//////", $params)[0];
			$date = explode("//////", $params)[1];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA()) die("@error");
			
			$request->_request("INSERT INTO dates (id, name, date) VALUES (?, ?, ?)", array(null, $name, $date));
		}
		
		public static function updateDate($params)
		{
			$params = base64_decode($params);
			
			$id = explode("//////", $params)[0];
			$name = explode("//////", $params)[1];
			$date = explode("//////", $params)[2];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA()) die("@error");
			
			$request->_request("UPDATE dates SET name = ?, date = ? WHERE id = ?", array($name, $date, $id));
		}
		
		public static function deleteDate($params)
		{
			$id = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA()) die("@error");
			
			$request->_request("DELETE FROM dates WHERE id = ?", array($id));
		}
		
		
		/* Gestion des équipes */
		public static function addTeam($params)
		{
			$params = base64_decode($params);
			
			$name = explode("//////", $params)[0];
			$members = explode("//////", $params)[1];
			$classements = explode("//////", $params)[2];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$request->_request("INSERT INTO teams (id, name, players, classements) VALUES (?, ?, ?, ?)", array(null, htmlspecialchars($name), $members, $classements));
		}
		
		public static function deleteTeam($params)
		{
			$id = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$request->_request("DELETE FROM teams WHERE id = ?", array($id));
			$request->_request("DELETE FROM matches WHERE team_id = ?", array($id));
		}
		
		public static function addTeamMember($params)
		{
			$params = base64_decode($params);
			
			$id = explode("//////", $params)[0];
			$name = explode("//////", $params)[1];
			$classements = explode("//////", $params)[2];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$request->_request("UPDATE teams SET players = CONCAT(players, ?), classements = CONCAT(classements, ?) WHERE id = ?", array(",$name", ",$classements", $id));
		}
		
		public static function updateTeamMember($params)
		{
			$params = base64_decode($params);
			
			$id = explode("//////", $params)[0];
			$pos = explode("//////", $params)[1];
			$classement = explode("//////", $params)[2];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			// Récupération des classements
			$classements = $request->_request("SELECT classements FROM teams WHERE id = ?", array($id));
			$classements = explode(",", $classements[0]["classements"]);
			
			$classements[$pos] = $classement;
			
			$classements = implode(",", $classements);
			
			$request->_request("UPDATE teams SET classements = ? WHERE id = ?", array($classements, $id));
		}
		
		public static function deleteTeamMember($params)
		{
			$params = base64_decode($params);
			
			$id = explode("//////", $params)[0];
			$pos = explode("//////", $params)[1];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$team = $request->_request("SELECT players,classements FROM teams WHERE id = ?", array($id));
			
			$players = explode(",", $team[0]["players"]);
			$classements = explode(",", $team[0]["classements"]);
			
			unset($players[$pos]);
			unset($classements[$pos]);
			
			$players = implode(",", $players);
			$classements = implode(",", $classements);
			
			$request->_request("UPDATE teams SET players = ?, classements = ? WHERE id = ?", array($players, $classements, $id));
		}
		
		
		/* Gestion des matches */
		public static function addMatch($params)
		{
			$params = base64_decode($params);
			
			$id = explode("//////", $params)[0];
			$name = explode("//////", $params)[1];
			$type = explode("//////", $params)[2];
			$date = explode("//////", $params)[3];
			$receive = explode("//////", $params)[4];
			$isVictory = explode("//////", $params)[5];
			$news = explode("//////", $params)[6];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$news = ($news == "") ? NULL : $news;
			
			$request->_request("INSERT INTO matches (id, team_id, name, receive, news_id, type, isVictory, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(null, $id, $name, (int) filter_var($receive, FILTER_VALIDATE_BOOLEAN), $news, $type, $isVictory, $date));
		}
		
		public static function updateMatch($params)
		{
			$params = base64_decode($params);
			
			$id = explode("//////", $params)[0];
			$name = explode("//////", $params)[1];
			$type = explode("//////", $params)[2];
			$date = explode("//////", $params)[3];
			$receive = explode("//////", $params)[4];
			$isVictory = explode("//////", $params)[5];
			$news = explode("//////", $params)[6];
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$news = ($news == "") ? NULL : $news;
			
			$request->_request("UPDATE matches SET name=?, receive=?, news_id=?, type=?, isVictory=?, date=? WHERE id = ?", array($name, (int) filter_var($receive, FILTER_VALIDATE_BOOLEAN), (int) $news, $type, (int) $isVictory, $date, $id));
		}
		
		public static function deleteMatch($params)
		{
			$id = base64_decode($params);
			
			$request = new BDD();
			
			if(!$request->_isAdmin() && !$request->_isCA() && !$request->_isMod()) die("@error");
			
			$request->_request("DELETE FROM matches WHERE id = ?", array($id));
		}
		
		/* Connexion */
		public static function connect($params)
		{
			$params = base64_decode($params);
			
			$mail = explode(",", $params)[0];
			$password = explode(",", $params)[1];
			
			$request = new BDD();
			
			if($request->_isLogged()) die("@error");
			
			$return = $request->_request("SELECT * FROM users WHERE mail = ? AND password = ?", array($mail, hash("sha512", $password)));
			
			if(count($return) == 1)
			{
				$_SESSION["session"] = array(
					"name" => $return[0]["name"],
					"surname" => $return[0]["surname"],
					"mail" => $return[0]["mail"],
					"token" => $return[0]["token"],
					"isAdmin" => (bool) filter_var($return[0]["isAdmin"], FILTER_VALIDATE_BOOLEAN),
					"isMod" => (bool) filter_var($return[0]["isMod"], FILTER_VALIDATE_BOOLEAN),
					"isResponsable" => (bool) filter_var($return[0]["isResponsable"], FILTER_VALIDATE_BOOLEAN),
					"isCA" => (bool) filter_var($return[0]["isCA"], FILTER_VALIDATE_BOOLEAN)
				);
				
				die("@ok");
			}
		}
	}
?>
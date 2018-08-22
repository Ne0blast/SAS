var espace = 
{
	init: function(index="")
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				document.querySelector("#espace").innerHTML = xhr.responseText;
				
				switch(index)
				{
					case "members":
						espace.trigger("members");
						break;
						
					case "dates":
						espace.trigger("dates");
						break;
						
					case "teams":
						espace.trigger("teams");
						break;
						
					case "matches":
						espace.trigger("matches");
						break;
						
					case "tournaments":
						espace.trigger("tournaments");
						break;
						
					default:
						break;
				}
			}
		}
		
		xhr.send("module=espace&action=viewPanel");
	},
	
	connect: function()
	{
		var mail = document.querySelectorAll("#connect input")[0].value;
		var password = document.querySelectorAll("#connect input")[1].value;
		
		var args = [mail, password].join(",");
        
        document.querySelector("#connect o").innerHTML = "Connexion en cours...";
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				if(xhr.responseText == "@ok")
				{
					espace.init();	
				}
				else
				{
					document.querySelector("#connect o").innerHTML = "Un erreur est survenue lors de la connexion";
				}
			}
		}
		
		xhr.send("module=espace&action=connect&params=" + args);
	},
	
	trigger: function(id)
	{
		for(var i = 0; i < document.querySelectorAll("#tabs span").length; i++)
		{
			document.querySelectorAll("#tabs span")[i].classList.remove("selected");
			document.querySelectorAll("#content_tabs .content")[i].classList.remove("selected");
		}
		
		document.querySelector("#menu_" + id).classList.add("selected");
		document.querySelector("#tab_" + id).classList.add("selected");
	},
	
	informations:
	{
		submitAdress: function()
		{
			var adress = document.querySelectorAll("#tab_informations input")[0].value;
			var postal = document.querySelectorAll("#tab_informations input")[1].value;
			var city = document.querySelectorAll("#tab_informations input")[2].value;
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("module=espace&action=updateInformationsAdress&params=" + [adress,postal,city].join(","));
		},
		
		submitMail: function()
		{
			var mail = document.querySelectorAll("#tab_informations input")[3].value;
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("module=espace&action=updateInformationsMail&params=" + mail);
		},
		
		submitPhone: function()
		{
			var phone = document.querySelectorAll("#tab_informations input")[4].value;
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("module=espace&action=updateInformationsPhone&params=" + phone);
		},
		
		submitBirth: function()
		{
			var birth = document.querySelectorAll("#tab_informations input")[5].value;
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("module=espace&action=updateInformationsBirth&params=" + birth);
		},
		
		submitPassword: function()
		{
			var password = document.querySelectorAll("#tab_informations input")[6].value;
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("module=espace&action=updateInformationsPassword&params=" + password);
		}
	},
	
	members:
	{
		add: function()
		{
			document.querySelector("#popup").style = "transform:scale(1);opacity:1";
			
			document.querySelector("#popup .title span").innerHTML = "Ajouter un nouvel adhérent";
			document.querySelector("#popup .content span").innerHTML = `
				<i class='fa fa-user'></i> Inscription ? : <input type='checkbox' /><br />
				<i class='fa fa-user'></i> Civilité : <input type='text' placeholder='Civilité...' /><br />
				<i class='fa fa-user'></i> Nom : <input type='text' placeholder='Nom...' /><br />
				<i class='fa fa-user'></i> Prénom : <input type='text' placeholder='Prénom...' /><br />
				<i class='fa fa-envelope'></i> Mail : <input type='text' placeholder='Mail...' /><br />
				<i class='fa fa-phone'></i> Téléphone : <input type='text' placeholder='Téléphone...' /><br />
				<i class='fa fa-phone'></i> Téléphone 2 : <input type='text' placeholder='Téléphone 2...' /><br />
				<i class='fa fa-home'></i> Adresse : <input type='text' placeholder='Adresse...' /><br />
				<i class='fa fa-home'></i> Code postal : <input type='text' placeholder='Code postal...' value='' /><br />
				<i class='fa fa-home'></i> Ville : <input type='text' placeholder='Ville...' value='' /><br />
				<i class='fa fa-birthday-cake'></i> Date de naissance : <input type='text' placeholder='Date de naissance...' /><br />
				<i class='fa fa-id-card'></i> Objectif : <input type='text' placeholder='-9ANS - JEUNE - LOISIR - COMPETITION' /><br />
				<i class='fa fa-calendar'></i> Séance : <select>
					<option value='COMPETITION'>COMPETITION</option>
					<option value='JEUNE'>JEUNE</option>
					<option value='BABY'>BABY BAD SAMEDI</option>
					<option value='MINI/POUSSINS'>MINI BAD et POUSSINS MERCREDI</option>
					<option value='BENJAMINS/MINIMES'>BENJAMINS et MINIMES MERCREDI</option>
					<option value='LOISIR LUNDI OA'>LOISIR LUNDI ONZE ARPENTS</option>
					<option value='LOISIR LUNDI CF'>LOISIR LUNDI CHATEAU FRAISIER</option>
					<option value='LOISIR MARDI CF'>LOISIR MARDI CHATEAU FRAISIER</option>
					<option value='LOISIR MERCREDI CF'>LOISIR MERCREDI CHATEAU FRAISIER</option>
					<option value='LOISIR MERCREDI CF'>LOISIR MERCREDI CHATEAU FRAISIER</option>
					<option value='LOISIR SAMEDI CF'>LOISIR SAMEDI CHATEAU FRAISIER</option>
				</select><br />
				<i class='fa fa-file-text'></i> Licence : <input type='text' placeholder='Licence...' /><br />
				<i class='fa fa-money'></i> Type de paiement ? : <input type='text' placeholder='CHEQUE - LIQUIDE' /><br />
				<i class='fa fa-certificate'></i> Certificat : <input type='checkbox' /><br />
				<i class='fa fa-lock'></i> Administrateur ? / Modérateur ? / Responsable séance ? / Membre CA ? : <input type='checkbox' /> <input type='checkbox' /> <input type='checkbox' /> <input type='checkbox' /><br />
				<i class='fa fa-money'></i> Attestation de paiement ? : <input type='checkbox' /><br />
				<i class='fa fa-money'></i> Carte SAS ? : <input type='checkbox' /><br />
				<button onclick='espace.members.addMember();'>Ajouter</button>&nbsp;<button onclick='document.querySelector("#popup").style = "transform:scale(0);opacity:0";'>Fermer</button>
			`;
		},
		
		mail: function()
		{
			document.querySelector("#popup").style = "transform:scale(1);opacity:1";
			
			document.querySelector("#popup .title span").innerHTML = "Envoyer un mail à ";
			document.querySelector("#popup .content span").innerHTML = `
				<b>NOUVEAU ?</b> Nouvelle inscription <input type="checkbox" checked /> Réinscription <input type="checkbox" checked /><br />
				<b>CIVILITE ?</b> Hommes <input type="checkbox" checked /> Dames <input type="checkbox" checked /><br />
				<b>OBJECTIF ?</b> -9ans <input type="checkbox" /> Jeunes <input type="checkbox" checked /> Loisirs <input type="checkbox" checked /> Compétiteurs <input type="checkbox" checked /><br /><br /><br />
				<input style="text-align: center;width: 100%;padding-left:0;margin-left:0;" type="text" placeholder="Titre du mail..." /><br />
				<textarea style="width: 100%;height: 40vh;" placeholder="Contenu du mail..."></textarea><br />
				<button onclick='espace.members.sendMail();'>Envoyer</button>&nbsp;<button onclick='document.querySelector("#popup").style = "transform:scale(0);opacity:0";'>Fermer</button>
			`;
		},
		
		sendMail: function()
		{
			var inscription = document.querySelectorAll("#popup input")[0].checked;
			var reinscription = document.querySelectorAll("#popup input")[1].checked;
			var hommes = document.querySelectorAll("#popup input")[2].checked;
			var dames = document.querySelectorAll("#popup input")[3].checked;
			var moins_9 = document.querySelectorAll("#popup input")[4].checked;
			var jeune = document.querySelectorAll("#popup input")[5].checked;
			var loisir = document.querySelectorAll("#popup input")[6].checked;
			var competition = document.querySelectorAll("#popup input")[7].checked;
			var title = document.querySelectorAll("#popup input")[8].value;
			var content = document.querySelector("#popup textarea").value;
			
			var args = [inscription,reinscription,hommes,dames,moins_9,jeune,loisir,competition,title,content].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					if(xhr.responseText == "@ok")
					{
						document.querySelector("#popup").style = "transform:scale(0);opacity:0";
						
						espace.init("members");
					}
				}
			}
			xhr.send("module=espace&action=sendMail&params=" + args);
		},
		
		addMember: function()
		{
			var inscription = document.querySelectorAll("#popup .content input")[0].checked;
			var civilité = document.querySelectorAll("#popup .content input")[1].value;
			var name = document.querySelectorAll("#popup .content input")[2].value;
			var surname = document.querySelectorAll("#popup .content input")[3].value;
			var mail = document.querySelectorAll("#popup .content input")[4].value;
			var phone = document.querySelectorAll("#popup .content input")[5].value;
			var phone2 = document.querySelectorAll("#popup .content input")[6].value;
			var adress = document.querySelectorAll("#popup .content input")[7].value;
			var postal = document.querySelectorAll("#popup .content input")[8].value;
			var city = document.querySelectorAll("#popup .content input")[9].value;
			var birth = document.querySelectorAll("#popup .content input")[10].value;
			var type = document.querySelectorAll("#popup .content input")[11].value;
			var seance = document.querySelector("#popup .content select").options[document.querySelector("#popup .content select").selectedIndex].value;
			var license = document.querySelectorAll("#popup .content input")[12].value;
			var type_paiement = document.querySelectorAll("#popup .content input")[13].checked;
			var certif = document.querySelectorAll("#popup .content input")[14].checked;
			var isAdmin = document.querySelectorAll("#popup .content input")[15].checked;
			var isMod = document.querySelectorAll("#popup .content input")[16].checked;
			var isResponsable = document.querySelectorAll("#popup .content input")[17].checked;
			var isCA = document.querySelectorAll("#popup .content input")[18].checked;
			var attestation = document.querySelectorAll("#popup .content input")[19].checked;
			var carte_sas = document.querySelectorAll("#popup .content input")[20].checked;
			
			var args = [inscription,civilité,name,surname,mail,phone,phone2,adress,postal,city,birth,type,seance,license,type_paiement,certif,isAdmin,isMod,isResponsable,isCA,attestation,carte_sas].join(",");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					if(xhr.responseText == "@ok")
					{
						document.querySelector("#popup").style = "transform:scale(0);opacity:0";
						
						espace.init("members");
					}
				}
			}
			xhr.send("module=espace&action=addMember&params=" + args);
		},
		
		update: function(id)
		{
			var inscription = document.querySelectorAll("#member_" + id + " input")[0].checked;
			var civilité = document.querySelectorAll("#member_" + id + " input")[1].value;
			var name = document.querySelectorAll("#member_" + id + " input")[2].value;
			var surname = document.querySelectorAll("#member_" + id + " input")[3].value;
			var mail = document.querySelectorAll("#member_" + id + " input")[4].value;
			var phone = document.querySelectorAll("#member_" + id + " input")[5].value;
			var phone2 = document.querySelectorAll("#member_" + id + " input")[6].value;
			var adress = document.querySelectorAll("#member_" + id + " input")[7].value;
			var postal = document.querySelectorAll("#member_" + id + " input")[8].value;
			var city = document.querySelectorAll("#member_" + id + " input")[9].value;
			var type = document.querySelectorAll("#member_" + id + " input")[10].value;
			var seance = document.querySelectorAll("#member_" + id + " input")[11].value;
			var license = document.querySelectorAll("#member_" + id + " input")[12].value;
			var certif = document.querySelectorAll("#member_" + id + " input")[13].checked;
			var isAdmin = document.querySelectorAll("#member_" + id + " input")[14].checked;
			var isMod = document.querySelectorAll("#member_" + id + " input")[15].checked;
			var isResponsable = document.querySelectorAll("#member_" + id + " input")[16].checked;
			var isCA = document.querySelectorAll("#member_" + id + " input")[17].checked;
			var attestation = document.querySelectorAll("#member_" + id + " input")[18].checked;
			var type_paiement = document.querySelectorAll("#member_" + id + " input")[19].value;
			var carte_sas = document.querySelectorAll("#member_" + id + " input")[20].checked;
			
			var args = [id,inscription,civilité,name,surname,mail,phone,phone2,adress,postal,city,type,seance,license,certif,isAdmin,isMod,isResponsable,isCA,attestation,type_paiement,carte_sas].join(",");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("module=espace&action=updateMember&params=" + args);
		},
		
		delete: function(id)
		{
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("members");
				}
			}
			xhr.send("module=espace&action=deleteMember&params=" + id);
		},
		
		export: function()
		{
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					console.log(xhr.responseText);
					
					var date = new Date();
					var month = parseInt(date.getMonth()) + 1;
					var year = date.getFullYear();
					
					var file = new File([xhr.responseText], "liste_adhérents_sas_badminton_" + month + "_" + year + ".xls", {type: "text/html;charset=utf-8"});
					
					saveAs(file);
				}
			}
			xhr.send("module=espace&action=exportMembers");
		}
	},
	
	dates:
	{
		add: function()
		{
			document.querySelector("#popup").style = "transform:scale(1);opacity:1;";
			
			document.querySelector("#popup .title span").innerHTML = "Ajouter une date";
			document.querySelector("#popup .content span").innerHTML = `
				Evènement associé à la date : <input type='text' placeholder='Nom...' /><br /><br />
				Date : <input type='text' placeholder='Date...' /><br /><br /><br /><br />
				<button onclick='espace.dates.addDate();'>Ajouter</button>&nbsp;<button onclick='document.querySelector("#popup").style = "transform:scale(0);opacity:0";'>Fermer</button>
			`;
		},
		
		addDate: function()
		{
			var name = document.querySelectorAll("#popup input")[0].value;
			var date = document.querySelectorAll("#popup input")[1].value;
			
			var args = [name,date].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("dates");
					
					document.querySelector("#popup").style = "transform:scale(0);opacity:0";
				}
			}
			xhr.send("module=espace&action=addDate&params=" + args);
		},
		
		save: function(id)
		{
			var name = document.querySelectorAll("#date_" + id + " input")[0].value;
			var date = document.querySelectorAll("#date_" + id + " input")[1].value;
			
			var args = [id,name,date].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("dates");
				}
			}
			xhr.send("module=espace&action=updateDate&params=" + args);
		},
		
		delete: function(id)
		{
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("dates");
				}
			}
			xhr.send("module=espace&action=deleteDate&params=" + id);
		}
	},
	
	teams:
	{
		addTeam: function()
		{
			document.querySelector("#popup").style = "transform:scale(1);opacity:1;";
			
			document.querySelector("#popup .title span").innerHTML = "Ajouter une équipe";
			document.querySelector("#popup .content span").innerHTML = `
				Nom de l&apos;équipe / Catégorie de l&apos;équipe : <br /><br />
				<input style='margin-left:0;padding-left:0;width: 100%;text-align:center;' type='text' placeholder='Nom de l&apos;équipe / Catégorie de l&apos;équipe' /><br /><br />
				Membres de l'équipe (séparé par un saut de ligne) : <br /><br />
				<textarea style='margin-left:0;padding-left:0;width: 100%;height: 20vh;'>Joueur1\njoueur2\njoueur3</textarea><br /><br />
				Classements des membres de l'équipe (séparé par un saut de ligne) : <br /><br />
				<textarea style='margin-left:0;padding-left:0;width: 100%;height: 20vh;'>nc/nc/nc\np12/p12/p11\nn3/n3/n2</textarea><br /><br />
				<button onclick='espace.teams.addNewTeam();'>Ajouter</button>&nbsp;<button onclick='document.querySelector("#popup").style = "transform:scale(0);opacity:0";'>Fermer</button>
			`;
		},
		
		addMember: function(id)
		{
			document.querySelector("#popup").style = "transform:scale(1);opacity:1;";
			
			document.querySelector("#popup .title span").innerHTML = "Ajouter un membre";
			document.querySelector("#popup .content span").innerHTML = `
				Prénom du membre : <br /><br />
				<input style='margin-left:0;padding-left:0;width: 100%;text-align:center;' type='text' placeholder='Prénom' /><br /><br />
				Classements : <br /><br />
				<input style='margin-left:0;padding-left:0;width: 100%;text-align:center;' type='text' placeholder='NC/NC/NC' /><br /><br />
				<button onclick='espace.teams.addNewMember(${id});'>Ajouter</button>&nbsp;<button onclick='document.querySelector("#popup").style = "transform:scale(0);opacity:0";'>Fermer</button>
			`;
		},
		
		addNewTeam: function()
		{
			var name = document.querySelector("#popup input").value;
			var members = document.querySelectorAll("#popup textarea")[0].value.split("\n").join(",");
			var classements = document.querySelectorAll("#popup textarea")[1].value.split("\n").join(",");
			
			var args = [name,members,classements].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("teams");
					
					document.querySelector("#popup").style = "transform:scale(0);opacity:0";
				}
			}
			xhr.send("module=espace&action=addTeam&params=" + args);
		},
		
		deleteTeam: function(id)
		{
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("teams");
				}
			}
			xhr.send("module=espace&action=deleteTeam&params=" + id);
		},
		
		addNewMember(id)
		{
			var name = document.querySelectorAll("#popup input")[0].value;
			var classements = document.querySelectorAll("#popup input")[1].value;
			
			var args = [id, name, classements].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("teams");
					
					document.querySelector("#popup").style = "transform:scale(0);opacity:0";
				}
			}
			xhr.send("module=espace&action=addTeamMember&params=" + args);
		},
		
		updateMember: function(id_team, pos_member)
		{
			var classement = document.querySelector("#member_" + id_team + "_" + pos_member + " input").value;
			
			var args = [id_team, pos_member, classement].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("teams");
				}
			}
			xhr.send("module=espace&action=updateTeamMember&params=" + args);
		},
		
		deleteMember: function(id_team, pos_member)
		{
			var args = [id_team, pos_member].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("teams");
				}
			}
			xhr.send("module=espace&action=deleteTeamMember&params=" + args);
		}
	},
	
	matches:
	{
		add: function(id)
		{
			document.querySelector("#popup").style = "transform:scale(1);opacity:1;";
			
			document.querySelector("#popup .title span").innerHTML = "Ajouter un match";
			document.querySelector("#popup .content span").innerHTML = `
				Adversaire : <br /><br />
				<input type='text' placeholder='Adversaire...' /><br /><br />
				Type de la rencontre : <br /><br />
				<input type='text' placeholder='POULE - 1/16F - 1/8F - 1/4F - 1/2F - F' /><br /><br />
				Date de la rencontre : <br /><br />
				<input type='text' placeholder='Date de la rencontre...' /><br /><br />
				A domicile ? <input type='checkbox' /><br /><br />
				Victoire ? <br /><br />
				<select>
					<option value='0'>Non</option>
					<option value='1'>Oui</option>
					<option value='2' selected>Pas encore joué</option>
				</select><br /><br />
				News associée ? <br /><br />
				<input type='text' placeholder='Numéro de la news...' /><br /><br />
				<button onclick='espace.matches.addMatch(${id});'>Ajouter</button>&nbsp;<button onclick='document.querySelector("#popup").style = "transform:scale(0);opacity:0";'>Fermer</button>
			`;
		},
		
		addMatch: function(id)
		{
			var name = document.querySelectorAll("#popup input")[0].value;
			var type = document.querySelectorAll("#popup input")[1].value;
			var date = document.querySelectorAll("#popup input")[2].value;
			var receive = document.querySelectorAll("#popup input")[3].checked;
			var isVictory = document.querySelector("#popup select").options[document.querySelector("#popup select").selectedIndex].value;
			var news = document.querySelectorAll("#popup input")[4].value;
			
			var args = [id,name,type,date,receive,isVictory,news].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("matches");
					
					document.querySelector("#popup").style = "transform:scale(0);opacity:0";
				}
			}
			xhr.send("module=espace&action=addMatch&params=" + args);
		},
		
		update: function(id)
		{
			var type = document.querySelectorAll("#match_" + id + " input")[0].value;
			var name = document.querySelectorAll("#match_" + id + " input")[1].value;
			var receive = document.querySelectorAll("#match_" + id + " input")[2].checked;
			var isVictory = document.querySelectorAll("#match_" + id + " input")[3].value;
			var news = document.querySelectorAll("#match_" + id + " input")[4].value;
			var date = document.querySelectorAll("#match_" + id + " input")[5].value;
			
			var args = [id,name,type,date,receive,isVictory,news].join("//////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("matches");
				}
			}
			xhr.send("module=espace&action=updateMatch&params=" + args);
		},
		
		delete: function(id)
		{			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					espace.init("matches");
				}
			}
			xhr.send("module=espace&action=deleteMatch&params=" + id);
		}
	},
	
	jeunes:
	{
		upload_plaquette: function()
		{
			var file_upload = document.querySelector("#file1");
		
			if(file_upload.files.length != 0)
			{
				var data = new FormData();

				data.append("plaquette_jeunes", "true");

				for(var i = 0; i < file_upload.files.length; i++)
				{				
					data.append("file", file_upload.files[i], file_upload.files[i]["name"]);
				}

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "core/uploader.php", true);

				xhr.onreadystatechange = function()
				{
					if(xhr.status == 200 && xhr.readyState == 4)
					{
						document.querySelector("#tab_jeunes o").innerHTML = "La plaquette a été changée avec succès !";
					}
				}

				xhr.send(data);
			}
		},
		
		upload_calendrier: function()
		{
			var file_upload = document.querySelector("#file2");
		
			if(file_upload.files.length != 0)
			{
				var data = new FormData();

				data.append("calendrier_jeunes", "true");

				for(var i = 0; i < file_upload.files.length; i++)
				{				
					data.append("file", file_upload.files[i], file_upload.files[i]["name"]);
				}

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "core/uploader.php", true);

				xhr.onreadystatechange = function()
				{
					if(xhr.status == 200 && xhr.readyState == 4)
					{
						document.querySelector("#tab_jeunes p").innerHTML = "Le calendrier a été changé avec succès !";
					}
				}

				xhr.send(data);
			}
		},
	}
};
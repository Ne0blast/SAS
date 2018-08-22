var tournaments = 
{
	init: function()
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				var data = JSON.parse(xhr.responseText);
				var table = document.querySelector("table");
				
				var counter = 0;
				
				for(k in data)
				{
					if(counter == 14) break; // Affichage des 14 premiers tournois afin de ne pas surcharger la page
					
					table.innerHTML += `
						<tr>
							<td style='width: 15vw;'><a href='#' onclick='window.open(\"${data[k]["link_badiste"]}\");'>${data[k]["name"]}</a></td>
							<td style='width: 5vw;'>${data[k]["date"]}</td>
							<td style='width: 3vw;'>${data[k]["duration"]}</td>
							<td style='width: 5vw;'>${data[k]["categories"].join(", ")}</td>
							<td>${data[k]["tables"].join(", ")}</td>
							<td style='width: 5vw;'>${data[k]["limit"]}</td>
							<td><button onclick='tournaments.register(\"${data[k]["name"]}\", \"${data[k]["date"]}\");'>S'inscrire</button>&nbsp;<button onclick='tournaments.players(\"${data[k]["name"]}\");'>Qui participe ?</button></td>
						</tr>
					`;
					
					counter++;
				}
			}
		}
		
		xhr.send("module=tournaments&action=getAllTournaments");
	},
	
	register: function(name, date)
	{
		document.location.href = "#page2";
		
		document.querySelector("#tournament_name span").innerHTML = `<b>${name}</b> (${date})`;
	},
	
	players: function(name)
	{
		document.location.href = "#page3";
		
		document.querySelector("#page3 #tournament_name span").innerHTML = name;
		
		// Nettoyage du tableau
		for(var i = 0; i < document.querySelectorAll(".players").length; i++)
		{
			document.querySelectorAll(".players")[i].parentNode.removeChild(document.querySelectorAll(".players")[i]);
		}
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				var data = JSON.parse(xhr.responseText);
				
				for(var i = 0; i < data.length; i++)
				{
					var line = `
						<tr class='players'>
							<td>${data[i]["player_license"]}</td>
							<td>${data[i]["player_name"]}</td>
							<td>${data[i]["player_surname"]}</td>
							<td>${data[i]["player_rankingSimple"]}</td>
							<td>${data[i]["player_rankingDouble"]}</td>
							<td>${data[i]["player_rankingMixte"]}</td>
							<td>${data[i]["simple_category"]}</td>
							<td>${data[i]["double_category"]}</td>
							<td>${data[i]["double_partnerLicense"]}</td>
							<td>${data[i]["double_partnerName"]}</td>
							<td>${data[i]["double_partnerSurname"]}</td>
							<td>${data[i]["mixte_partnerRanking"]}</td>
							<td>${data[i]["mixte_category"]}</td>
							<td>${data[i]["mixte_partnerLicense"]}</td>
							<td>${data[i]["mixte_partnerName"]}</td>
							<td>${data[i]["mixte_partnerSurname"]}</td>
							<td>${data[i]["mixte_partnerRanking"]}</td>
						</tr>
					`;
					
					document.querySelector("#players table").innerHTML += line;
				}
			}
		}
		
		xhr.send("module=tournaments&action=viewPlayers&params=" + btoa(decodeURIComponent(name)));
	},
	
	checkboxes:
	{
		trigger: function(element)
		{
			var status = element.parentNode.parentNode.disabled;
			
			if(status)
			{
				element.parentNode.parentNode.disabled = false;
			}
			else
			{
				element.parentNode.parentNode.disabled = true;
			}
		},
		
		init: function()
		{
			document.querySelectorAll("input")[3].checked = true;
			document.querySelectorAll("input")[4].checked = true;
			document.querySelectorAll("input")[8].checked = true;
		}
	},
	
	saveRegistration: function()
	{
		// Récupération des données (il y en a pas mal)
		
		// Informations sur le joueur
		var license_player = document.querySelectorAll("input")[0].value;
		var name_player = document.querySelectorAll("input")[1].value;
		var surname_player = document.querySelectorAll("input")[2].value;
		var rankingSimple_player = document.querySelectorAll("select")[0].options[document.querySelectorAll("select")[0].selectedIndex].value;
		var rankingDouble_player = document.querySelectorAll("select")[1].options[document.querySelectorAll("select")[1].selectedIndex].value;
		var rankingMixte_player = document.querySelectorAll("select")[2].options[document.querySelectorAll("select")[2].selectedIndex].value;
		
		// Informations sur les partenaires et les tableaux joués
		var status_simple = document.querySelectorAll("input")[3].checked;
		var status_double = document.querySelectorAll("input")[4].checked;
		var status_mixte = document.querySelectorAll("input")[8].checked;
		
		// Arguments
		var args = 
		{
			hash: "",
			tournament: {},
			player: {},
			simple: {},
			double: {},
			mixte: {}
		};
		
		args.tournament.name = encodeURIComponent(document.querySelector("#page2 #tournament_name span b").innerHTML);
		args.hash = btoa(document.querySelector("#page2 #tournament_name span b").innerHTML);
		
		args.player.license = license_player;
		args.player.name = name_player;
		args.player.surname = surname_player;
		args.player.rankingSimple = rankingSimple_player;
		args.player.rankingDouble = rankingDouble_player;
		args.player.rankingMixte = rankingMixte_player;
		
		// Si le joueur fait du simple
		if(status_simple)
		{
			args.simple.category = document.querySelectorAll("select")[3].options[document.querySelectorAll("select")[3].selectedIndex].value;
		}
		
		// Si le joueur fait du double
		if(status_double)
		{
			var doubleCategory = document.querySelectorAll("select")[4].options[document.querySelectorAll("select")[4].selectedIndex].value;
			var doublePartnerLicense = document.querySelectorAll("input")[5].value;
			var doublePartnerName = document.querySelectorAll("input")[6].value;
			var doublePartnerSurname = document.querySelectorAll("input")[7].value;
			var doublePartnerRanking = document.querySelectorAll("select")[5].options[document.querySelectorAll("select")[5].selectedIndex].value;
			
			args.double.category = doubleCategory;
			args.double.license = doublePartnerLicense;
			args.double.name = doublePartnerName;
			args.double.surname = doublePartnerSurname;
			args.double.ranking = doublePartnerRanking;
		}
		
		// Si le joueur fait du mixte
		if(status_mixte)
		{
			var mixteCategory = document.querySelectorAll("select")[6].options[document.querySelectorAll("select")[6].selectedIndex].value;
			var mixtePartnerLicense = document.querySelectorAll("input")[9].value;
			var mixtePartnerName = document.querySelectorAll("input")[10].value;
			var mixtePartnerSurname = document.querySelectorAll("input")[11].value;
			var mixtePartnerRanking = document.querySelectorAll("select")[7].options[document.querySelectorAll("select")[7].selectedIndex].value;
			
			args.mixte.category = mixteCategory;
			args.mixte.license = mixtePartnerLicense;
			args.mixte.name = mixtePartnerName;
			args.mixte.surname = mixtePartnerSurname;
			args.mixte.ranking = mixtePartnerRanking;
		}
		
		console.log(args);
		
		// Nous pouvons envoyer la requête
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				if(xhr.responseText == "@ok")
				{
					document.querySelector("#button span").innerHTML = "Votre inscription a bien été ajoutée dans la base de données.";
					
					setTimeout(function(){
						tournaments.players(document.querySelector("#page2 #tournament_name span b").innerHTML);
					}, 2000);
				}
				else
				{
					document.querySelector("#button span").innerHTML = "Une erreur s'est produite lors de l'inscription. Veuillez vérifier que tous les champs sont bien remplis.";
				}
				
				setTimeout(function(){
					document.querySelector("#button span").innerHTML = "S'inscrire";
				}, 5000);
			}
		}
		
		xhr.send("module=tournaments&action=register&params=" + JSON.stringify(args));
	}
};
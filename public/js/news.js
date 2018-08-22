var news = 
{
	tag: "blue",
	
	init: function()
	{
		document.querySelector("#title span").innerHTML = "News et articles";
		document.querySelector("#news").innerHTML = "<table><div class='loader' style='text-align:center;'>Chargement des articles en cours...</div></table>";
		
		document.querySelector("iframe").contentDocument.addEventListener("click", function(){news.editor.refreshStates();});
		document.querySelector("iframe").contentDocument.addEventListener("keypress", function(){news.editor.refreshStates();});
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
                document.querySelector(".loader").innerHTML = "";
				document.querySelector("#news table").innerHTML = xhr.responseText;
				
				if(window.location.href.split("#")[1] != null)
				{
					news.view(window.location.href.split("#")[1]);	
				}
			}
		}
		
		xhr.send("module=news&action=listAll");
	},
	
	view: function(id)
	{
		document.querySelector("#title span").innerHTML = "<a href='news.php'>↩</a>";
		document.querySelector("#news").innerHTML = "<p style='text-align: center;font-size: 3vh;'>Chargement de l'article en cours...</p>";
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				var data = JSON.parse(xhr.responseText);
				
				var tags = {
					blue: "Vie du club",
					red: "Jeunes",
					green: "Tournois",
					orange: "Interclubs",
					brown: "Informations",
					purple: "Importants"
				};
				
				document.querySelector("#title span").innerHTML = "<a href='news.php'>↩</a> " + data[0]["title"] + "<br /><p style='font-size: 2.5vh;display:inline;color:"+data[0]["tags"]+";'>"+tags[data[0]["tags"]]+"</p>";
				document.querySelector("#news").innerHTML = "<div id='content_news'>"+data[0]["content"]+"</div>";
				document.querySelector("#news").innerHTML += "<div id='informations'><span>Article écrit par <b>"+data[0]["author"]+"</b>, le <b>"+data[0]["date"]+"</b></span><span><i class='fa fa-trash' onclick='news.delete(\""+data[0]["id"]+"\");'></i>&nbsp;<i class='fa fa-pencil' onclick='news.edit(\""+data[0]["id"]+"\");'></i></span></div>";
			}
		}
		
		xhr.send("module=news&action=view&params=" + id);
	},
	
	delete: function(id)
	{
		var a = confirm("Êtes-vous sûr(e) de vouloir supprimer cet article ?");
		
		if(a)
		{
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					news.init();
					
					news.closePopup();
				}
			}

			xhr.send("module=news&action=delete&params=" + id);
		}
	},
	
	edit: function(id)
	{
		news.openPopup();
		
		document.querySelector("iframe").contentDocument.contentEditable = true;
		document.querySelector("iframe").contentDocument.designMode = "on";
		
		document.querySelector("iframe").contentDocument.querySelector("head").innerHTML = "<style>td {border:1px solid grey;width:calc(100% / 15);height: 5vh;} img {max-width: 100%;}</style>";
		
		document.querySelectorAll(".buttons input")[0].setAttribute("onclick", "news.editor.update(\""+id+"\");");
		
		document.querySelector("iframe").contentDocument.body.innerHTML = "";
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				var data = JSON.parse(xhr.responseText);
				
				document.querySelector(".title input").value = data[0]["title"];
				document.querySelector("iframe").contentDocument.execCommand("insertHTML", false, data[0]["content"]);
			}
		}
		
		xhr.send("module=news&action=view&params=" + id);
	},
	
	openPopup: function()
	{
		document.querySelector("#popup").style = "transform: scale(1);opacity: 1;";
	},
	
	closePopup: function()
	{
		document.querySelector("#popup").style = "transform: scale(0);opacity: 0;";
	},
	
	add: function()
	{
		news.openPopup();
		
		document.querySelector("iframe").contentDocument.contentEditable = true;
		document.querySelector("iframe").contentDocument.designMode = "on";
		
		document.querySelector("iframe").contentDocument.querySelector("head").innerHTML = "<style>td {border:1px solid grey;width:calc(100% / 15);height: 5vh;} img {max-width: 100%;}</style>";
		
		document.querySelectorAll(".buttons input")[0].setAttribute("onclick", "news.editor.save();");
	},
	
	editor:
	{
		refreshStates: function()
		{
			if(document.querySelector("iframe").contentDocument.queryCommandState("bold"))
			{
				document.querySelectorAll(".toolbar i")[0].classList.add("selected");
			}
			else
			{
				document.querySelectorAll(".toolbar i")[0].classList.remove("selected");
			}
			
			if(document.querySelector("iframe").contentDocument.queryCommandState("italic"))
			{
				document.querySelectorAll(".toolbar i")[1].classList.add("selected");
			}
			else
			{
				document.querySelectorAll(".toolbar i")[1].classList.remove("selected");
			}
			
			if(document.querySelector("iframe").contentDocument.queryCommandState("underline"))
			{
				document.querySelectorAll(".toolbar i")[2].classList.add("selected");
			}
			else
			{
				document.querySelectorAll(".toolbar i")[2].classList.remove("selected");
			}
			
			if(document.querySelector("iframe").contentDocument.queryCommandState("justifyLeft"))
			{
				document.querySelectorAll(".toolbar i")[3].classList.add("selected");
			}
			else
			{
				document.querySelectorAll(".toolbar i")[3].classList.remove("selected");
			}
			
			if(document.querySelector("iframe").contentDocument.queryCommandState("justifyCenter"))
			{
				document.querySelectorAll(".toolbar i")[4].classList.add("selected");
			}
			else
			{
				document.querySelectorAll(".toolbar i")[4].classList.remove("selected");
			}
			
			if(document.querySelector("iframe").contentDocument.queryCommandState("justifyRight"))
			{
				document.querySelectorAll(".toolbar i")[5].classList.add("selected");
			}
			else
			{
				document.querySelectorAll(".toolbar i")[5].classList.remove("selected");
			}
		},
		
		bold: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('bold', false, null);
		},
		
		italic: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('italic', false, null);
		},
		
		underline: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('underline', false, null);
		},
		
		aleft: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('justifyLeft', false, null);
		},
		
		acenter: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('justifyCenter', false, null);
		},
		
		aright: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('justifyRight', false, null);
		},
		
		ajustify: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('justifyFull', false, null);
		},
		
		list: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('insertUnorderedList', false, null);
		},
		
		link: function()
		{
			document.querySelector(".min_popup").style = "transform:scale(1);opacity:1;";
			
			document.querySelector(".min_popup span").innerHTML = ""+
				'<input type="text" placeholder="Lien..."/>&nbsp;'+
				'<input type="button" value="Insérer" onclick="news.editor.insertLink();" />&nbsp;'+
				'<input type="button" value="Fermer" onclick="news.editor.closeLinkPopup();" />'+
			"";
		},
		
		unlink: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('unlink', false, null);
		},
		
		insertLink: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('createLink', false, document.querySelectorAll(".min_popup input")[0].value);
			
			document.querySelector("iframe").contentWindow.focus();
		},
		
		closeLinkPopup: function()
		{
			document.querySelector(".min_popup").style = "transform:scale(0);opacity:0;";
		},
		
		table: function()
		{
			document.querySelector("iframe").contentDocument.execCommand('insertHTML', false, ""+
				"<table style='border:1px solid grey;border-collapse:collapse;width:100%;'>"+
					"<tr>"+
						"<td style='border:1px solid grey;'>Cellule 1</td>"+
						"<td style='border:1px solid grey;'>Cellule 2</td>"+
					"</tr>"+
					"<tr>"+
						"<td style='border:1px solid grey;'>Cellule 3</td>"+
						"<td style='border:1px solid grey;'>Cellule 4</td>"+
					"</tr>"+
				"</table>"+
			"");
		},
		
		tag: function()
		{
			document.querySelector(".min_popup").style = "transform:scale(1);opacity:1;";
			
			document.querySelector(".min_popup span").innerHTML = ""+
				'<select><option value="blue">Vie du club</option><option value="red">Jeunes</option><option value="green">Tournois</option><option value="orange">Interclubs</option><option value="brown">Informations</option><option value="purple">Important</option></select>&nbsp;'+
				'<input type="button" value="Sélectionner ce tag" onclick="news.editor.selectTag();" />&nbsp;'+
				'<input type="button" value="Fermer" onclick="news.editor.closeLinkPopup();" />'+
			"";
		},
		
		selectTag: function()
		{
			news.tag = document.querySelector(".min_popup span select").options[document.querySelector(".min_popup span select").selectedIndex].value;
			
			document.querySelector(".title i").innerHTML = document.querySelector(".min_popup span select").options[document.querySelector(".min_popup span select").selectedIndex].text;
			
			document.querySelector(".min_popup span").innerHTML = "✓ Le tag a bien été sélectionné";
			
			setTimeout(function(){news.editor.closeLinkPopup();}, 1500);
		},
		
		save: function()
		{
			// Récupération du contenu
			var content = encodeURIComponent(btoa(document.querySelector("iframe").contentDocument.body.innerHTML));
			var title = document.querySelector(".title input").value;
			var tag = news.tag;
            
            var args = [title, content, tag].join("////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					news.init();
						
				    news.closePopup();
				}
			}
            
            console.log(args);
			
			xhr.send("module=news&action=add&params=" + args);
		},
		
		update: function(id)
		{
			// Récupération du contenu
			var content = encodeURIComponent(btoa(document.querySelector("iframe").contentDocument.body.innerHTML));
			var title = document.querySelector(".title input").value;
			var tag = news.tag;
            
            var args = [title, content, tag, id].join("////");
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/router.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					if(xhr.responseText == "@ok")
					{
						news.view(id);
						
						news.closePopup();
					}
					else
					{
						alert("Une erreur s'est produite lors de l'enregistrement de l'article. Vérifiez que vous n'avez pas laisser la zone de titre ou le contenu de l'article vide.\n\nSi le problème persiste, merci d'envoyer un mail à romain.claveau@protonmail.ch.");
					}
				}
			}
			
			xhr.send("module=news&action=update&params=" + args);
		}
	}
};
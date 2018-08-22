var jeunes = {
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
				var table = document.querySelector("#tournaments table");
				
				var counter = 0;
				
				for(k in data)
				{
					if(counter == 14) break; // Affichage des 14 premiers tournois afin de ne pas surcharger la page
					
					table.innerHTML += `
						<tr>
							<td><a href='#' onclick='window.open(\"${data[k]["link_badiste"]}\");'>${data[k]["name"]}</a></td>
							<td>${data[k]["date"]}</td>
							<td>${data[k]["duration"]}</td>
							<td>${data[k]["categories"].join(", ")}</td>
							<td>${data[k]["tables"].join(", ")}</td>
							<td>${data[k]["limit"]}</td>
						</tr>
					`;
					
					counter++;
				}
			}
		}
		
		xhr.send("module=tournaments&action=getYoungsTournaments");
	}
};
var interclubs = {
	init: function()
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				document.querySelector("#interclubs").innerHTML = xhr.responseText;
			}
		}
		
		xhr.send("module=interclubs&action=viewTeams");
	},
	
	viewMatches: function(id, name)
	{
		document.querySelector("#title span").innerHTML = "<a href='interclubs.php'>↩</a> Matches de l'équipe " + name;
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				document.querySelector("#interclubs").innerHTML = xhr.responseText;
			}
		}
		
		xhr.send("module=interclubs&action=viewMatches&params=" + id);
	}
};
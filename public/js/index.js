var index = 
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
				document.querySelector("#last_news .content").innerHTML = xhr.responseText;
			}
		}
		
		xhr.send("module=news&action=listMin");
	},
	
	viewNews: function(id)
	{
		document.location.href = "news.php#" + id;
	}
};
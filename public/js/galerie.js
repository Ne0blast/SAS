var galerie = 
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
				document.querySelector("#galerie").innerHTML = xhr.responseText;
			}
		}
		
		xhr.send("module=galerie&action=viewAll");
	},
	
	getImagesFromAlbum: function(id, name)
	{
		var window = document.createElement("div");
		window.classList.add("window");
		window.innerHTML = "<div class='title'><span>"+name+"</span></div><div class='content'><div class='photos'></div></div><div class='button'><span><input type='button' value='Fermer' onclick='galerie.destroyWindow();' /></span></div>";
		window.setAttribute("data-id", id);
		document.body.appendChild(window);
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				document.querySelector(".window .content div").innerHTML = xhr.responseText;
			}
		}
		
		xhr.send("module=galerie&action=getImagesFromAlbum&params=" + id);
	},
	
	addAlbum: function()
	{
		var name = document.querySelector("#popup input[type='text']").value;
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				galerie.init();
				
				galerie.popup.close();
			}
		}
		
		xhr.send("module=galerie&action=addAlbum&params=" + name);
	},
	
	upload: function()
	{
		var id_album = document.querySelector(".window").getAttribute("data-id");
		
		var file_upload = document.querySelector("#files");
		
		if(file_upload.files.length != 0)
		{
			var data = new FormData();
			
			data.append("id_album", id_album);
			
			for(var i = 0; i < file_upload.files.length; i++)
			{				
				data.append("pictures[]", file_upload.files[i], file_upload.files[i]["name"]);
			}
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "core/uploader.php", true);
			
			xhr.onreadystatechange = function()
			{
				if(xhr.status == 200 && xhr.readyState == 4)
				{
					galerie.destroyWindow();
					
					setTimeout(function(){
						galerie.getImagesFromAlbum(id_album);
					}, 50);
				}
			}
			
			xhr.upload.addEventListener("progress", function(e)
			{
				document.querySelector("o").innerHTML = Math.ceil(e.loaded/e.total) * 100 + '%';
			}
			, false);
			
			xhr.send(data);
		}
	},
	
	zoom: function(img)
	{		
		var src = img.src;
        var src_uncompressed = img.src.replace("_compressed", "");
        var param = src_uncompressed.substring(src_uncompressed.lastIndexOf("/"), src_uncompressed.length).replace("/", "");

		var zoom = document.createElement("div");
		zoom.id = "back";
		zoom.innerHTML =  "" +
                          "<span><img id='img_galerie' src='"+src_uncompressed+"' /></span>" +
                          "<div id='left_arrow' onclick='galerie.viewPrevious(\""+param+"\");'><p>&lt;</p></div>" +
                          "<div id='right_arrow' onclick='galerie.viewNext(\""+param+"\");'><p>&gt;</p></div>" +
                          ""; 
		
		document.querySelector("body").appendChild(zoom);
        
        document.querySelector("#img_galerie").setAttribute("onclick", "galerie.unzoom();");
	},
    
    viewPrevious: function(current)
    {
        var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				document.querySelector("#img_galerie").src = "storage/galerie/" + xhr.responseText;
                document.querySelector("#left_arrow").setAttribute("onclick", "galerie.viewPrevious(\""+xhr.responseText+"\")");
                document.querySelector("#right_arrow").setAttribute("onclick", "galerie.viewNext(\""+xhr.responseText+"\")");
			}
		}
		
		xhr.send("module=galerie&action=viewPrevious&params=" + current);
    },
    
    viewNext: function(current)
    {
        var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				document.querySelector("#img_galerie").src = "storage/galerie/" + xhr.responseText;
                document.querySelector("#left_arrow").setAttribute("onclick", "galerie.viewPrevious(\""+xhr.responseText+"\")");
                document.querySelector("#right_arrow").setAttribute("onclick", "galerie.viewNext(\""+xhr.responseText+"\")");
			}
		}
		
		xhr.send("module=galerie&action=viewNext&params=" + current);
    },
	
	unzoom: function()
	{
		document.querySelector("#back").parentNode.removeChild(document.querySelector("#back"));
	},
	
	popup:
	{
		open: function()
		{
			document.querySelector("#popup").style = "opacity:1;transform:scale(1);";
		},
		
		close: function()
		{
			document.querySelector("#popup").style = "opacity:0;transform:scale(0);";
		}
	},
	
	destroyWindow: function()
	{
		document.body.removeChild(document.querySelector(".window"));
	}
};
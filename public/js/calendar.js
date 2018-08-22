var calendar = 
{
	months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
	correspondances : {
		0: 6,
		1: 0,
		2: 1,
		3: 2,
		4: 3,
		5: 4,
		6: 5
	},
	
	init: function()
	{
		var date = new Date();
		
		var currentDay = this.getCurrentDay();
		var currentMonth = this.getCurrentMonth();
		var currentYear = this.getCurrentYear();
		var numberOfDays = this.getNumberOfDaysInMonth(currentMonth, currentDay);
		var dayNumber = this.getCurrentDate();
		
		// Stockage
		localStorage.setItem("currentDay", currentDay);
		localStorage.setItem("currentMonth", currentMonth);
		localStorage.setItem("currentYear", currentYear);
		localStorage.setItem("dayNumber", dayNumber);
		
		// Affichage du mois et de l'année sur le calendrier
		this.setCalendarTitle(currentMonth, currentYear);
		
		// Affichage des jours dans le calendrier
		this.showDaysInCalendar(currentMonth, currentYear, dayNumber, numberOfDays);
		
		// Recherche des dates
		this.getDataForCurrentMonth(currentMonth, currentYear);
	},
	
	getNumberOfDaysInMonth: function(month, year)
	{
		return new Date(year, month, 0).getDate();
	},
	
	getCurrentDay: function()
	{
		return new Date().getDay();
	},
	
	getCurrentDate: function()
	{
		return new Date().getDate();
	},
	
	getCurrentMonth: function()
	{
		return new Date().getMonth()+1;
	},
	
	getCurrentYear: function()
	{
		return new Date().getFullYear();
	},
	
	setCalendarTitle: function(month, year)
	{				
		document.querySelector("#calendar o").innerHTML = this.months[month-1] + " " + year;
	},
	
	showDaysInCalendar: function(month, year, currentDayNumber, numberOfDays)
	{
		var firstDay = new Date(year, month-1, 0).getDay();
		var daysArea = document.querySelectorAll("#calendar td");
		
		for(var i = firstDay; i < numberOfDays + firstDay; i++)
		{
			daysArea[i].addEventListener("click", function(){
				calendar.selectDay(this, i, month, year);
			});
			
			if(i >= firstDay && i < currentDayNumber + firstDay - 1)
			{
				daysArea[i].setAttribute("day", i - firstDay + 1);
				daysArea[i].classList.add("day");
			}
			
			if(i == currentDayNumber + firstDay - 1)
			{
				daysArea[i].setAttribute("day",  i - firstDay + 1);
				daysArea[i].classList.add("day");
				
				daysArea[i].style.background = "#4bd350 url('https://png.icons8.com/"+(i - firstDay + 1)+"/ios7/100')";
			}
			else
			{
				daysArea[i].setAttribute("day", i - firstDay + 1);
				daysArea[i].classList.add("day");
				
				daysArea[i].style.background = "url('https://png.icons8.com/"+(i - firstDay + 1)+"/ios7/100')";
			}
			
			daysArea[i].style.backgroundSize = "4vh";
			daysArea[i].style.backgroundRepeat = "no-repeat";
		}
	},
	
	getDataForCurrentMonth: function(currentMonth, currentYear)
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "core/router.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhr.onreadystatechange = function()
		{
			if(xhr.status == 200 && xhr.readyState == 4)
			{
				var data = JSON.parse(xhr.responseText);
				
				var daysArea = document.querySelectorAll("#calendar td");
				
				for(var i = 0; i < daysArea.length; i++)
				{					
					if(daysArea[i].classList.contains("day"))
					{						
						for(k in data["tournaments"])
						{							
							if(data["tournaments"][k]["date"].split(" ")[0] == daysArea[i].getAttribute("day"))
							{
								daysArea[i].innerHTML += "<p class='circle circle-blue'></p>";
								
								var content_tournaments = (daysArea[i].getAttribute("data-tournaments") == null || daysArea[i].getAttribute("data-tournaments") == "Pas de tournoi ce jour-ci") ? "" : daysArea[i].getAttribute("data-tournaments") + "<br />";
								
								daysArea[i].setAttribute("data-tournaments", content_tournaments+"<a href='"+data["tournaments"][k][1]+"'>"+data["tournaments"][k][0]+"</a>");
							}
							
							if(data["tournaments"][k]["limite_inscription"].split(" ")[0] == daysArea[i].getAttribute("day"))
							{
								daysArea[i].innerHTML += "<p class='circle circle-orange'></p>";
								
								var content_limit = (daysArea[i].getAttribute("data-limit") == null || daysArea[i].getAttribute("data-limit") == "Aucune limite d'inscription ce jour-ci") ? "" : daysArea[i].getAttribute("data-limit") + "<br />";
								
								daysArea[i].setAttribute("data-limit", content_limit+"<a href='"+data["tournaments"][k][1]+"'>"+data["tournaments"][k][0]+"</a>");
							}
						}

						for(var b = 0; b < data["dates"].length; b++)
						{
							console.log(data["dates"][b]["date"].split("/")[0]);
							if(parseInt(data["dates"][b]["date"].split("/")[0]) == parseInt(daysArea[i].getAttribute("day")))
							{
								daysArea[i].innerHTML += "<p class='circle circle-red'></p>";
								
								var content_date = (daysArea[i].getAttribute("data-date") == null || daysArea[i].getAttribute("data-date") == "Aucune date importante ce jour-ci") ? "" : daysArea[i].getAttribute("data-date") + "<br />";
								
								daysArea[i].setAttribute("data-date", content_date+""+data["dates"][b]["name"]);
							}
						}
					}
				}
				
				if(calendar.getCurrentMonth() == currentMonth && calendar.getCurrentYear() == currentYear)
				{					
					calendar.selectDay(document.querySelectorAll("#calendar .day")[calendar.getCurrentDate()-1], calendar.getCurrentDate()-1, currentMonth, currentYear);

					document.querySelectorAll("#calendar .day")[calendar.getCurrentDate()-1].style.background = "#4bd350 url('https://png.icons8.com/"+calendar.getCurrentDate()+"/ios7/100')";
				
					document.querySelectorAll("#calendar .day")[calendar.getCurrentDate()-1].style.backgroundSize = "4vh";
					document.querySelectorAll("#calendar .day")[calendar.getCurrentDate()-1].style.backgroundRepeat = "no-repeat";
				}
			}
		}
		
		xhr.send("module=calendar&action=getMonthEvents&params=" + currentMonth + "/" + currentYear);
	},
	
	selectDay: function(element, day, month, year)
	{
		// On affiche le jour selectionné
		var daysArea = document.querySelectorAll("#calendar td");
		
		for(var i = 0; i < daysArea.length; i++)
		{
			daysArea[i].classList.remove("selected");
		}
		
		element.classList.add("selected");
		
		// On affiche les évènements du jour
		var date = element.getAttribute("data-date");
		var tournament = element.getAttribute("data-tournaments");
		var limit = element.getAttribute("data-limit");
		
		document.querySelector("#dates #date span").innerHTML = (date == null) ? "Aucune date importante ce jour-ci" : date;
		document.querySelector("#dates #tournament span").innerHTML = (tournament == null) ? "Pas de tournoi ce jour-ci" : tournament;
		document.querySelector("#dates #limit span").innerHTML = (limit == null) ? "Aucune limite d'inscription ce jour-ci" : limit;
	},
	
	previousMonth: function()
	{		
		var currentDay = localStorage.getItem("currentDay");
		var currentMonth = localStorage.getItem("currentMonth");
		var currentYear = localStorage.getItem("currentYear");
		var dayNumber = localStorage.getItem("dayNumber");
		
		console.log(currentMonth);
		
		currentMonth = (currentMonth == 1) ? 12 : currentMonth-1;
		currentYear = (currentMonth == 12) ? currentYear-1 : currentYear;
		
		localStorage.setItem("currentMonth", currentMonth);
		localStorage.setItem("currentYear", currentYear);
		
		var numberOfDays = this.getNumberOfDaysInMonth(currentMonth, currentYear);
		
		this.cleanCalendar();
		
		// Affichage du mois et de l'année sur le calendrier
		this.setCalendarTitle(currentMonth, currentYear);
		
		// Affichage des jours dans le calendrier
		this.showDaysInCalendar(currentMonth, currentYear, dayNumber, numberOfDays);
		
		// Recherche des dates
		this.getDataForCurrentMonth(currentMonth, currentYear);
	},
	
	nextMonth: function()
	{
		var currentDay = localStorage.getItem("currentDay");
		var currentMonth = localStorage.getItem("currentMonth");
		var currentYear = localStorage.getItem("currentYear");
		var dayNumber = localStorage.getItem("dayNumber");
		
		var nextMonth = parseInt(currentMonth) + 1;
		var nextYear = parseInt(currentYear) + 1;
		
		currentMonth = (currentMonth == 12) ? 1 : nextMonth;
		currentYear = (currentMonth == 1) ? nextYear : currentYear;
		
		console.log(currentMonth);
		
		localStorage.setItem("currentMonth", currentMonth);
		localStorage.setItem("currentYear", currentYear);
		
		var numberOfDays = this.getNumberOfDaysInMonth(currentMonth, currentYear);
		
		this.cleanCalendar();
		
		// Affichage du mois et de l'année sur le calendrier
		this.setCalendarTitle(currentMonth, currentYear);
		
		// Affichage des jours dans le calendrier
		this.showDaysInCalendar(currentMonth, currentYear, dayNumber, numberOfDays);
		
		// Recherche des dates
		this.getDataForCurrentMonth(currentMonth, currentYear);
	},
	
	cleanCalendar: function()
	{
		var daysArea = document.querySelectorAll("#calendar td");
		
		for(var i = 0; i < daysArea.length; i++)
		{
			daysArea[i].classList.remove("selected");
			daysArea[i].classList.remove("current");
			
			daysArea[i].innerHTML = "";
			daysArea[i].style = "";
			
			daysArea[i].setAttribute("data-date", "Aucune date importante ce jour-ci");
			daysArea[i].setAttribute("data-tournaments", "Pas de tournoi ce jour-ci");
			daysArea[i].setAttribute("data-limit", "Aucune limite d'inscription ce jour-ci");
			
			daysArea[i].removeAttribute("day");
		}
	}
} 
|| {};
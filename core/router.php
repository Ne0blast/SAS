<?php
	session_start();

	header('Content-Type: text/html; charset=utf-8');

	if(isset($_GET['module'])) $_POST['module'] = $_GET['module'];
	if(isset($_GET['action'])) $_POST['action'] = $_GET['action'];
	if(isset($_GET['params'])) $_POST['params'] = $_GET['params'];

	if(isset($_POST['module']))
	{
		$_routes = array(			
			"calendar/getMonthEvents",
			
			"tournaments/getAllTournaments",
			"tournaments/register",
			"tournaments/viewPlayers",
			"tournaments/getYoungsTournaments",
			
			"news/listAll",
			"news/listMin",
			"news/add",
			"news/view",
			"news/update",
			"news/delete",
			
			"interclubs/viewTeams",
			"interclubs/viewMatches",
			
			"galerie/viewAll",
			"galerie/getImagesFromAlbum",
			"galerie/addAlbum",
            "galerie/viewPrevious",
            "galerie/viewNext",
			
			"espace/viewPanel",
			
			"espace/updateInformationsAdress",
			"espace/updateInformationsMail",
			"espace/updateInformationsPhone",
			"espace/updateInformationsBirth",
			"espace/updateInformationsPassword",
			
			"espace/updateMember",
			"espace/deleteMember",
			"espace/addMember",
			"espace/exportMembers",
			"espace/sendMail",
			
			"espace/addDate",
			"espace/deleteDate",
			"espace/updateDate",
			
			"espace/addTeam",
			"espace/deleteTeam",
			"espace/addTeamMember",
			"espace/updateTeamMember",
			"espace/deleteTeamMember",
			
			"espace/addMatch",
			"espace/updateMatch",
			"espace/deleteMatch",
			
			"espace/connect"
		);
		
		$module = $_POST['module'];
		$action = (isset($_POST['action'])) ? $_POST['action'] : "default";
		$params = (isset($_POST['params'])) ? base64_encode($_POST['params']) : "";
		
		if(in_array("{$module}/{$action}", $_routes))
		{
			require_once("bdd.php");
			require_once("modules/{$module}/controller.php");
			
			eval("{$module}::{$action}(\"{$params}\");");
		}
	}
?>
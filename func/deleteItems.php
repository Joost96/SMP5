<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	include_once (dirname(__DIR__).'/model/portfolioItem.php');
	include_once (dirname(__DIR__).'/model/user.php');
	
	$ID = ($_POST['itemID']);
	
	if(isset($_SESSION['user']) && !empty($_SESSION['user']))
	{
		$user = unserialize($_SESSION['user']);
	}
	else
		return;
	
	"DELETE FROM P_E WHERE portfolioitemId = $ID";
	
	"DELETE FROM reacties WHERE portfolioitemId = $ID";
	
	$afbeeldingIDS[] = "SELECT afbeeldingId FROM portfolioAfbeelding WHERE portfolioitemId = $ID";
	
	"DELETE FROM portfolioAfbeelding WHERE portfolioitemID = $ID";
	
	foreach($afbeeldingIDS as $afbID)
	{
		"DELETE FROM afbeelding WHERE afbeeldingId = $afbID";
	}
	
	"DELETE FROM portfolioItem WHERE ID = $ID;
}

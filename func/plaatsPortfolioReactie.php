<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/user.php');
	include_once (dirname(__DIR__).'/model/PortfolioReacties.php');
	
	session_start();
	$forumdao = new forumDAO();
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user']) && !empty($_POST['itemID']) && !empty($_POST['content']))
	{
		$user = unserialize($_SESSION['user']);
		$content = $_POST['content'];
		$ID = $_POST['itemID'];
		
		$reactie = new ReactieModel(null, null, $ID, $user, $content, date("Y-m-d H:i:s"));
		
		$forumdao->plaatsForumReactie($reactie);

		printPortfoReacties($_POST['itemID']);
	}
?>
<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/user.php');
	include_once (dirname(__DIR__).'/func/reactieSection.php');
	
	session_start();
	$forumdao = new forumDAO();
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user']) && !empty($_POST['postId'])){
		$user = unserialize($_SESSION['user']);
		
		$reactie = new ReactieModel(null, $_POST['postId'], null, $user, $_POST['reactieContent'], null);
		
		$forumdao->plaatsReactie($reactie);	
		
		printReacties($_POST['postId']);
	}
?>
<?php 
	include_once (dirname(__DIR__)."/model/forumDAO.php");
	include_once (dirname(__DIR__)."/model/user.php");
	
	session_start();
	
	if (unserialize($_SESSION['user'])->admin){
		$forumdao = new forumDAO();
		$result = $forumdao->deleteReactie($_GET['reactie_id']);
	}
	
	header("location: onderwerp.php?onderwerp_id={$_GET['onderwerp_id']}")
?>
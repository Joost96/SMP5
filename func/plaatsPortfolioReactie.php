<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/user.php');
	
	$forumdao = new forumDAO();
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user']) && !empty($_POST['itemID']) && !empty($_POST['reactie_content']))
	{
		$user = unserialize($_SESSION['user']);
		
		$reactie = new ReactieModel(null, null, $_POST['itemID'], $user, $_POST['reactie_content'], date("Y-m-d H:i:s"));
		
		$forumdao->plaatsForumReactie($reactie);	
		
		header("location: /smp5/portfoliodetail.php?itemID={$_POST['itemID']}");
	}
	else 
	{
		echo "error, je hebt geen reactie ingevuld!";
	}
?>
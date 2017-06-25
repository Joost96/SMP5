<?php	include_once (dirname(__DIR__)."/model/forumDAO.php");	include_once (dirname(__DIR__)."/model/ForumPostModel.php");	include_once (dirname(__DIR__)."/model/user.php");	
	$forumdao = new forumDAO();	if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
		$post = new ForumPostModel(null, $_POST['onderwerp_id'], 			$_POST['titel'], $_POST['content'], $_SESSION['user'], null);			
		$result = $forumdao->plaatsPost($post);	} else {		echo "else";	}		header("location: onderwerp.php?onderwerp_id={$_POST['onderwerp_id']}");?>
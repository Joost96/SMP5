<?php	include_once (dirname(__DIR__)."/model/forumDAO.php");	include_once (dirname(__DIR__)."/model/ForumPostModel.php");
	$forumdao = new forumDAO();
	$post = new ForumPostModel(null, $_POST['onderwerp_id'], $_POST['titel'], $_POST['content']);		
	$result = $forumdao->plaatsPost($post);			header("location: onderwerp.php?onderwerp_id={$_POST['onderwerp_id']}");?>
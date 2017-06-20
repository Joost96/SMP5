<?php
	include_once (dirname(__DIR__)."/model/forumDAO.php");
	include_once (dirname(__DIR__)."/model/ForumPostModel.php");
	
	$forumdao = new forumDAO();
	
	echo "3";
	
	$post = new ForumPostModel(null, $_POST['onderwerp_id'], $_POST['naam'], $_POST['content']);
	
	var_dump($post);
	
	$forumdao->plaatsPost($post);
	
	header("location: onderwerp.php?onderwerp_id={$_POST['onderwerp_id']}");
	
?>
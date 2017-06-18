<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	
	echo $_POST['post_id']."<br>";
	echo $_POST['reactie_content']."<br>";
	
	$forumdao = new forumDAO();
	
	$forumdao->postReactie($_POST['post_id'], $_POST['reactie_content']);
		
	header("location: post.php?post_id={$_POST['post_id']}");	
?>
<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/user.php');
	
	$forumdao = new forumDAO();
	
	session_start();
	
	if (isset($_SESSION['user'] &&!empty($_SESSION['user'])){
		$user = $_SESSION['user'];
		
		$reactie = new ReactieModel(null, $_POST['post_id'], null, $user->id, $_POST['reactie_content'], date("Y-m-d H:i:s"));
		
		$forumdao->plaatsReactie($_POST['post_id'], $_POST['reactie_content']);
		echo "done";
	}
		
	//header("location: post.php?post_id={$_POST['post_id']}");
	echo "
		<a href='post.php?post_id={$_POST['post_id']}>goto post</a>
		";
?>
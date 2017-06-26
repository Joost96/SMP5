<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/user.php');
	
	session_start();
	$forumdao = new forumDAO();
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user']) && !empty($_POST['post_id'])){
		$user = unserialize($_SESSION['user']);
		
		$reactie = new ReactieModel(null, $_POST['post_id'], null, $user, $_POST['reactie_content'], date("Y-m-d H:i:s"));
		
		$forumdao->plaatsReactie($reactie);	
		
		echo "1";

		header("location: post.php?post_id={$_POST['post_id']}");
	}
	
	else if (isset($_SESSION['user']) && !empty($_SESSION['user']) && !empty($_POST['itemID'])){
		$user = unserialize($_SESSION['user']);
		
		$reactie = new ReactieModel(null, null, $_POST['itemID'], $user, $_POST['reactie_content'], date("Y-m-d H:i:s"));
		
		$forumdao->plaatsForumReactie($reactie);	
		
		header("location: /smp5/portfoliodetail.php?itemID={$_POST['itemID']}");
	}
	
	// voor debug comment: header(), en uncomment: echo.
	
	/*echo "
		<br>
		<a href='post.php?post_id={$_POST['post_id']}'>goto post</a>
		";
		*/
?>
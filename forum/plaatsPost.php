<?php	
	include_once (dirname(__DIR__)."/model/forumDAO.php");	
	include_once (dirname(__DIR__)."/model/ForumPostModel.php");
	include_once (dirname(__DIR__)."/model/user.php");
	
	session_start();
	
	$forumdao = new forumDAO();	$user = unserialize($_SESSION['user']);
	if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
		
		$post = new ForumPostModel(null, $_POST['onderwerp_id'],
			$_POST['titel'], $_POST['content'], $user, null, 0);
		
		$result = $forumdao->plaatsPost($post);	
		header("location: onderwerp.php?onderwerp_id={$_POST['onderwerp_id']}");
	}

	echo "<a href='onderwerp.php?onderwerp_id={$_POST['onderwerp_id']}'>goto onderwerp</a>";
?>
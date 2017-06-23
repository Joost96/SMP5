<?php
	include_once (dirname(__DIR__).'/func/page_header.php');
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/ForumPostModel.php');
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	
	session_start();
	
	$post_id = $_GET['post_id'];
	
	$forumdao = new forumDAO();
	
	$post = $forumdao->getPostbyid($post_id);
	
	$reacties = $forumdao->getAllReacties($post_id);
	
	$reacties = array_reverse($reacties);

	page_header($post->titel);

	echo "
		<h2>{$post->titel}</h2><br>
		<p>{$post->content}</p><br>
		";
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
		echo "
			<form action='plaatsReactie.php' method='post'>
				<label for='reactie'>Reactie:</label><br>
				<input type='text' value='' id='reactie' name='reactie_content' /><br>
				<input type='hidden' value='{$post_id}' name='post_id' />
				<input type='submit' value='POST' />
			</form>
		";	
	}
	
	foreach ( $reacties as $reactie ){
		echo "
			<p>{$reactie->content}</p><br>
			";
	}
?>
<?php
	include_once (dirname(__DIR__).'/func/page_header.php');
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/PostModel.php');
	
	$onderwerp_id = $_GET['onderwerp_id'];
	
	$forumdao = new forumDAO();
	
	$onderwerp = $forumdao->getOnderwerpbyid($onderwerp_id);
	$title = $onderwerp->naam;
	
	page_header($title);
	
	echo "
		<h2>{$title}</h2>
		<br>
		";
	
	$posts = $forumdao->getPostbyOnderwerp($onderwerp_id);
	
	foreach ( $posts as $post ){
		echo "<p><a href=post.php?post_id={$post->id}>{$post->titel}</a></p>";
	}
?>
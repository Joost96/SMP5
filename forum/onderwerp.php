<?php
	include_once (dirname(__DIR__).'/func/page_header.php');
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/ForumPostModel.php');
	
	$onderwerp_id = $_GET['onderwerp_id'];
	
	$forumdao = new forumDAO();
	
	$onderwerp = $forumdao->getOnderwerpbyid($onderwerp_id);
	$title = $onderwerp->naam;
	
	page_header($title);
	
	var_dump($onderwerp);
	
	echo "
		<h2>{$title}</h2>
		<br/>
		";
	
	echo "
		<p><a href='nieuwePost.php?onderwerp_id={$onderwerp_id}'>Maak een nieuwe post.</a></p>
		";
	
	$posts = $forumdao->getPostbyOnderwerp($onderwerp_id);
	
	foreach ( $posts as $post ){
		echo "<p><a href=post.php?post_id={$post->id}>{$post->titel}</a></p>";
	}
?>
<?php
	include_once (dirname(__DIR__).'/func/page_header.php');
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/ForumPostModel.php');
	
	$onderwerp_id = $_GET['onderwerp_id'];
	
	$forumdao = new forumDAO();
	
	$onderwerp = $forumdao->getOnderwerpbyid($onderwerp_id);
	$posts = $forumdao->getPostbyOnderwerp($onderwerp_id);
	$posts = array_reverse($posts);
	
	$title = "Forum";
	$style = "forum";
	
	page_header($title, $style);
		
	$title = $onderwerp->naam;
	
	echo "
		<section id='overzichtContent'>
		<h6>{$title}</h6>
		";
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
		echo "
			<p><a href='nieuwePost.php?onderwerp_id={$onderwerp->id}'>Maak een nieuwe post.</a></p>
			";
	}
	
	echo "
		<table id='overzichtTabel'>
			<tr>
				<th>Titel</th>
				<th>Gepost door</th>
			</tr>";
	
	foreach ( $posts as $post ){
		echo "
			<tr>
				<td><a href='post.php?post_id={$post->id}'>{$post->titel}</a></td>
				<td>{$post->user->username}</td>
			</tr>";
	}
	echo "</table>";
	
	echo "</section>";
?>
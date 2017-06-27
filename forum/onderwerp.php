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
		<section id='forumPageContent'>
		<a href='../index.php'>Home</a><span> > </span>
		<h6>{$title}</h6>
		";
	$user = false;
		
	echo "
		<table id='overzichtTabel'>
			<tr class='even'>
				<th>Titel</th>
				<th>Aantal Reacties</th>
				<th>Gepost door</th>
				";
	if($user != false){
		if ($user->admin){
			echo "
				<th>Delete</th>
				";
		}
	}
				
	echo "</tr>";
	
	$i = 1;
	foreach ( $posts as $post ){
		echo "
			<tr class='".addTableClass($i)."'>
				<td><a href='post.php?post_id={$post->id}'>{$post->titel}</a></td>
				<td>{$post->aantalReacties}</td>
				<td>{$post->user->username}</td>";
		
		if ($user != false){
			if ($user->admin){
				echo "
					<td><a id='' href='deletePost.php?onderwerp_id={$onderwerp_id}&post_id={$post->id}'>X</a>
					";
			}
		}
		
		
		echo "</tr>";
		$i++;
	}
	echo "</table>";
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
		$user = $_SESSION['user'];
		$user = unserialize($user);
		echo "
			<p id='nieuwePostLink'><a href='nieuwePost.php?onderwerp_id={$onderwerp->id}'>Maak een nieuwe post.</a></p>
			";
	}
		
	echo "</section>";
	
	function addTableClass ($i){
		if ($i % 2 == 0){
			return "even";
		} else {
			return "odd";
		}
	}
?>
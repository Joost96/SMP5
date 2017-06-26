<?php
	include_once (dirname(__DIR__)."/func/page_header.php");
	include_once (dirname(__DIR__)."/model/user.php");
	include_once (dirname(__DIR__)."/model/ForumOnderwerpModel.php");
	include_once (dirname(__DIR__)."/model/forumDAO.php");
	
	
	$forumdao = new forumDAO();
	$onderwerp = $forumdao->getOnderwerpbyid($_GET['onderwerp_id']);
	
	if (!isset($_SESSION['user']) || 
		empty($_SESSION['user']) || 
		!isset($_GET['onderwerp_id']) ||
		$onderwerp == NULL){
		header("location: overzicht.php");
	}
	
	var_dump($onderwerp);
	
	$title = "Nieuwe Post";
	$style = "forum";
	
	page_header($title, $style);
	

	
	echo "
		<section id='forumPageContent'>
		<a href='../index.php'>Home</a><span> > </span>
		<a href='overzicht.php'>Overzicht</a><span> > </span>
		<a href='onderwerp.php?onderwerp_id={$onderwerp->id}'>{$onderwerp->naam}</a>

		<form action='plaatsPost.php' method='post'>
			<p><label>Titel:</label>
			<input type='text' name='titel' value='' /></p>
			<p><label>Post content:</label>
			<input type='text' name='content' value='' /></p>
			<input type='hidden' value='{$onderwerp->id}' name='onderwerp_id' />
			<p><input type='submit' value='Plaats Post' /></p>
		</form>
		</section>
		";
	
?>
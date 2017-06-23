<?php
	include_once (dirname(__DIR__)."/func/page_header.php");
	
	page_header();
	
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])){
		header("location: overzicht.php");
	}
	
	$onderwerp_id = $_GET['onderwerp_id'];
	
	echo "
		<form action='plaatsPost.php' method='post'>
			<p><label>Titel:</label>
			<input type='text' name='titel' value='' /></p>
			<p><label>Post content:</label>
			<input type='text' name='content' value='' /></p>
			<input type='hidden' value='{$onderwerp_id}' name='onderwerp_id' />
			<p><input type='submit' value='Plaats Post' /></p>
		</form>
		"
	
?>
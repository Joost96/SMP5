<?php
	include_once (dirname(__DIR__)."/func/page_header.php");
	include_once (dirname(__DIR__)."/model/forumDAO.php");
	include_once (dirname(__DIR__)."/model/ForumOnderwerpModel.php");

	$forumdao = new forumDAO();
	
	$titel = "Forum Overzicht";
	
	page_header($titel);	
	
	$onderwerpen = $forumdao->getAllOnderwerpen();

	print "
		<h2>{$titel}</h2><br/>

		";
	
	foreach ( $onderwerpen as $onderwerp ){
		echo "
		<a href='onderwerp.php?onderwerp_id={$onderwerp->id}' >{$onderwerp->naam}</a><br/>
		";
	}
?>
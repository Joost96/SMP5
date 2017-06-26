<?php
	include_once (dirname(__DIR__)."/func/page_header.php");
	include_once (dirname(__DIR__)."/model/forumDAO.php");
	include_once (dirname(__DIR__)."/model/ForumOnderwerpModel.php");

	$forumdao = new forumDAO();
	
	$title = "Forum Overzicht";
	$style = "forum";
	
	page_header($title, $style);	
	
	$onderwerpen = $forumdao->getAllOnderwerpen();
	
	echo "
		<section id='forumPageContent'>
		<a href='../index.php'>Home</a>
		";
		
	echo "<table id='ondwerpenTabel'>
			<tr>
				<th>Onderwerp</th>
				<th>Aantal Posts</th>
			</tr>
		";
		
	foreach ( $onderwerpen as $onderwerp ){
		echo "
			<tr>
				<td><a href='onderwerp.php?onderwerp_id={$onderwerp->id}' >{$onderwerp->naam}</a></td>
				<td>{$onderwerp->aantalPosts}</td>
			</tr>
			";
	}
	
	echo "
		</table>
		</section>";
?>
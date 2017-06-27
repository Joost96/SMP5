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
		
	echo "<table id='onderwerpenTabel'>
			<tr>
				<th>Onderwerp</th>
				<th>Aantal Posts</th>
			</tr>
		";
	
	$i = 1;
	foreach ( $onderwerpen as $onderwerp ){
		echo "
			<tr class='".
			addTableClass($i)
			."'>
				<td><a href='onderwerp.php?onderwerp_id={$onderwerp->id}' >{$onderwerp->naam}</a></td>
				<td>{$onderwerp->aantalPosts}</td>
			</tr>
			";
			$i++;
	}
	
	echo "
		</table>
		</section>";
		
	function addTableClass ($i){
		if ($i % 2 == 0){
			return "even";
		} else {
			return "odd";
		}
	}
?>
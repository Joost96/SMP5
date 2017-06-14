<?php
	require '../func/page_header.php';
	require '../func/forumdao.php';
	
	$titel = "Forum Overzicht";
	
	page_header($titel);	
	
	$onderwerpen = getAllOnderwerpen();

	print "
		<h2>{$titel}</h2><br/>

		";
		
	if ($onderwerpen) {
		while ($row = $onderwerpen->fetch_assoc()){
			echo "<a href='onderwerp.php?onderwerp_id={$row['ID']}' >{$row['naam']}</a> <br/>";
		}
	}
	
?>
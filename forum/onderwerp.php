<?php
	require '../func/page_header.php';
	require '../func/forumdao.php';
	
	$onderwerp_id = $_GET['onderwerp_id'];
	
	$title = "";
	
	if($title = getOnderwerpbyid($onderwerp_id)->fetch_assoc()['naam'])	{
		page_header($title);
	}
	
	echo "
		<h2>{$title}</h2>
		<br>
		";
	
	
	$posts = getPostbyOnderwerp($onderwerp_id);
	
	if($posts){
		while ($row = $posts->fetch_assoc()){
			echo "<a href=post.php?post_id={$row['ID']}>{$row['titel']}</a><br>";
		}
	}
	
?>
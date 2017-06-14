<?php
	require '../func/forumdao.php';
	
	echo $_POST['post_id']."<br>";
	echo $_POST['reactie_content']."<br>";
	
	postReactie($_POST['post_id'], $_POST['reactie_content']);
		
	header("location: post.php?post_id={$_POST['post_id']}");
	echo "
		<a href='post.php?post_id={$_POST['post_id']}'>post</a>
		"
	
?>
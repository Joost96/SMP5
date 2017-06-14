<?php
	require '../func/page_header.php';
	require '../func/forumdao.php';
	
	$post_id = $_GET['post_id'];
	
	$post = getPostbyid($post_id);
	
	$reacties = getAllReacties($post_id);
	
	if($post){
		$post = $post->fetch_assoc();
	
		$titel = $post['titel'];
		$content = $post['content'];
	}

	page_header2($titel);

	echo "
		<h2>{$titel}</h2><br>
		<p>{$content}</p><br>
		";
			
	echo "
		<form action='reactie.php' method='post'>
			<label for='reactie'>Reactie:</label><br>
			<input type='text' value='' id='reactie' name='reactie_content' /><br>
			<input type='hidden' value='{$post_id}' name='post_id' />
			<input type='submit' value='POST' />
		</form>
		";		
	if($reacties){
		while ($row = $reacties->fetch_assoc()){
			echo "
				<p>{$row['content']}</p>
				";
		}
	}
?>
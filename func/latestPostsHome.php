<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/ForumPostModel.php');
	
	$forumDAO = new forumDAO();
	
	$latestPosts = $forumDAO->GetLatestPosts();
	
	foreach($latestPosts as $post)
	{
		$datetime = new datetime($post->datum);
		
		$datum = $datetime->format('D d M');
		$tijd = $datetime->format('H:i');
		echo "<a href='/smp5/forum/post.php?post_id={$post->id}'>
				<div class='forumposthome'>
					<h4>$post->titel</h4><h5>In: $post->onderwerp</h5>
					<h6>Geplaatst op: $datum Om: $tijd Door: $post->user</h6>
					<p>$post->content</p>
				</div>
			</a>";
	}
?>
	
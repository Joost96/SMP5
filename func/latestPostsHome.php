<?php
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/ForumPostModel.php');
	
	$forumDAO = new $forumDAO();
	
	$latestPosts = $forumDAO->GetLatestPosts();
	
	foreach($latestPosts as $post)
	{
		$datetime = new datetime($post->datum);
		
		$datum = $datetime->format('M - D');
		$tijd = $datetime->format('H:i');
		echo "<div class='forumposthome'>
				<h5>$post->titel</h5><h6>$post->onderwerpId</h6><br />
				<h4>geplaatst op: $datum om: $tijd door: $post->user</h4><br /><br />
				<p>$post->content</p>
			</div>";
	}
?>
	
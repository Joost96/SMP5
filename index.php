<!DOCTYPE HTML>
<html>
	<?php require (dirname(__DIR__).'/smp5/func/page_header_home.php');
	page_header("home", "home", "home");
	?>
	
	<article class="slideshow">
	<?php include (dirname(__DIR__).'/smp5/func/homeSlideshow.php');?>
	</article>
	
	
	
	<div class="feed">
	<hr class="style3">
	<br />
	<h2>SOCIAL MEDIA</h2>
	<br />
	<hr class="style3">
		<script src="//assets.juicer.io/embed.js" type="text/javascript"></script>
		<link href="//assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
		<ul class="juicer-feed" data-feed-id="inholland-977ec6ea-0534-4cec-9b2b-e4c4e2060407" data-pages="1" data-per="15" data-truncate="50"></ul>
	</div>
	<div class="forumoverzicht">
		<br />
		<hr class="style3">
		<br />
		<h2>FORUM</h2>
		<br />
		<hr class="style3">
		<br />
		<?php include (dirname(__DIR__).'/smp5/func/latestPostsHome.php'); ?>
	</div>	
	<hr class="style3">
	
	<br />
	<br />
	   <script>
			var index = 0;
			slideShow();
			
			function slideShow() {
				var i;
				var buttons = document.getElementsByClassName("button");
				var j = document.getElementsByClassName("slide");
					for (i =0; i < j.length; i++)
					{
						j[i].style.display = "none";
					}
				index++;
					if (index > j.length)
					{
						index = 1;
					}
					for (i = 0; i < buttons.length; i++) 
					{
						buttons[i].className = buttons[i].className.replace(" active", "");
					}			
				j[index-1].style.display = "block";
				buttons[index-1].className += " active";	
				setTimeout(slideShow, 8000);
				}
		</script>
</html>
<?php
	include (dirname(__DIR__).'/smp5/model/InstaScraper.php');
	
	$url = "https://www.instagram.com/p/BUr70d5AasK/?taken-by=inholland.informatica&hl=nl";
	$insta = new InstagramScraper();
	
	$foto = $insta->image($url);
	
	echo "<a href=$url><img src=$foto></a>";
	
?>
<?php
	include (dirname(__DIR__).'/smp5/model/InstaScraper.php');
	
	$url = "https://www.instagram.com/p/BRRJJZ1lg_w/?taken-by=neo_fk";
	$insta = new InstagramScraper();
	
	$foto = $insta->image($url);
	
	echo "<a href=$url><img src=$foto></a>";
	
?>
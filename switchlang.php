<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	session_start();
	if(strcmp($_GET["lang"], "en") == 0) {
		$_SESSION["lang"] = "en";
		echo "going to en<br>";
	} else {
		echo "not en <br>";
	}
	if(strcmp($_GET["lang"], "nl") == 0) {
		$_SESSION["lang"] = "nl";
		echo "going to nl<br>";
	} else {
		echo "not nl<br>";
	}
	header("Location: ".$_GET["page"]); /* Redirect browser */
	exit();
?>
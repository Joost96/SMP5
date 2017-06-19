<!DOCTYPE HTML>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="css/home.css">
		<meta charset="UTF-8">
		<meta name="Thuispagina" content="Opleiding informatica">
		<meta name="keywords" content="informatica, inholland, haarlem, studenten, hbo, it, ict">
		<meta name="author" content="Joshua Volkers">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
	
	<ul class="navbar">	
	<li><a href="index.html">Home</a></li>
		<li class="dropdown">
			<a class="dropknop">Menu</a>
				<div class="menuItems">
					<a href="index.php">Thuis</a>
					<a href="forum/overzicht.php">Forum</a>
					<a href="curriculum.html">Curriculum</a>
					<a href="buiten.html">Buiten School</a>
					<a href="alumni.html">Succesverhalen</a>
					<a href="portfolio.php">Portfolio</a>
				</div>
		</li>			
		<li class="right"><a href="blabla">English</a></li>
		<li class="right"><a href="blabla">Inloggen</a></li>	
	</ul>
	
	<article class="slideshow">
		<img class="slide" src="http://static.nautil.us/3006_5f268dfb0fbef44de0f668a022707b86.jpg">
		<img class="slide" src="http://img.clipartall.com/number-20clipart-number-clip-art-1300_716.jpg">
		<img class="slide" src="http://www.englishnumber.com/images/numbers-01.gif">
	</article>
	
	<div class="buttons">
		<a href="portfolio.php" class="button"><p>Portfolio</br></br>Bekijk wat onze studenten allemaal maken</p></a>
		<a href="forum/overzicht.php" class="button"><p>Forum</br></br>Stel vragen en discusseer mee</p></a>
		<a href="#/Action3" class="button"><p>Succesverhalen</br></br>Lees verhalen van oud-studenten</p></a>
		<a href="#/Action4" class="button"><p>Haarlem</br></br>Ontdek wat er allemaal te doen is in Haarlem</p></a>
	</div>
	   
	
	<script>
	var index = 0;
	slideShow();
	
	function slideShow() {
		var i;
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
		
		j[index-1].style.display = "block";
		setTimeout(slideShow, 4000);
		}
	</script>
	</body>
</html>
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
		<li class="left"><a href="index.php">Home</a></li>		
		<li class="left"><a href="portfolio.php">Portfolio</a></li>
		<li class="left"><a href="alumni.php">Succesverhalen</a></li>
		<li class="left"><a href="curriculum.php">Studeren bij Inholland</a></li>	
		<li class="left"><a href="infoHaarlem.php">Buiten School</a></li>						
	</ul>
	
	<article class="slideshow">
		<img class="slide fade" src="../img/PortfolioMensen.jpg">
		<img class="slide fade" src="http://img.clipartall.com/number-20clipart-number-clip-art-1300_716.jpg">
		<img class="slide fade" src="http://www.englishnumber.com/images/numbers-01.gif">
	</article>
	
	<div class="buttons">
		<button class="button"><a href="forum/overzicht.php"><p>Praat Mee!</br>Bezoek ons forum en praat mee over de opleiding</p></a></button>
		<button class="button"><a href="portfolio.php"><p>Forum</br>Bij onze opleiding leer je werken met de nieuwste methoden en technieken</p></a></button>
		<button class="button"><a href="infoHaarlem.php"><p>Go Dutch!</br>Kom studeren in Nederland</p></a></button>
	</div>
	
	<div class="feed">
	<h2>SOCIAL MEDIA</h2>
	<hr class="style3">
		<script src="//assets.juicer.io/embed.js" type="text/javascript"></script>
		<link href="//assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
		<ul class="juicer-feed" data-feed-id="inholland-977ec6ea-0534-4cec-9b2b-e4c4e2060407"></ul>
	</div>
	
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
				setTimeout(slideShow, 3000);
				}
		</script>
	
	
	</body>
</html>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Portfolio</title>
		<link rel="stylesheet" type="text/css" href="home.css">
		<meta charset="UTF-8">
		<meta name="Portfolio" content="Opleiding informatica">
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
					<a href="index.html">Thuis</a>
					<a href="forum.html">Forum</a>
					<a href="curriculum.html">Curriculum</a>
					<a href="buiten.html">Buiten School</a>
					<a href="alumni.html">Succesverhalen</a>
					<a href="portfolio.html">Portfolio</a>
				</div>
		</li>			
		<li class="right"><a href="blabla">English</a></li>
		<li class="right"><a href="blabla">Inloggen</a></li>	
	</ul>
	
	<body>
	<aside class="filters">
	<h3>FILTERS</h3>
		<form action="" method="post" target="itemFrame">

		<div class="talen">
			<p>Talen: </p>
			<hr class="style2">
			<?php include (dirname(__DIR__).'/smp5/func/taalfilters.php');?>
		</div>
		
		<div class="jaar">
			</br>
			<p>Leerjaren: </p>
			<hr class="style2">
			<label><input type="checkbox" name="jaarfilter[]" value="jaar 1" checked />Jaar 1</label></br>
			<label><input type="checkbox" name="jaarfilter[]" value="jaar 2" checked />Jaar 2</label></br>
			<label><input type="checkbox" name="jaarfilter[]" value="jaar 3" checked />Jaar 3</label></br>
			<label><input type="checkbox" name="jaarfilter[]" value="jaar 4" checked />Jaar 4</label></br>
		</div>
		</br>
		<input type="submit" name="portfilterSubmit" value="Sorteer" />
		</form>
	</aside>

	<div class="itemsReturn">
	<?php include (dirname(__DIR__).'/smp5/func/portfilters.php'); ?>
	</div>

	</body>
</html>
	
	
	
	

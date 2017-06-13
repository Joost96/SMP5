<?php
	function page_header(){
		print "
			<head>
				<link rel='stylesheet' type='text/css' href='../css/shared.css'/>
			</head>
			<body>
				<img id='inholland_logo' src='../img/inholland_logo.png' alt='oops' />
				<table id='menu_table'>
					<tr>
						<th id='first_menu_item'>Inloggen</th>
						<th>English</th>
						<th>Menu</th>
					</tr>
				</table>
				<section id='spacing_section'></section>
				<div id="login" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1 class="center">Login</h1>
	<form action="login.php" method="post">
		<div>
			<label for="username">Gebruikersnaam</label>
			<input type="text" name="username"><br>
		</div>
		<div>
			<label for="password">Wachtwoord</label>
			<input type="password" name="password"><br>
		</div>
		<div class="center">
			<input type="submit">
			<input type="button" value="Annuleren">
		</div>
	</form>
  </div>

</div>
			
		";
	}
?>
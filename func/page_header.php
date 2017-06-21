<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	require (dirname(__DIR__).'/model/user.php');
	
	session_start();
	if (!isset($_SESSION['lang']) && empty($_SESSION['lang'])) {
		$_SESSION["lang"] = "nl";
	}
	
	function page_header(){
		$numargs = func_num_args();
		//override functionality with title , css file and script file
		if($numargs >= 1) {
			$page = func_get_arg(0);
			if($numargs == 3) {
				$css = func_get_arg(1);
				$script = func_get_arg(2);
				$css = "<link rel='stylesheet' type='text/css' href='/smp5/css/{$css}.css'/>";
				$script = "<script src='/smp5/js/{$script}.js'></script>";
			}
			else if($numargs == 2) {
				$css = func_get_arg(1);
				$css = "<link rel='stylesheet' type='text/css' href='/smp5/css/{$css}.css'/>";
				$script = "";
			} else {
				$css = "";
				$script = "";
			}

		} else {
			$page = "Informatica";
			$css = "";
			$script = "";
		}
		
		//set vars for in the header
		if($_SESSION["lang"] == "nl") {
			$taalbtn = "English";
			$switchTaal = "en";
		} else {
			$taalbtn = "Nederlands";
			$switchTaal = "nl";
		}
		if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
			$username = $_SESSION['user']->username;
		} else {
			$username = "NULL";
		}
		
		print "
			<!DOCTYPE html>
			<html>
				<head>
					<link rel='stylesheet' type='text/css' href='/smp5/css/style.css'/>
					<link rel='stylesheet' type='text/css' href='/smp5/css/login.css'/>
					{$css}
					<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
					<script src='/smp5/js/header.js'></script>
					{$script}
					<title>{$page}</title>
				</head>
					<body>
						<header>
							<a href='/smp5/index.php'><img id='inholland_logo' src='/smp5/img/inholland_logo.png' alt='inholland logo' /></a>
							<ul class='navbar'>
								<li class='dropdown'>
									<a class='dropknop'>Menu</a>
										<div class='menuItems'>
											<a href='/smp5/index.php'>Thuis</a>
											<a href='/smp5/forum/overzicht.php'>Forum</a>
											<a href='/smp5/curriculum.html'>Curriculum</a>
											<a href='/smp5/infohaarlem.php'>Buiten School</a>
											<a href='/smp5/alumni.php'>Succesverhalen</a>
											<a href='/smp5/portfolio.php'>Portfolio</a>
										</div>
								</li>			
								<li class='right'><a id='taalbtn' href='/smp5/func/switchlang.php?lang={$switchTaal}&page=".$_SERVER['REQUEST_URI']."'>{$taalbtn}</a></li>
								<li class='right'><a id='loginModalBtn'>Inloggen</a></li>
								<li class='right'><a id='username'>{$username}</a></li>
								
							</ul>
							<div class='title'>
								<h1>{$page}</h1>
							</div>
							<section id='spacing_section'></section>


							<!-- Modal login -->
							<div id='loginModel' class='modal'>
								<div class='modal-content'>
									<span class='close'>&times;</span>
									<h1 class='center'>Login</h1>
									<div class='form'>
										<div>
											<label for='username'>Gebruikersnaam</label>
											<input type='text' name='username'><br>
										</div>
										<div>
											<label for='password'>Wachtwoord</label>
											<input type='password' name='password'><br>
										</div>
										<div class='center'>
											<input id='loginBtn' type='submit'>
											<input type='button' value='Annuleren'>
										</div>
									</div>
									<h3 id='registerModalBtn' class='center clickable'>klik hier voor registreren<p>
								</div>
							</div>
							<!-- Modal register -->
							<div id='registerModel' class='modal'>
								<div class='modal-content'>
									<span class='close'>&times;</span>
									<h1 class='center'>Registreer</h1>
									<div class='form'>
										<div>
											<label for='username'>Gebruikersnaam*</label>
											<input type='text' name='username'>
										</div>
										<div>
											<label for='firstName'>Voornaam</label>
											<input type='text' name='firstName'>
										</div>
										<div>
											<label for='lastName'>Achternaam</label>
											<input type='text' name='lastName'>
										</div>
										<div>
											<label for='studentId'>Student ID</label>
											<input type='text' name='studentId'>
										</div>
										<div>
											<label for='email'>email*</label>
											<input type='email' name='email'>
										</div>
										<div>
											<label for='password'>Wachtwoord*</label>
											<input type='password' name='password'>
										</div>
										<div>
											<label for='confirmPassword'>bevestig wachtwoord*</label>
											<input type='password' name='confirmPassword'>
										</div>
										<div class='center'>
											<input id='registerBtn' type='submit' value='registreer'>
											<input type='button' value='Annuleren'>
										</div>
									</div>
								  </div>
							</div>
						</header>			
		";
	}
?>

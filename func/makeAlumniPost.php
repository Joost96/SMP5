<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set("allow_url_include", "1");
	session_start();
	//header('Content-Type: application/json');

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		include_once ("../model/alumniDAO.php");
		include_once ("../model/alumni.php");
		include_once ("../model/afbeeldingDAO.php");
		include_once ("../model/afbeelding.php");
		include_once ("../model/user.php");
		$alumniDAO = new alumniDAO();
		$afbeeldingDAO = new afbeeldingDAO();
		
		$dataurl = $_POST["img"];
		$dataurl = str_replace(' ','+',$dataurl);
		$dataurl =  substr($dataurl,strpos($dataurl,",")+1);
		$image = base64_decode($dataurl);
		$user = unserialize($_SESSION['user']);
		
		// Path where the image is going to be saved
		$filePath = '/smp5/img/alumni/'.$user->username.date("U").rand(0,999).'.jpeg';
		$file = fopen(dirname(__DIR__).'/..'.$filePath, 'w');
		fwrite($file, $image);
		fclose($file);
		$afbeeldingId = $afbeeldingDAO->createAfbeelding($filePath,"Alumni Profile picture van ".$user->username);
		
		$functie = trim_data($_POST["functie"]);
		$omschrijving = trim_data($_POST["omschrijving"]);
		$link = trim_data($_POST["link"]);
		
		$status = "";
		$alumni = $alumniDAO->CreateAlumni($user, $functie, $omschrijving, $link, $afbeeldingId);
		
		if (is_a($alumni, 'alumni')) {
			echo json_encode(array('status' => $status,'redirect'=> "alumni.php"));
		} else {
			echo json_encode(array('status' => $status));
		}
	}

	function trim_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();

	if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			include_once ("../model/infoTextDAO.php");
			include_once ("../model/infoText.php");
			include_once ("../model/afbeeldingDAO.php");
			include_once ("../model/afbeelding.php");
			include_once ("../model/user.php");
			$infoTextDAO = new infoTextDAO();
			$afbeeldingDAO = new afbeeldingDAO();
			
			$page = trim_data($_POST["page"]);
			$locatie = trim_data($_POST["locatie"]);
			$title = trim_data($_POST["title"]);
			$text = trim_data($_POST["text"]);
			$taal = trim_data($_POST["taal"]);
			$imgID = trim_data($_POST["imgId"]);//fix dit
			
			if(isset($_POST["img"]) {
				if(strpos($_POST["img"], 'date:') !== false) {
					$dataurl = $_POST["img"];
					$dataurl = str_replace(' ','+',$dataurl);
					$dataurl =  substr($dataurl,strpos($dataurl,",")+1);
					$image = base64_decode($dataurl);
					
					// Path where the image is going to be saved
					$filePath = '/smp5/img/info/'.$page."-".$locatie."-".$taal."-".date("U").'.jpeg';
					$file = fopen(dirname(__DIR__).'/..'.$filePath, 'w');
					fwrite($file, $image);
					fclose($file);
					$afbeeldingId = $afbeeldingDAO->createAfbeelding($filePath,"Image voor $title");
				}
			}
			echo $page.$locatie.$title.$text.$afbeeldingId.$taal;
			$infoText = new infoText($page, $locatie, $title, $text, $afbeeldingId, $taal);
			$infoTextDAO->updateInfoText($infoText);
			$status = "";
			/**if($status == "valid login") {
				echo json_encode(array('status' => $status,'user'=> $user));
			} else {
				echo json_encode(array('status' => $status));
			}**/
		}
	}

	function trim_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
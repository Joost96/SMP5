<?php
	session_start();
	header('Content-Type: application/json');
	if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
		if(unserialize($_SESSION['user'])->admin) {
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
				if(isset($_POST["title"]))
					$title = trim_data($_POST["title"]);
				$text = trim_data($_POST["text"]);
				$taal = trim_data($_POST["taal"]);
				if(isset($_POST["imgId"]))
					$imgId = trim_data($_POST["imgId"]);
				
				if(isset($_POST["img"])) {
					if(strpos($_POST["img"], 'data:') !== false) {
						try {
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
						} catch (Exception $e) {
							$status = "Afbeelding kon niet gemaakt worden , orgineel is behouden";
							$afbeeldingId =  $imgId;
						}
					} else {
						$afbeeldingId =  $imgId;
					}
				}
				if($afbeeldingId)
					$infoText = new infoText($page, $locatie, $title, $text, $afbeeldingId, $taal);
				else
					$infoText = new infoText($page, $locatie, null, $text, null, $taal);
				$infoResult = $infoTextDAO->updateInfoText($infoText);
				if(isset($infoResult) && !empty($infoResult))
					$status = "sucess";
				else
					$status = "item could not be saved";
				echo json_encode(array('status' => $status));
			}		
		} else {
			$status = "not an admin"
		}
	} else {
		$status = "no user login"
	}
	
	echo json_encode(array('status' => $status));

	function trim_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
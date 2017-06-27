<?php 
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		session_start();
		include_once (dirname(__DIR__).'/model/portfolioDAO.php');
		include_once (dirname(__DIR__).'/model/InstaScraper.php');
		include_once (dirname(__DIR__).'/model/afbeeldingDAO.php');
		include_once (dirname(__DIR__).'/model/user.php');	

		if(isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			$user = unserialize($_SESSION['user']);
		
			$portDAO = new portfolioDAO();
			

			$yt = "";
			
			$titelNL = ($_POST['titelNL']);
			$titelEN = ($_POST['titelEN']);
			$technieken = ($_POST['technieken']);
			$onderdelen = ($_POST['onderdelen']);
			var_dump($onderdelen);
			$jaar = ($_POST['jaar']);
			$fotos = ($_POST['fotos']);
			var_dump($fotos);
			$yt = ($_POST['yt']);
			$beschrijvingNL = ($_POST['beschrijving']);
			$description = ($_POST['description']);
			
			$portfolioID = $portDAO->CreateNewItem($titelNL, $titelEN, $technieken, $jaar, $yt, $beschrijvingNL, $description, $user);
			$afbDAO = new afbeeldingDAO();
			$instaScraper = new InstagramScraper();
				
				foreach($fotos as $foto)
				{
					$link = $instaScraper->image($foto);
					$beschrijving = "Instagramfoto voor: $titelNL";
					$afbeeldingID = $afbDAO->createAfbeelding($link, $beschrijving);
					echo $afbeeldingID;
					$afbDAO->createPortfolioAfbeelding($portfolioID, $afbeeldingID, $foto);
				}
		}
		
		foreach($onderdelen as $onderdeelid)
		{
			echo $onderdeelid;
			$onderdeel = (int)$onderdeelid;
			echo $onderdeel;
			$portDAO->koppelExamenonderdeel($portfolioID, $onderdeel);
		}
	}
	
		
?>
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
			$fotos = array();
			
			$titelNL = ($_POST['titelNL']);
			var_dump($titelNL);
			$titelEN = ($_POST['titelEN']);
			$technieken = ($_POST['technieken']);
			$onderdelen = ($_POST['onderdelen']);
			$jaar = ($_POST['jaar']);
			$fotos[] = ($_POST['fotos']);
			$yt = ($_POST['yt']);
			$beschrijvingNL = ($_POST['beschrijving']);
			$description = ($_POST['description']);
			
			$portfolioID = $portDAO->CreateNewItem($titelNL, $titelEN, $technieken, $jaar, $yt, $beschrijvingNL, $description, $user);
			if(count($fotos) !== 0)
			{
				$afbDAO = new afbeeldingDAO();
				$instaScraper = new InstagramScraper();
				
					foreach($fotos as $foto)
					{
						$link = $instaScraper->image($foto);
						$beschrijving = "Instagramfoto";
						$afbeeldingID = $afbDAO->createAfbeelding($link, $beschrijving);
						$afbDAO->createPortfolioAfbeelding($portfolioID, $afbeeldingID, $foto);
					}
			}
			foreach($onderdelen as $onderdeel)
			{
				$portDAO->koppelExamenonderdeel($portfolioID, $onderdeel);
			}
		}
	}	
		
?>
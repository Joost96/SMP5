<?php 
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		include_once (dirname(__DIR__).'smp5/model/portfolioDAO.php');
		include_once (dirname(__DIR__).'smp5/model/InstaScraper.php');
		include_once (dirname(__DIR__).'smp5/model/afbeeldingDAO.php');
		include_once (dirname(__DIR__).'smp5/model/user.php');
		
		if(isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			$user = unserialize($_SESSION['user']);
		}
		
		$portDAO = new portfolioDAO();
		$afbDAO = new afbeeldingDAO();
		$instaScraper = new InstagramScraper();
		
		$titelNL = ($_POST['titelNL']);
		$titelEN = ($_POST['titelEN']);
		$technieken = ($_POST['technieken']);
		$onderdelen = ($_POST['onderdelen']);
		$jaar = ($_POST['jaar']);
		$fotos = ($_POST['fotos']);
		$yt = ($_POST['yt']);
		$beschrijvingNL = ($_POST['beschrijving']);
		$description = ($_POST['description']);
		
		
		$portfolioID = $portDAO->CreateNewItem($titelNL, $titelEN, $technieken, $jaar, $yt, $beschrijvingNL, $description, $user);
		foreach($fotos as $foto)
		{
			$link = $instaScraper->image($foto);
			$beschrijving = "Instagramfoto";
			$afbeeldingID = $afbDAO->CreateNewItem($link, $beschrijving);
			$afbDAO->createPortfolioAfbeelding($portfolioID, $afbeeldingID, $foto);
		}
		
		foreach($onderdelen as $onderdeel)
		{
			$portDAO->koppelExamenonderdeel($portfolioID, $onderdeel);
		}
	}	
		
?>
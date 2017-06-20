<?php 
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	include_once (dirname(__DIR__).'/model/portfolioitem.php');
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	
	$itemID = $_GET['itemID'];
	
	$portDAO = new portfolioDAO();
	
	$item = $portDAO->GetItemForID($itemID);
	$afbeeldingen = $portDAO->GetAfbeeldingenForItem($itemID);
	$reacties = $portDAO->GetAllReactiesForItem($itemID);
	
	echo "<article class='portfolioitem'>
			<h1>$item->titel</h1>
			<p>$item->beschrijving<br />
			Door: $item->auteur<br />	
			Datum/Tijd: $item->datum<br />
			Leerjaar: $item->jaar</p>
		</article>
		<br />";
		
	foreach($afbeeldingen as $afbeelding)
	{
		echo "<a href=$afbeelding->instagrampostLink ><img src=$afbeelding->afbeeldingLink alt=$afbeelding->beschrijving/></a>";
	}
	
	foreach($reacties as $reactie)
	{
		echo "<article class='reactie'>
				<p>Door: $reactie->user<br />
				Datum/Tijd: $reactie->dateTime<br />
				$reactie->content</p>
				</article>";
	}
				
	
?>
		
			
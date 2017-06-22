<?php 
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	include_once (dirname(__DIR__).'/model/portfolioitem.php');
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	include_once (dirname(__DIR__)."/model/user.php");
	
	$itemID = $_GET['itemID'];
	
	$portDAO = new portfolioDAO();
	
	$item = $portDAO->GetItemForID($itemID);
	$afbeeldingen = $portDAO->GetAfbeeldingenForItem($itemID);
	$reacties = $portDAO->GetAllReactiesForItem($itemID);
	$examenonderdelen = $portDAO->GetExamenOnderdelenForItem($itemID);
	$onderdelen = "";
	
	foreach($examenonderdelen as $onderdeel)
	{
		$onderdelen .= $onderdeel . ", ";
	} 
	
	$onderdelen = substr($onderdelen, 0, -2);
	
	
	echo "<article class='portfolioitem'>
			<h1>$item->titel</h1>
			<h3>Door: $item->auteur<br />	
			Datum/Tijd: $item->datum<br />
			Leerjaar: $item->jaar
			Technieken: $item->technieken<br />
			Examenonderdeel: $onderdelen</h3>	
			<p>$item->beschrijving</p><br />		
		<br />
		<br />
		<h2>Media</h2>
		</article>
		<hr class='style4'>";
		
	echo "<div class='media'>";
	foreach($afbeeldingen as $afbeelding)
	{
		echo "<a href=$afbeelding->instagrampostLink ><img class='afbeelding' src=$afbeelding->afbeeldingLink alt=$afbeelding->beschrijving/></a>";
	}
	
	echo "<iframe class='yt' width='10000' height='10000' src='https://www.youtube.com/embed/qUsQZj6h9H0' frameborder='0' allowfullscreen></iframe>";
	echo "</div>";
	echo "<hr class='style4'>";
	
	foreach($reacties as $reactie)
	{
		echo "<article class='reactie'>
				<p>Door: {$reactie->user->getFullName()}<br />
				Datum/Tijd: $reactie->dateTime<br />
				$reactie->content</p>
				</article>";
	}
				
	
?>
		
			
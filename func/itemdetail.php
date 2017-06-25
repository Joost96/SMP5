<?php 
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	include_once (dirname(__DIR__).'/model/portfolioitem.php');
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	include_once (dirname(__DIR__).'/model/user.php');
	include_once (dirname(__DIR__).'/forum/plaatsReactie.php');
	
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
	
		$datetime = new datetime($item->datum);
		
		$datum = $datetime->format('D d M');
		$tijd = $datetime->format('H:i');
	
	echo "<article class='portfolioitem'>
			<h1>$item->titel</h1>
			<p>Door: $item->auteur<br />	
			Geplaatst op: $datum Om: $tijd<br />
			Leerjaar: $item->jaar<br />
			Technieken: $item->technieken<br />
			Examenonderdeel: $onderdelen</p>	
			<h2>$item->beschrijving</h2><br />		
		<br />
		<br />
		<h3>Media</h3>
		</article>
		<hr class='style4'>";
		
	echo "<div class='media'>";
	foreach($afbeeldingen as $afbeelding)
	{
		echo "<a href=$afbeelding->instagrampostLink ><img class='afbeelding' src=$afbeelding->afbeeldingLink alt=$afbeelding->beschrijving/></a>";
	}
	
	$ytlink = $item->youtubelink;		
	if( ($x_pos = strpos($ytlink, '=')) !== FALSE )
	{
		$ytlink = substr($ytlink, $x_pos + 1);
	}
	else 
	{
		$ytlink = basename($ytlink);
	}

	
	echo "<iframe class='yt' width='10000' height='10000' src='https://www.youtube.com/embed/$ytlink' frameborder='0' allowfullscreen></iframe>";
	echo "</div>";
	echo "<hr class='style4'>";
	
	foreach($reacties as $reactie)
	{
		$datetime = new datetime($reactie->dateTime);
		
		$datum = $datetime->format('D d M');
		$tijd = $datetime->format('H:i');
		
		echo "<article class='reactie'>
				<h6>{$reactie->user->getFullName()}</h6>
				<h5>$datum $tijd</h5>
				<hr class='style5'>
				<p>$reactie->content</p>
			</article>";
	}
	
	if(isset($_SESSION['user']) && !empty($_SESSION['user']))
	{
		$user = unserialize($_SESSION['user']);
		
		echo "<div class='nieuwereactieform'>
				<h6>$user->username</h6>
				<form class='reactieveld' action='/smp5/forum/plaatsReactie.php' method='post'>
				<textarea id ='veld' name='reactie_content' rows='6' cols='200' placeholder='Geef een reactie...'></textarea>
				<input type='hidden' value='{$itemID}' name='itemID' />
				<input id='portforeactie'  value='POST' type='submit'> 
				
				</form>
			</div>";
	}	
	
?>
		
			
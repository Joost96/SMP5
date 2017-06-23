<?php
	include_once (dirname(__DIR__).'/model/homeDAO.php');
	include_once (dirname(__DIR__).'/model/homeAfbeelding.php');
	
	$homeDAO = new homeDAO();
	
	$afbeeldingen = $homeDAO->GetAfbeeldingen();
	
	
	echo "<article class='slideshow'>";	
	foreach($afbeeldingen as $afbeelding)
	{
		echo "<a href={$afbeelding->paginalink}.php><img class='slide fade' src={$afbeelding->afbeeldingLink}></a>";
	}
		echo "<div class='buttons'>";
		for($i = 1; $i < count($afbeeldingen)+1; $i++)
		{
			echo "<button class='button' id='button{$i}'><a href={$afbeeldingen[$i-1]->paginalink}.php><p>{$afbeeldingen[$i-1]->titel}</br>{$afbeeldingen[$i-1]->ondertitel}</p></a></button>";
		}
		echo "</div>";
	echo "</div>";		
?>
	
<?php
	include_once ("portfolioDAO.php");
	$portDAO = new portfolioDAO();
	$talen = array();
	$talen = $portDAO->GetAllTalen();
	
	foreach($talen as $taal => $naam)
	{
	echo "<label><input type='checkbox' name='taalfilter[]' value=".$naam['naam']." checked />".$naam['naam']."</label></br>";
	}
?>
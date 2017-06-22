<?php
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	$portDAO = new portfolioDAO();
	
	$onderdelen = array();
	$onderdelen = $portDAO->GetExamenOnderdelen();
	
	foreach($onderdelen as $onderdeel)
	{
		echo "<label><input type='checkbox' name='onderdeelfilter' value=$onderdeel->ID checked />$onderdeel->naam</label></br>";
	}
?>
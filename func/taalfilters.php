<?php
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	$portDAO = new portfolioDAO();
	$talen = array();
	$talen = $portDAO->GetAllTalen();
	
	foreach($talen as $taal)
	{
	echo "<label><input type='checkbox' name='taalfilter' value=$taal->ID checked />$taal->naam</label></br>";
	}
?>
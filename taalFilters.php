<?php
	include_once ("portfolioDAO.php");
	$portDAO = new portfolioDAO();
	$talen = array();
	$talen = $portDAO->GetAllTalen();
	
	echo "kaasschaaf";
	
	foreach($talen as $taal)
	{
	echo "<label><input type='checkbox' name='taalfilter[]' value=""$taal"" checked />$taal</label></br>";
	}
?>
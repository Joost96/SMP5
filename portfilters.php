<?php
	include_once ("portfolioDAO.php");
	include_once ("portfolioItem.php");
	$portDAO = new portfolioDAO();
	$taalFilters = $_POST['taalfilter'];
	$jaarFilters = $_POST['jaarfilter'];
	
	if(empty($taalFilters) && empty($jaarFilters))
	{
		header("Location:portfolio.html");
		exit;
	}
	else
	{
		$n = count($jaarFilters) + count(taalFilters);	
		echo "You selected $n filters <br/>";
		
		$test = '';
		$i;
		for($i = 0; $i < 5; $i++)
		{
			$test .= "test, ";
		}
		
		$test=rtrim($test, ", ");
		echo $test ."<br/>";

		$items = array();
		$items = $portDAO->GetAllItems();
		foreach($items as $item)
		{
		echo "<article>";
		echo	"<h3>$item->titel</h3>";
		echo	"<p>$item->beschrijving</p>";
		echo	"<p>Auteur: $item->auteur</p>";
		echo	"<p>Datum:$item->datum</p>";
		echo	"<img src=$item->afbeelding alt=$item->titel/>";
		echo "</article>";
		}
	}	
?>
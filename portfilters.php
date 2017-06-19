<?php
	include_once ("portfolioDAO.php");
	include_once ("portfolioItem.php");
	$portDAO = new portfolioDAO();
	$taalFilters = array();
	$jaarFilters = array();
	if(isset($_POST['taalfilter']))
	{
		$taalFilters = $_POST['taalfilter'];
	}
	if(isset($_POST['jaarfilter']))
	{
		$jaarFilters = $_POST['jaarfilter'];
	}	
	
	if((empty($taalFilters)) && (empty($jaarFilters)))
		{
			$items = array();
			$items = $portDAO->GetAllItems();
			
			EchoItems($items);
		}
	
	else
		{	
			$items = array();
			$items =$portDAO->GetItemsForFilter($taalFilters, $jaarFilters);
			
			EchoItems($items);
		}
	
	function EchoItems($items)
	{
		foreach($items as $item)
		{
		echo "<article class='item'>
				<img src=$item->thumbnail alt=$item->titel/>
				<h3>$item->titel</h3>
				<p>$item->beschrijving<br /><br /><br />
				Door: $item->auteur<br />	
				Datum/Tijd: $item->datum</p>				
			 </article>
			 </br>
			 <hr class='style3'>	
			 </br>";
		}
	} 
?>
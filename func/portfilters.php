<?php
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	include_once (dirname(__DIR__).'/model/portfolioItem.php');
	$portDAO = new portfolioDAO();
	$onderdeelfilter = array();
	$jaarFilters = array();
	if(isset($_POST['onderdeelfilter']))
	{
		$onderdeelfilter = $_POST['onderdeelfilter'];
	}
	if(isset($_POST['jaarfilter']))
	{
		$jaarFilters = $_POST['jaarfilter'];
	}	
	
	if((empty($onderdeelfilter)) && (empty($jaarFilters)))
		{
			$items = array();
			$items = $portDAO->GetAllItems();
			
			EchoItems($items);
		}
	
	else
		{	
			$items = array();
			$items =$portDAO->GetItemsForFilter($onderdeelfilter, $jaarFilters);
			
			EchoItems($items);
		}
	
	function EchoItems($items)
	{
		foreach($items as $item)
		{
			echo "<article class='item'>
					<a href='portfoliodetail.php?itemID={$item->ID}' ><img src=$item->thumbnail alt=$item->titel/></a>
					<a href='portfoliodetail.php?itemID={$item->ID}' ><h1>$item->titel</a></h1>
					<p>$item->beschrijving<br /><br /><br />
					Door: $item->auteur<br />	
					Datum/Tijd: $item->datum<br />
					Leerjaar: $item->jaar</p>
				 </article>
				 </br>
				 <hr class='style3'>	
				 </br>";
		}
	} 
?>
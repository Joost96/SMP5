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
			$datetime = new datetime($item->datum);	
			$datum = $datetime->format('D d M');
			$tijd = $datetime->format('H:i');
			$string = $item->beschrijving;
			$leesmeer = "<a href='portfoliodetail.php?itemID={$item->ID}' class='leesmeer' > ...lees meer</a>";
			$beschrijving = (strlen($string) > 85) ? substr($string, 0, 85) . $leesmeer : $string;
			
			echo "<article class='item'>
					<a href='portfoliodetail.php?itemID={$item->ID}' ><img src=$item->thumbnail alt=$item->titel/></a>
					<a href='portfoliodetail.php?itemID={$item->ID}' ><h1>$item->titel</a></h1>
					<h2>$beschrijving</h2><br /><br /><br />
					<p>Door: $item->auteur<br />	
					Geplaatst op: $datum Om: $tijd<br />
					Leerjaar: $item->jaar</p>
				 </article>
				 <br />
				 <hr class='style3'>
				 <br />";	
		}
	} 
?>
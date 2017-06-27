<?php
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	include_once (dirname(__DIR__).'/model/portfolioItem.php');
	include_once (dirname(__DIR__).'/model/user.php');
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
		if(isset($_SESSION['user']) && !empty($_SESSION['user']))
				$user unserialize($_POST['user']);
		
		else 
			$user = new user(NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		foreach($items as $item)
		{
			
			$datetime = new datetime($item->datum);	
			$datum = $datetime->format('D d M');
			$tijd = $datetime->format('H:i');
			$string = $item->beschrijving;
			$leesmeer = "<a href='portfoliodetail.php?itemID={$item->ID}' class='leesmeer' > ...lees meer</a>";
			$beschrijving = (strlen($string) > 85) ? substr($string, 0, 85) . $leesmeer : $string;
			
			echo "<article class='item'>
					<input type='hidden' id='hiddenID' value='$item->ID>
					<a href='portfoliodetail.php?itemID={$item->ID}' ><img src=$item->thumbnail alt=$item->titel/></a>
					<a href='portfoliodetail.php?itemID={$item->ID}' ><h1>$item->titel</a></h1>
					<h2>$beschrijving</h2><br /><br /><br />
					<p>Door: $item->auteur<br />	
					Geplaatst op: $datum Om: $tijd<br />
					Leerjaar: $item->jaar</p>
					"if($user->id == $item->auteur)
						echo "<button id='deleteKnop'>Delete</button>";
				 "</article>
				 <br />
				 <hr class='style3'>
				 <br />";	
		}
	} 
?>
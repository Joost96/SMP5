<?php
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	include_once (dirname(__DIR__).'/model/portfolioDAO.php');
	
	function printPortfoReacties ($itemID){
		
		$portDAO = new portfolioDAO();
		$reacties = $portDAO->GetAllReactiesForItem($itemID);

		foreach($reacties as $reactie)
		{
			$datetime = new datetime($reactie->dateTime);
			
			$datum = $datetime->format('D d M');
			$tijd = $datetime->format('H:i');
			
			echo "<article class='reactie'>
					<h6>{$reactie->user->username}</h6>
					<h5>$datum $tijd</h5>
					<hr class='style5'>
					<p>$reactie->content</p>
				</article>";
		}
	}
?>
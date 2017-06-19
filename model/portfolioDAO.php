<?php
	include_once (dirname(__DIR__).'/model/localBase.php');
	include_once (dirname(__DIR__).'/model/informaticaBase.php');
	include_once (dirname(__DIR__).'/model/portfolioItem.php');
	class portfolioDAO
	{
	
		function connectLocal()
		{
			$dbObject = new localBase();
			$dbObject-> connect();
			
			$databaseConn = $dbObject->getConnection();
			return $databaseConn;
		}
		
		function connect()
		{
			$dbObject = new informaticaBase();
			$dbObject-> connect();
			
			$databaseConn = $dbObject->getConnection();
			return $databaseConn;
		}
		
		function executeItem($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if(!$result)
			{
				echo "Er is iets mis gegaan bij het communiceren met de database, neem contact op met de administrator van de website";
			}
			
			$items = array();
			
			while($row = $result->fetch_assoc())
			{
				$portfolioItem = new portfolioItem($row["ID"], $row["titel"], $row["username"], $row["beschrijving"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"]);									
				
				$items[] = $portfolioItem;
			}
			return $items;	
			
			$databaseConn->Close();
		
		}
	
		function GetItemsForFilter($taalFilters, $jaarFilters)
		{
		$filters = '';
			
			for($i = 0; $i < count($jaarFilters); $i++)
			{
				$filters .= "portfolioItem.leerjaar = '$jaarFilters[$i]' or ";
			}
			
			for($i = 0; $i < count($taalFilters); $i++)
			{
				$filters .= "programmeertaal.naam = '$taalFilters[$i]' or ";
			}

			$filters = substr($filters, 0, -3);			
		
		$sql = "SELECT DIStINCT portfolioItem.ID, portfolioItem.titel, portfolioItem.beschrijving, 
				portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username
				FROM portfolioItem, afbeelding, programmeertaal, user, P_T 
				WHERE portfolioItem.auteur_ID = user.ID AND P_T.portfolio_ID = portfolioItem.ID AND
				P_T.programmeertaal_ID = programmeertaal.ID AND afbeelding.portfolioitem_ID = portfolioItem.ID
				AND ($filters)";
		
		return $this->executeItem($sql);
		}
	
		function GetAllItems()
		{
		$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel, portfolioItem.beschrijving, 
				portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username
				FROM portfolioItem, afbeelding, programmeertaal, user, P_T 
				WHERE portfolioItem.auteur_ID = user.ID AND P_T.portfolio_ID = portfolioItem.ID AND
				P_T.programmeertaal_ID = programmeertaal.ID AND afbeelding.portfolioitem_ID = portfolioItem.ID";
		
		return $this->executeItem($sql);
		}
	
		
		function GetAllTalen()
		{
		$sql = "SELECT naam FROM programmeertaal";
		
		return $this->executeTaal($sql);
		}
		
				
		function executeTaal($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql) or die($databaseConn->error);
			$talen = array();
			
			while($row = $result->fetch_assoc())
			{
				$talen[] = $row;
			}
			
			return $talen;		
		}
		
	}
?>	
			
	
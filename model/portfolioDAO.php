<?php
	include_once (dirname(__DIR__).'/model/localBase.php');
	include_once (dirname(__DIR__).'/model/informaticaBase.php');
	include_once (dirname(__DIR__).'/model/portfolioItem.php');
	include_once (dirname(__DIR__).'/model/programmeertaal.php');
	include_once (dirname(__DIR__).'/model/portfolioAfbeelding.php');
	include_once (dirname(__DIR__)."/model/userDAO.php");
	include_once (dirname(__DIR__)."/model/user.php");
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
		
		function checkResult($result)
		{
			if(!$result)
			{
				echo "<br /><br />" . "Er is iets mis gegaan bij het communiceren met de database, neem contact op met de administrator van de website" . "<br /><br />";
				return false;
			}
			else
			{
				return true;
			}
		}
		function executeItems($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if($this->checkResult($result) == false)
			{
				echo "PortfolioItems konden niet opgehaald worden";
				exit;
			}
			
			$items = array();
			
			while($row = $result->fetch_assoc())
			{
				$portfolioItem = new portfolioItem($row["ID"], $row["titel"], $row["username"], $row["beschrijving"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"]);									
				
				$items[] = $portfolioItem;
			}
			
			$databaseConn->Close();	
			return $items;			
		}
		
		function executeItem($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if($this->checkResult($result) == false)
			{
				echo "PortfolioItem kon niet opgehaald worden";
				exit;
			}
			
			while($row = $result->fetch_assoc())
			{
				$portfolioItem = new portfolioItem($row["ID"], $row["titel"], $row["username"], $row["beschrijving"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"]);									
			}
			
			$databaseConn->Close();	
			return $portfolioItem;			
		}
		
		/*Hier worden de jaarfilters en taalFilters doorgegeven, aan de hand van deze filters wordt een string gemaakt. Deze string wordt gereturned*/
		function createFilterString($taalFilters, $jaarFilters)
		{
			$filters = '';
		
			for ($i = 0; $i < count($taalFilters); $i++)
			{		
				if(!is_numeric($taalFilters[$i]))
				{
					unset($taalFilters[$i]);
					$taalFilters = array_values($taalFilters);
				}
			}
			
			for ($i = 0; $i < count($jaarFilters); $i++)
			{		
				if(!is_numeric($jaarFilters[$i]))
				{
					unset($jaarFilters[$i]);
					$jaarFilters = array_values($jaarFilters);
				}
			}
			
			for($i = 0; $i < count($jaarFilters); $i++)
			{
				$filters .= "portfolioItem.leerjaar =" .$jaarFilters[$i]." or ";
			}
			
			for($i = 0; $i < count($taalFilters); $i++)
			{
				$filters .= "programmeertaal.ID =" .$taalFilters[$i]." or ";
			}
				
			return $filters = substr($filters, 0, -4);	
		}
	
		/* Hier haal ik de juiste items op voor de doorgegeven filters, er wordt een methode aangeroepen die de juiste string samenstelt die in de query gezet kan worden*/
		function GetItemsForFilter($taalFilters, $jaarFilters)
		{		
		$filters = '';
		$filters = $this->createFilterString($taalFilters, $jaarFilters);
		
		$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel, portfolioItem.beschrijving, 
				portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username
				FROM portfolioItem, afbeelding, portfolioAfbeelding, programmeertaal, user, P_T 
				WHERE portfolioItem.auteur_ID = user.ID AND P_T.portfolio_ID = portfolioItem.ID AND
				P_T.programmeertaal_ID = programmeertaal.ID AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID
				AND portfolioAfbeelding.afbeelding_id = afbeelding.ID
				AND ($filters) ORDER BY portfolioItem.leerjaar ASC";
		
		return $this->executeItems($sql);
		}
		
		/*Hier wordt een specifiek item opgehaald, om deze vervolgens op een detail pagina te tonen*/
		function GetItemForID($ID)
		{
			$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel, portfolioItem.beschrijving, 
					portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username
					FROM portfolioItem, afbeelding, programmeertaal, portfolioAfbeelding, user, P_T 
					WHERE portfolioItem.auteur_ID = user.ID AND P_T.portfolio_ID = portfolioItem.ID AND
					P_T.programmeertaal_ID = programmeertaal.ID AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID
					AND portfolioAfbeelding.afbeelding_id = afbeelding.ID
					AND portfolioItem.ID = $ID";
				
		return $this->executeItem($sql);
		}
	
		/*Hier worden alle items uit de database opgehaald*/
		function GetAllItems()
		{
		$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel, portfolioItem.beschrijving, 
				portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username
				FROM portfolioItem, afbeelding, portfolioAfbeelding, programmeertaal, user, P_T 
				WHERE portfolioItem.auteur_ID = user.ID AND P_T.portfolio_ID = portfolioItem.ID AND
				P_T.programmeertaal_ID = programmeertaal.ID AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID
				AND portfolioAfbeelding.afbeelding_id = afbeelding.ID
				ORDER BY portfolioItem.leerjaar ASC";
		
		return $this->executeItems($sql);
		}
		
		/*Hier worden alle reacties voor een specifiek portfolio-item opgehaald*/
		function GetAllReactiesForItem($ID)
		{
			$sql = "SELECT reactie.ID, user.username, reactie.content, reactie.datum
					FROM reactie, user
					WHERE user.ID = reactie.user_id AND reactie.portfolioItem_id = $ID";
					
			return $this->executeReacties($sql);
		}
		
		function executeReacties($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if($this->checkResult($result) == false)
			{
				echo "Reacties konden niet geladen worden";
				exit;
			}
			
			$reacties = array();
			
			while($row = $result->fetch_assoc())
			{
				$userDAO = new userDAO();
				$user = $userDAO->GetUser($row["username"]);
				$reactie = new ReactieModel($row['ID'], NULL, NULL, $user, $row['content'], $row['datum']);
				$reacties[] = $reactie;
			}
			
			$databaseConn->Close();
			
			return $reacties;					
		}
		
		/*Hier worden alle afbeeldingen van een portfolio-item opgehaald*/
		function GetAfbeeldingenForItem($ID)
		{
			$sql = "SELECT * FROM afbeelding, portfolioAfbeelding WHERE portfolioAfbeelding.afbeelding_id = afbeelding.ID
			AND portfolioAfbeelding.portfolioItem_ID = $ID";
			
		return $this->executeAfbeeldingen($sql);
		}
		
		function executeAfbeeldingen($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if($this->checkResult($result) == false)
			{
				echo "Afbeeldingen kunnen niet geladen worden";
				exit;
			}
			
			$afbeeldingen = array();
			
			while($row = $result->fetch_assoc())
			{
				$portfolioAfbeelding = new portfolioAfbeelding($row['ID'], $row['portfolioitem_ID'], $row['afbeeldinglink'], $row['instagrampostlink'], $row['beschrijving']);
				
				$afbeeldingen[] = $portfolioAfbeelding;
			}
			
			$databaseConn->Close();
			
			return $afbeeldingen;		
		}
	
		/*Hier worden alle programmeertalen uit de database opgehaald.*/
		function GetAllTalen()
		{
		$sql = "SELECT * FROM programmeertaal";
		
		return $this->executeTaal($sql);
		}
		
				
		function executeTaal($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if($this->checkResult($result) == false)
			{
				exit;
			}
			
			$talen = array();
			
			while($row = $result->fetch_assoc())
			{
				$programmeertaal = new programmeertaal($row["ID"], $row["naam"]);
				
				$talen[] = $programmeertaal;
			}
			
			$databaseConn->Close();
			
			return $talen;		
		}
		
	}
?>	
			
	
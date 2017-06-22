<?php
	include_once (dirname(__DIR__).'/model/informaticaBase.php');
	include_once (dirname(__DIR__).'/model/portfolioItem.php');
	include_once (dirname(__DIR__).'/model/portfolioAfbeelding.php');
	include_once (dirname(__DIR__)."/model/userDAO.php");
	include_once (dirname(__DIR__)."/model/user.php");
	include_once (dirname(__DIR__)."/model/examenonderdeel.php");
	class portfolioDAO
	{	
		/**/
		/**/
		/**/		
		var $dbObject;
		
		public function __construct() {
			$this->dbObject = new InformaticaBase();
		}
		function connect()
		{
			$this->dbObject->connect();
			
			$databaseConn = $this->dbObject->getConnection();
			return $databaseConn;
		}
		function closeConnection() {
			mysqli_close($this->dbObject->getConnection());
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
		
				
		/*Hier worden de jaarfilters en taalFilters doorgegeven, aan de hand van deze filters wordt een string gemaakt. Deze string wordt gereturned*/
		function createFilterString($onderdeelfilter, $jaarFilters)
		{
			$filters = '';
		
			for ($i = 0; $i < count($onderdeelfilter); $i++)
			{		
				if(!is_numeric($onderdeelfilter[$i]))
				{
					unset($onderdeelfilter[$i]);
					$onderdeelfilter = array_values($onderdeelfilter);
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
			
			for($i = 0; $i < count($onderdeelfilter); $i++)
			{
				$filters .= "examenonderdeel.id =" .$onderdeelfilter[$i]." or ";
			}
				
			return $filters = substr($filters, 0, -4);	
		}
		
		/**/
		/**/
		/**/
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
				$portfolioItem = new portfolioItem($row["ID"], $row["titel_nl"], $row["username"], $row["beschrijving_nl"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"], NULL, NULL);									
				
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
				$portfolioItem = new portfolioItem($row["ID"], $row["titel_nl"], $row["username"], $row["beschrijving_nl"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"], NULL, $row['youtubelink']);									
			}
			
			$databaseConn->Close();	
			return $portfolioItem;			
		}
		
		/**/
		/**/
		/**/
		/* Hier haal ik de juiste items op voor de doorgegeven filters, er wordt een methode aangeroepen die de juiste string samenstelt die in de query gezet kan worden*/
		function GetItemsForFilter($onderdeelfilter, $jaarFilters)
		{		
		$filters = '';
		$filters = $this->createFilterString($onderdeelfilter, $jaarFilters);
		
		$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel_nl, portfolioItem.beschrijving_nl, 
				portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username 
				FROM portfolioItem, afbeelding, portfolioAfbeelding, examenonderdeel, user, P_E 
				WHERE portfolioItem.auteur_ID = user.ID AND P_E.portfolioitemId = portfolioItem.ID 
				AND P_E.examenonderdeelId = examenonderdeel.id AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID 
				AND portfolioAfbeelding.afbeelding_id = afbeelding.ID 
				AND ($filters) ORDER BY portfolioItem.leerjaar ASC";
		
		return $this->executeItems($sql);
		}
		
		/*Hier wordt een specifiek item opgehaald, om deze vervolgens op een detail pagina te tonen*/
		function GetItemForID($ID)
		{
			$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel_nl, portfolioItem.beschrijving_nl, 
					portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username, portfolioItem.technieken 
					FROM portfolioItem, afbeelding, portfolioAfbeelding, examenonderdeel, user, P_E 
					WHERE portfolioItem.auteur_ID = user.ID AND P_E.portfolioitemId = portfolioItem.ID 
					AND P_E.examenonderdeelId = examenonderdeel.id AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID 
					AND portfolioAfbeelding.afbeelding_id = afbeelding.ID 
					AND portfolioItem.ID = $ID";
				
		return $this->executeItem($sql);
		}
	
		/*Hier worden alle items uit de database opgehaald*/
		function GetAllItems()
		{
		$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel_nl, portfolioItem.beschrijving_nl, 
				portfolioItem.leerjaar, portfolioItem.datum, afbeelding.afbeeldinglink, user.username 
				FROM portfolioItem, afbeelding, portfolioAfbeelding, examenonderdeel, user, P_E 
				WHERE portfolioItem.auteur_ID = user.ID AND P_E.portfolioitemId = portfolioItem.ID 
				AND P_E.examenonderdeelId = examenonderdeel.id AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID 
				AND portfolioAfbeelding.afbeelding_id = afbeelding.ID 
				ORDER BY portfolioItem.leerjaar ASC";
		
		return $this->executeItems($sql);
		}
		
		function GetExamenOnderdelenForItem($ID)
		{
			$databaseConn = $this->connect();
			$sql = "SELECT examenonderdeel.naam FROM examenonderdeel, P_E
					WHERE P_E.examenonderdeelId = examenonderdeel.Id AND P_E.portfolioItemId = ?";
					
			$state = $databaseConn->prepare($sql);				
			$state->bind_param("i", $ID);
			$state->execute();
			$result = $state->get_result();
			
			$onderdelen = array();
			while($row = $result->fetch_assoc())
			{
				$onderdeel = ($row['naam']);
				$onderdelen[] = $onderdeel;
			}
			$state->close();
			$this->closeConnection();
			return $onderdelen;
		}
		
		/*Hier worden alle reacties voor een specifiek portfolio-item opgehaald*/
		function GetAllReactiesForItem($ID)
		{		
			$databaseConn = $this->connect();
			$sql = "SELECT reactie.id, user.username, reactie.content, reactie.datum 
					FROM reactie, user WHERE user.ID = reactie.auteurId AND reactie.portfolioItemId = ?";
					
			$state = $databaseConn->prepare($sql);				
			$state->bind_param("i", $ID);
			$state->execute();
			$result = $state->get_result();
			
			$reacties = array();
			while($row = $result->fetch_assoc())
			{
				$userDAO = new userDAO();
				$user = $userDAO->GetUser($row["username"]);
				$reactie = new ReactieModel($row['id'], NULL, NULL, $user, $row['content'], $row['datum']);
				$reacties[] = $reactie;
			}
			$state->close();
			$this->closeConnection();
			return $reacties;
		}
		
		/*Hier worden alle afbeeldingen van een portfolio-item opgehaald*/
		function GetAfbeeldingenForItem($ID)
		{
			$databaseConn = $this->connect();
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
	
		/*Hier worden alle examenonderdelen waar een portfolio-item voor bestaat uit de database opgehaald.*/
		function GetExamenOnderdelen()
		{
		$sql = "SELECT DISTINCT examenonderdeel.id, examenonderdeel.naam FROM examenonderdeel, P_E, portfolioItem 
				WHERE portfolioItem.ID = P_E.portfolioitemId AND examenonderdeel.id = P_E.examenonderdeelId";
		
		return $this->executeOnderdeel($sql);
		}
		
				
		function executeOnderdeel($sql)
		{
			$databaseConn = $this->connect();
			$result = $databaseConn->query($sql);
			if($this->checkResult($result) == false)
			{
				echo "Examenonderdeel filters konden niet worden opgehaald";
				exit;
			}
			
			$onderdelen = array();
			
			while($row = $result->fetch_assoc())
			{
				$onderdeel = new examenonderdeel($row['id'], $row['naam']);
				
				$onderdelen[] = $onderdeel;
			}
			
			$databaseConn->Close();
			
			return $onderdelen;		
		}
		
	}
?>	
			
	
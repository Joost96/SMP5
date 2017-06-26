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
				$portfolioItem = new portfolioItem($row["ID"], $row["titel"], $row["username"], $row["beschrijving"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"], $row['technieken'], NULL);									
				
				$items[] = $portfolioItem;
			}
			
			$this->closeConnection();	
			return $items;			
		}
		
		/**/
		/**/
		/**/
		/* Hier haal ik de juiste items op voor de doorgegeven filters, er wordt een methode aangeroepen die de juiste string samenstelt die in de query gezet kan worden*/
		function GetItemsForFilter($onderdeelfilter, $jaarFilters)
		{		
			$filters = '';
			$filters = $this->createFilterString($onderdeelfilter, $jaarFilters);
			
			$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel_nl as titel, portfolioItem.beschrijving_nl as beschrijving, 
					portfolioItem.leerjaar, portfolioItem.datum, portfolioItem.technieken, portfolioItem.youtubeLink, afbeelding.afbeeldinglink, user.username 
					FROM portfolioItem, afbeelding, portfolioAfbeelding, examenonderdeel, user, P_E 
					WHERE portfolioItem.auteur_ID = user.ID AND P_E.portfolioitemId = portfolioItem.ID 
					AND P_E.examenonderdeelId = examenonderdeel.id AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID 
					AND portfolioAfbeelding.afbeelding_id = afbeelding.ID 
					AND ($filters)
					GROUP BY portfolioItem.ID					
					ORDER BY portfolioItem.datum DESC";
					
			return $this->executeItems($sql);
		}
				
		/*Hier worden alle items uit de database opgehaald*/
		function GetAllItems()
		{
		$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel_nl as titel, portfolioItem.beschrijving_nl as beschrijving, 
				portfolioItem.leerjaar, portfolioItem.datum, portfolioItem.technieken, portfolioItem.youtubeLink, afbeelding.afbeeldinglink, user.username 
				FROM portfolioItem, afbeelding, portfolioAfbeelding, examenonderdeel, user, P_E 
				WHERE portfolioItem.auteur_ID = user.ID AND P_E.portfolioitemId = portfolioItem.ID 
				AND P_E.examenonderdeelId = examenonderdeel.id AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID 
				AND portfolioAfbeelding.afbeelding_id = afbeelding.ID 
				GROUP BY portfolioItem.ID
				ORDER BY portfolioItem.datum DESC";
		
		return $this->executeItems($sql);
		}
		
		/*Hier wordt een specifiek item opgehaald, om deze vervolgens op een detail pagina te tonen*/
		function GetItemForID($ID)
		{
			$sql = "SELECT DISTINCT portfolioItem.ID, portfolioItem.titel_nl as titel, portfolioItem.beschrijving_nl as beschrijving, 
					portfolioItem.leerjaar, portfolioItem.datum, portfolioItem.technieken, portfolioItem.youtubeLink, afbeelding.afbeeldinglink, user.username, portfolioItem.technieken 
					FROM portfolioItem, afbeelding, portfolioAfbeelding, examenonderdeel, user, P_E 
					WHERE portfolioItem.auteur_ID = user.ID AND P_E.portfolioitemId = portfolioItem.ID 
					AND P_E.examenonderdeelId = examenonderdeel.id AND portfolioAfbeelding.portfolioitem_ID = portfolioItem.ID 
					AND portfolioAfbeelding.afbeelding_id = afbeelding.ID 
					AND portfolioItem.ID = ?";

			$databaseConn = $this->connect();
			$state = $databaseConn->prepare($sql);
			$state->bind_param("i", $ID);
			$state->execute();			
			$result = $state->get_result();
			if(!$result)
			{
				echo "er komt geen result terug";
			}
			
			while($row = $result->fetch_assoc())
			{
				$portfolioItem = new portfolioItem($row["ID"], $row["titel"], $row["username"], $row["beschrijving"], $row["leerjaar"], $row["datum"], $row["afbeeldinglink"], $row['technieken'], $row['youtubeLink']);									
			}
			
			$state->close();
			$this->closeConnection();			
			return $portfolioItem;	
		}
		/*Hier worden alleen de examenonderelen opgehaald die bij een specifiek portfolio-item horen*/
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
			
			$userDAO = new userDAO();
			$reacties = array();
			
			while($row = $result->fetch_assoc())
			{
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
			$sql = "SELECT * FROM afbeelding, portfolioAfbeelding WHERE portfolioAfbeelding.afbeelding_id = afbeelding.ID
			AND portfolioAfbeelding.portfolioItem_ID = ?";
			
			$databaseConn = $this->connect();
			$state = $databaseConn->prepare($sql);
			$state->bind_param("i", $ID);
			$state->execute();
			$result = $state->get_result();
			
			$afbeeldingen = array();
			
			while($row = $result->fetch_assoc())
			{
				$portfolioAfbeelding = new portfolioAfbeelding($row['ID'], $row['portfolioitem_ID'], $row['afbeeldinglink'], $row['instagrampostlink'], $row['beschrijving']);		
				$afbeeldingen[] = $portfolioAfbeelding;
			}
			
			$state->close();
			$this->closeConnection();
			
			return $afbeeldingen;
		}
	
		/*Hier worden alle examenonderdelen waar een portfolio-item voor bestaat uit de database opgehaald.*/
		function GetExamenOnderdelen()
		{
			$sql = "SELECT DISTINCT examenonderdeel.id, examenonderdeel.naam FROM examenonderdeel, P_E, portfolioItem 
					WHERE portfolioItem.ID = P_E.portfolioitemId AND examenonderdeel.id = P_E.examenonderdeelId";
			
			return $this->executeOnderdeel($sql);
		}
		/*Hier worden alle examenonderdelen opgehaald, om deze in een lijst te kunnen tonen*/
		function GetALLExamenOnderdelen()
		{
			$sql = "SELECT DISTINCT * FROM examenonderdeel";
			
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
		
		/*Dit is de methode om een nieuw item aan de database toe te voegen*/
		function CreateNewItem($titelNL, $titelEN, $technieken, $jaar, $yt, $beschrijvingNL, $description, $user)
		{
			$sql = "INSERT INTO portfolioItem (titel_nl, beschrijving_nl, leerjaar, datum, auteur_id, titel_en, beschrijving_en, youtubeLink)
						VALUES ( ?, ?, ?, DATE_ADD(NOW(), INTERVAL 2 HOUR), ?, ?, ?, ?)";
						
			$databaseConn = $this->connect();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("ssiisss", $titelNL, $beschrijvingNL, $jaar, $user->id, $titelEN, $description, $yt)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$id = $stmt->insert_id;
			$stmt->close();
			$this-closeConnection();
			return $id;
		}
		
		/*Hier wordt in de koppeltabel een koppeling gemaakt voor de portfolioitems en de juiste examenonderdelen*/
		function koppelExamenonderdeel($portfolioID, $onderdeel)
		{
			$sql = "INSERT INTO P_E (portfolioitemId, examenonderdeelId)
						VALUES ( ?, ?)";
			
			$databaseConn = $this->connect();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("ii", $portfolioID, $onderdeel)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$stmt->close();
			$this-closeConnection();
	}
	}
?>	
			
	
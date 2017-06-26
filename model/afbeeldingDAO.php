<?php
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/afbeelding.php");
	class afbeeldingDAO
	{	
		var $dbObject;
		
		public function __construct() {
			$this->dbObject = new InformaticaBase();
		}
		function getConnection()
		{
			$this->dbObject->connect();
			
			$databaseConn = $this->dbObject->getConnection();
			return $databaseConn;
		}
		function closeConnection() {
			mysqli_close($this->dbObject->getConnection());
		}
		
		function GetAfbeelding($id)
		{	
			$sql = "SELECT * FROM afbeelding WHERE id = ?";
			$afbeelding = NULL;
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("i", $id)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc())
			{
				$afbeelding = new afbeelding($id , $row["afbeeldinglink"], $row["beschrijving"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $afbeelding;
		}
		function createAfbeelding($link,$beschrijving) {
			$sql = "INSERT INTO afbeelding (afbeeldinglink, beschrijving)
					VALUES ( ?, ?)";
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("ss", $link, $beschrijving)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$id = $stmt->insert_id;
			$stmt->close();
			$this->closeConnection();
			return $id;
		}
		
		function createPortfolioAfbeelding($portfolioID, $afbeeldingID, $foto)
		{
			$sql = "INSERT INTO portfolioAfbeelding (portfolioitem_ID, afbeelding_id, instagramlink)
						VALUES ( ?, ?)";
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("iis", $portfolioID, $afbeeldingID, $foto)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$stmt->close();
			$this->closeConnection();
		}
	}
?>	
			
	
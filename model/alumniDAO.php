<?php
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/alumni.php");
	include_once (dirname(__DIR__)."/model/userDAO.php");
	include_once (dirname(__DIR__)."/model/afbeeldingDAO.php");
	
	class alumniDAO
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
		
		
		function GetAlumni($id)
		{	
			$sql = "SELECT * FROM alumni WHERE id = ?";
			$alumni = NULL;
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
			$userDAO = new userDAO();
			$afbeeldingDAO = new afbeeldingDAO();
			if($row = $result->fetch_assoc())
			{
				$user = $userDAO->GetUserFromId($row["user"]);;
				$afbeelding = $afbeeldingDAO->GetAfbeelding($row["afbeelding"]);
				$alumni = new alumni($row["id"], $user, $row["functie"], $row["omschrijving"],
													$row["link"], $afbeelding);
			}
			$stmt->close();
			$this->closeConnection();
			return $alumni;
		}
		
		function GetAllAlumni()
		{	
			$sql = "SELECT * FROM alumni";
			$alumni = array();
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$result = $stmt->get_result();
			$userDAO = new userDAO();
			$afbeeldingDAO = new afbeeldingDAO();
			while($row = $result->fetch_assoc())
			{
				$user = $userDAO->GetUserFromId($row["user"]);
				$afbeelding = $afbeeldingDAO->GetAfbeelding($row["afbeelding"]);
				$alumni[] = new alumni($row["id"], $user, $row["functie"], $row["omschrijving"],
													$row["link"], $afbeelding);
			}
			$stmt->close();
			$this->closeConnection();
			return $alumni;
		}
		
		function CreateAlumni( $user, $functie, $omschrijving, $webLink, $afbeelding) {
			$sql = "INSERT INTO alumni (user, functie, omschrijving, link, afbeelding)
						VALUES ( ?, ?, ?, ?, ?)";
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("isssi", $user->id, $functie, $omschrijving, $webLink, $afbeelding)) {
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
			
	
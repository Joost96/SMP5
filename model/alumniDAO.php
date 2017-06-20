<?php
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/alumni.php");
	include_once (dirname(__DIR__)."/model/userDAO.php");
	include_once (dirname(__DIR__)."/model/user.php");
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
			mysqli_close($this->dbObject);
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
			if($row = $result->fetch_assoc())
			{
				$userDAO = new userDAO();
				$user = $userDAO->GetUserFromId($row["user"]);
				$alumni = new alumni($row["id"], $user, $row["functie"], $row["omschrijving"],
													$row["link"]);
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
			while($row = $result->fetch_assoc())
			{
				$userDAO = new userDAO();
				$user = $userDAO->GetUserFromId($row["user"]);
				$alumni[] = new alumni($row["id"], $user, $row["functie"], $row["omschrijving"],
													$row["link"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $alumni;
		}
		
		function CreateAlumni( $user, $functie, $omschrijving, $webLink) {
			$sql = "INSERT INTO alumni (user, lastName, studentId, link)
						VALUES ( ?, ?, ?, ?)";
			$user;
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("ssss", $user, $functie, $omschrijving, $webLink)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$stmt->close();
			$this->closeConnection();
			return getUser($username);
		}		
	}
?>	
			
	
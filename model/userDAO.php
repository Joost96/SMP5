<?php
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/user.php");
	class userDAO
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
		
		
		function GetUser($username)
		{	
			$sql = "SELECT * FROM user WHERE username = ?";
			$user = NULL;
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("s", $username)) {
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
				$user = new user($row['ID'], $row["username"], $row["firstName"], $row["lastName"], $row["studentId"],
													$row["email"], $row["password"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $user;
		}
		
		function GetUserFromId($id)
		{	
			$sql = "SELECT * FROM user WHERE id = ?";
			$user = NULL;
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
				$user = new user($row['ID'], $row["username"], $row["firstName"], $row["lastName"], $row["studentId"],
													$row["email"], $row["password"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $user;
		}
		
		function CreateUser($username, $firstName, $lastName, $studentId, $email, $password) {
			$sql = "INSERT INTO user (username, firstName, lastName, studentId, email, password)
						VALUES (?, ?, ?, ?, ?, ?)";
			$user;
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("ssssss", $username, $firstName, $lastName, $studentId, $email, $password)) {
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
			
	
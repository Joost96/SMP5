<?php
	include_once (dirname(__DIR__)."/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/user.php");
	class userDAO
	{		
		function connect()
		{
			$dbObject = new InformaticaBase();
			$dbObject-> connect();
			
			$databaseConn = $dbObject->getConnection();
			return $databaseConn;
		}
		
		
		function GetUser($username)
		{	
			$sql = "SELECT * FROM user WHERE username = ?";
			$user = NULL;
			$databaseConn = $this->connect();
			
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
				$user = new user($row["username"], $row["firstName"], $row["lastName"], $row["studentId"],
													$row["email"], $row["password"]);
			}
			$stmt->close();
			return $user;
		}
		function CreateUser($username, $firstName, $lastName, $studentId, $email, $password) {
			$sql = "INSERT INTO user (username, firstName, lastName, studentId, email, password)
						VALUES (?, ?, ?, ?, ?, ?)";
			$user;
			$databaseConn = $this->connect();
			
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
			return getUser($username);
		}		
	}
?>	
			
	
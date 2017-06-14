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
			$user;
			$databaseConn = $this->connect();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if (!$stmt->bind_param("s", $username)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}	
			
			$stmt->execute();
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc())
			{
				$user = new user($row["username"], $row["firstName"], $row["lastName"], $row["studentId"],
													$row["email"], $row["password"]);
			}
			$stmt->close();
			return $user;
		}
			
	}
?>	
			
	
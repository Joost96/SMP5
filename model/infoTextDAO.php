<?php
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/infoText.php");
	include_once (dirname(__DIR__)."/model/afbeeldingDAO.php");
	
	class infoTextDAO
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
		
		
		function GetInfoPage($title , $taal)
		{	
			$sql = "SELECT * FROM infoText WHERE page = ? AND taal = ?";
			$infoPage = array();;
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("ss", $title,$taal)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}	
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return;
			}
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc())
			{
				$afbeeldingDAO = new afbeeldingDAO();
				$afbeelding = $afbeeldingDAO->GetAfbeelding($row["afbeelding"]);
				$infoPage[] = new infoText($row["page"], $row["locatie"],$row["title"], $row["text"], $afbeelding,
													$row["taal"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $infoPage;
		}	
	}
?>	
			
	
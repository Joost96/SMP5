<?php
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/periode.php");
	include_once (dirname(__DIR__)."/model/vak.php");
	class curriculumDAO
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
		
		
		function GetAllPeriodes($taal)
		{	
			$sql = "SELECT * FROM periode WHERE taal = ?";
			$periodes = array();
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("s", $taal)) {
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
				$periodes[] = new periode($row["id"], $row["jaar"], $row["periode"], $row["naam"], $row["omschrijving"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $periodes;
		}
		
		function GetVakkenFromPeriodeId($periodeId)
		{	
			$sql = "SELECT vak.naam as naam,omschrijving,examenonderdeel.naam as
			onderwerp FROM `vak` INNER JOIN `examenonderdeel` ON vak.onderwerp = examenonderdeel.id 
			WHERE periode = ?";
			$vakken = array();
			$databaseConn = $this->getConnection();
			
			if (!($stmt = $databaseConn->prepare($sql))) {
				echo "Prepare failed: (" . $databaseConn->errno . ") " . $databaseConn->error;
				return;
			}
			if (!$stmt->bind_param("i", $periodeId)) {
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
				$vakken[] = new vak($row["naam"], $row["omschrijving"], $row["onderwerp"]);
			}
			$stmt->close();
			$this->closeConnection();
			return $vakken;
		}	
	}
?>	
			
	
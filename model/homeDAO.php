<?php	
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/homeAfbeelding.php");
	class homeDAO
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
		
		function GetAfbeeldingen()
		{
			$sql = "SELECT * FROM homeAfbeelding";
			$databaseConn = $this->getConnection();
			
			$state = $databaseConn->prepare($sql);				
			$state->execute();
			$result = $state->get_result();
			
			$afbeeldingen = array();
			while($row = $result->fetch_assoc())
			{
				$afbeelding = new homeAfbeelding($row['ID'], $row['afbeeldingLink'], $row['titel'], $row['ondertitel'], $row['paginalink']);
				$afbeeldingen[] = $afbeelding;
			}
			$state->close();
			$this->closeConnection();
			return $afbeeldingen;
		}
	}
?>
			
			
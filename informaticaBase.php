<?php
	class InformaticaBase
	{
		private $serverName = "smgroep5.infhaarlem.nl";
		private $userName = "smgroep5_root";
		private $passWord = "Rootww1";
		private $database = "testDB";
		private $connection;
		
		public function connect()
		{
			$conn = new mysqli($this->serverName, $this->userName, $this->passWord, $this->database:
			
				if ($conn->connect_error) 
				{
					die($GLOBALS['DebugInfo'] .= "Connection failed: " . $conn->connect_error);
				} 
				
			echo "Connectie is gelukt!!!";
			$this->connection = $conn;     
		}

		public function getConnection() 
		{ 
			return $this->connection; 
		}
    }
?>

<?php
	class InformaticaBase
	{
		private $serverName = "smgroep5.infhaarlem.nl";
		private $userName = "smgroep5_root";
		private $passWord = "Rootww1";
		private $database = "smgroep5_informaticahaarlem";
		private $connection;
		
		public function connect()
		{
			$conn = new mysqli($this->serverName, $this->userName, $this->passWord, $this->database);
			
				if ($conn->connect_error) 
				{
					die($GLOBALS['DebugInfo'] .= "Connection failed: " . $conn->connect_error);
				} 			
			$this->connection = $conn;     
		}

		public function getConnection() 
		{ 
			return $this->connection; 
		}
		public function disconnect() {
			mysqli_close($this->connection);
		}
    }
?>

<?php
	class localBase
	{
		private $serverName = "localhost";
		private $userName = "root";
		private $passWord = "";
		private $database = "testDB";
		private $connection;
		
		public function connect()
		{
			$conn = new mysqli($this->serverName, $this->userName, $this->passWord, $this->database);
			
				if ($conn->connect_error) 
				{
					die($GLOBALS['DebugInfo'] .= "Connection failed: " . $conn->connect_error);
				} 
				echo "Connectie met localBase is gelukt!!!";
			$this->connection = $conn;     
		}

		public function getConnection() 
		{ 
			return $this->connection; 
		}
    }
?>

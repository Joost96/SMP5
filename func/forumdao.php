<?php
	$con = new mysqli('smgroep5.infhaarlem.nl', 'smgroep5_root', 'Rootww1', 'smgroep5_informaticahaarlem');
	
	function getAllPosts(){
		global $con;
		return $con->query("
			SELECT *
			FROM post
			");
	}
	
	function getPostbyOnderwerp($onderwerp_id){
		global $con;
		
		$query = "SELECT * FROM post WHERE onderwerpID = ?";
		
		if (!($statement = $con->prepare($query))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		if (!$statement->bind_param("s", $onderwerp_id)) {
			echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
		}
		
		if (!$statement->execute()){
			echo "Excecute failed: ({$statement->errno}) {$statement->error}";
		}
		
		return $statement->get_result();
	}
	
	function getPostbyid($post_id){
		global $con;
		
		$query = "select * from post where ID = ?";
		
		if (!($statement = $con->prepare($query))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		if (!$statement->bind_param("i", $post_id)) {
			echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
		}
		
		if (!$statement->execute()){
			echo "Excecute failed: ({$statement->errno}) {$statement->error}";
		}
		
		return $statement->get_result();
	}
	
	function getAllReacties($post_id){
		global $con;
		
		$query = "select * from reactie where postID = ?";
		
		if (!($statement = $con->prepare($query))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		if (!$statement->bind_param("i", $post_id)) {
			echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
		}
		
		if (!$statement->execute()){
			echo "Excecute failed: ({$statement->errno}) {$statement->error}";
		}
		
		return $statement->get_result();
	}
	
	function postReactie($post_id, $reactie_content){
		global $con;
		
		$query = "INSERT INTO `reactie` (`ID`, `postID`, `content`) VALUES (NULL, ?, ?)";
		
		if (!($statement = $con->prepare($query))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		if (!$statement->bind_param("is", $post_id, $reactie_content)) {
			echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
		}
		
		if (!$statement->execute()){
			echo "Excecute failed: ({$statement->errno}) {$statement->error}";
		}
		
		return $statement->get_result();
	}
	
	function getAllOnderwerpen(){
		global $con;
		return $con->query("
			select *
			from onderwerp
			");
	}
	
	function getOnderwerpbyid($onderwerp_id){
		global $con;
		$query = "select * from onderwerp where ID = ?";
		
		if (!($statement = $con->prepare($query))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		if (!$statement->bind_param("i", $onderwerp_id)) {
			echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
		}
		
		if (!$statement->execute()){
			echo "Excecute failed: ({$statement->errno}) {$statement->error}";
		}
		
		return $statement->get_result();
	}
	
	function closeConnection(){
		global $con;
		$con->close();
	}
?>
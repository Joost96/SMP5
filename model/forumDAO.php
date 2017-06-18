<?php
	include_once (dirname(__DIR__)."/model/OnderwerpModel.php");
	include_once (dirname(__DIR__)."/model/PostModel.php");
	include_once (dirname(__DIR__)."/model/ReactieModel.php");

	class forumDAO{
		private function connect(){
			return new mysqli('smgroep5.infhaarlem.nl', 'smgroep5_root', 'Rootww1', 'smgroep5_informaticahaarlem');
		}
		
		function getPostbyOnderwerp($onderwerp_id){
			$con = $this->connect();
			
			$query = "SELECT * FROM post WHERE onderwerpID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $onderwerp_id);
			
			$posts[] = null;
			
			while ($row = $result->fetch_assoc()){
				array_push($posts, new PostModel($row['ID'], $row['onderwerpID'], $row['titel'], $row['content']));
			}
			
			$con->close();
			
			return $posts;
		}
		
		function getPostbyid($post_id){
			$con = $this->connect();
			
			$query = "select * from post where ID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $post_id);
			
			$post = null;
			
			if ($row = $result->fetch_assoc()){
				array_push($post, new PostModel($row['ID'], $row['onderwerpID'], $row['titel'], $row['content']));
			}
			
			$con->close();
			
			return $post;
		}
		
		function getAllReacties($post_id){
			$con = $this->connect();
			
			$query = "select * from reactie where postID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $post_id);
			
			$reacties[] = null;
			
			while($row = $result->fetch_assoc()){
				array_push($reacties, new ReactieModel($row['ID'], $row['postID'], $row['content']));
			}
			
			$con->close();
			
			return $reacties;
		}
		
		function postReactie($post_id, $reactie_content){
			$con = $this->connect();
			
			$query = "INSERT INTO `reactie` (`ID`, `postID`, `content`) VALUES (NULL, ?, ?)";
			
			$result = $this->executeQuery2($con, $query, "is", $post_id, $reactie_content);
			
			$con->close();
			
			return $result;
		}
		
		function getAllOnderwerpen(){
			$con = $this->connect();
			$result = $con->query("select * from onderwerp");
			
			if ($result == null){return;}
			
			$onderwerpen[] = null;
			
			while($row = $result->fetch_assoc()){
				array_push($onderwerpen, new OnderwerpModel($row['ID'], $row['naam']));
			}
			
			$con->close();
			
			return $onderwerpen;
		}
		
		function getOnderwerpbyid($onderwerp_id){
			$con = $this->connect();
			$query = "select * from onderwerp where ID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $onderwerp_id);
			
			$onderwerp = null;
			if ($row = $result->fetch_assoc()){
				array_push($onderwerp, new OnderwerpModel($row['ID'], $row['naam']));
			}
			
			$con->close();

			return $onderwerp;
		}
		
		private function executeQuery1($con, $query, $type, $param){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				$con->close();
				return null;
			}
			
			if (!$statement->bind_param($type, $param)) {
				echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
				$con->close();
				return null;
			}
			
			if (!$statement->execute()){
				echo "Excecute failed: ({$statement->errno}) {$statement->error}";
				$con->close();
				return null;
			}
			
			return $statement->get_result();
		}
		
		private function executeQuery2($con, $query, $type, $param1, $param2){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				$con->close();
				return;
			}
			
			if (!$statement->bind_param($type, $param1, $param2)) {
				echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
				$con->close();
				return;
			}
			
			if (!$statement->execute()){
				echo "Excecute failed: ({$statement->errno}) {$statement->error}";
				$con->close();
				return;
			}
			
			return $statement->get_result();
		}
	}
?>
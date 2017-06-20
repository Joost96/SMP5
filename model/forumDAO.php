<?php
	include_once (dirname(__DIR__)."/model/ForumOnderwerpModel.php");
	include_once (dirname(__DIR__)."/model/ForumPostModel.php");
	include_once (dirname(__DIR__)."/model/ReactieModel.php");
	include_once (dirname(__DIR__)."/model/informaticaBase.php");

	class forumDAO{
		private function connect(){
			$obj = new informaticaBase();
			$obj->connect();
			
			$con = $obj->getConnection();
			
			return $con;
		}
		
		function getPostbyOnderwerp($onderwerp_id){
			$con = $this->connect();
			
			$query = "SELECT * FROM post WHERE onderwerpID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $onderwerp_id);
			
			$posts = array();
			
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
			
			$post = array();
			
			if ($row = $result->fetch_assoc()){
				array_push($post, new PostModel($row['ID'], $row['onderwerpID'], $row['titel'], $row['content']));
			}
			
			$con->close();
			
			return $post[0];
		}
		
		function plaatsPost($post){
			$con = $this->connect();
			
			$query = "INSERT INTO `post` (`ID`, `titel`, `content`, `onderwerpID`) VALUES (NULL, ?, ?, ?)";
			
			$result = executeQuery3($con, $query, "ssi", $post->id, $post->titel, $post->onderwerpId);
			
			$con->close();
			
			return $result;
		}
		
		function getAllReacties($post_id){
			$con = $this->connect();
			
			$query = "select * from reactie where postID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $post_id);
			
			$reacties = array();
			
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
			
			if ($result == null){$con->close(); return;}
			
			$onderwerpen = array();
			
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
			
			$onderwerp = array();
			
			if ($row = $result->fetch_assoc()){
				array_push($onderwerp, new OnderwerpModel($row['ID'], $row['naam']));
			}
			
			$con->close();

			return $onderwerp[0];
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
		
		private function executeQuery3($con, $query, $type, $param1, $param2, $param3){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				$con->close();
				return;
			}
			
			if (!$statement->bind_param($type, $param1, $param2, $param3)) {
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
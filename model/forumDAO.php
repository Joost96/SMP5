<?php
	include_once (dirname(__DIR__)."/model/ForumOnderwerpModel.php");
	include_once (dirname(__DIR__)."/model/ForumPostModel.php");
	include_once (dirname(__DIR__)."/model/ReactieModel.php");
	include_once (dirname(__DIR__)."/informaticaBase.php");

	class forumDAO{
		private $obj;
		private function connect(){
			$this->obj = new informaticaBase();
			$this->obj->connect();
			
			$con = $this->obj->getConnection();
			
			return $con;
		}
		
		private function close(){
			$this->obj->disconnect();
		}
		
		function getPostbyOnderwerp($onderwerp_id){
			$con = $this->connect();
			
			$query = "SELECT * FROM post WHERE onderwerpID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $onderwerp_id);
			
			$posts = array();
			
			while ($row = $result->fetch_assoc()){
				array_push($posts, new ForumPostModel($row['ID'], $row['onderwerpID'], $row['titel'], $row['content']));
			}
			
			$this->close();
			
			return $posts;
		}
		
		function getPostbyid($post_id){
			$con = $this->connect();
			
			$query = "select * from post where ID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $post_id);
			
			$post = array();
			
			if ($row = $result->fetch_assoc()){
				array_push($post, new ForumPostModel($row['ID'], $row['onderwerpID'], $row['titel'], $row['content']));
			}
			
			$this->close();
			
			return $post[0];
		}
		
		function plaatsPost($post){
			$con = $this->connect();
			
			$query = "INSERT INTO `post` (`ID`, `titel`, `content`, `onderwerpID`) VALUES (NULL, ?, ?, ?)";
			
			$result = $this->executeQuery3($con, $query, "ssi", $post->titel, $post->content, $post->onderwerpId);
			
			$this->close();
			
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
			
			$this->close();
			
			return $reacties;
		}
		
		function plaatsReactie($post_id, $reactie_content){
			$con = $this->connect();
			
			$query = "INSERT INTO `reactie` (`ID`, `postID`, `content`) VALUES (NULL, ?, ?)";
			
			$result = $this->executeQuery2($con, $query, "is", $post_id, $reactie_content);
			
			$this->close();
			
			return $result;
		}
		
		function getAllOnderwerpen(){
			$con = $this->connect();
			$result = $con->query("select * from onderwerp");
			
			if ($result == null){$con->close(); return;}
			
			$onderwerpen = array();
			
			while($row = $result->fetch_assoc()){
				array_push($onderwerpen, new ForumOnderwerpModel($row['ID'], $row['naam']));
			}
			
			$this->close();
			
			return $onderwerpen;
		}
		
		function getOnderwerpbyid($onderwerp_id){
			$con = $this->connect();
			$query = "select * from onderwerp where ID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $onderwerp_id);
			
			$onderwerp = array();
			
			if ($row = $result->fetch_assoc()){
				array_push($onderwerp, new ForumOnderwerpModel($row['ID'], $row['naam']));
			}
			
			$this->close();

			return $onderwerp[0];
		}
		
		private function executeQuery1($con, $query, $type, $param){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				return null;
			}
			
			if (!$statement->bind_param($type, $param)) {
				echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
				return null;
			}
			
			if (!$statement->execute()){
				echo "Excecute failed: ({$statement->errno}) {$statement->error}";
				return null;
			}
			
			return $statement->get_result();
		}
		
		private function executeQuery2($con, $query, $type, $param1, $param2){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				return null;
			}
			
			if (!$statement->bind_param($type, $param1, $param2)) {
				echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
				return null;
			}
			
			if (!$statement->execute()){
				echo "Excecute failed: ({$statement->errno}) {$statement->error}";
				return null;
			}
			
			return $statement->get_result();
		}
		
		private function executeQuery3($con, $query, $type, $param1, $param2, $param3){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				return null;
			}
			
			if (!$statement->bind_param($type, $param1, $param2, $param3)) {
				echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
				return null;
			}
			
			if (!$statement->execute()){
				echo "Excecute failed: ({$statement->errno}) {$statement->error}";
				return null;
			}
			
			return $statement->get_result();
		}
	}
?>
<?php
	include_once (dirname(__DIR__)."/model/ForumOnderwerpModel.php");
	include_once (dirname(__DIR__)."/model/ForumPostModel.php");
	include_once (dirname(__DIR__)."/model/ReactieModel.php");
	include_once (dirname(__DIR__)."/model/InformaticaBase.php");
	include_once (dirname(__DIR__)."/model/userDAO.php");
	include_once (dirname(__DIR__)."/model/user.php");

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
			
			$userdao = new userDAO();
			$query = "SELECT * FROM post WHERE onderwerpID = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $onderwerp_id);
			
			$posts = array();
			
			while ($row = $result->fetch_assoc()){
				$user = $userdao->GetUserFromId($row['auteurId']);
				$aantalReacties = $this->executeQuery1($con, "SELECT COUNT(id) FROM `reactie` WHERE postId = ?", "i", $row['ID'])->fetch_assoc()['COUNT(id)'];
				array_push($posts, new ForumPostModel($row['ID'], $row['onderwerpID'], $row['titel'], $row['content'], $user, $row['datum'], $aantalReacties));
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
				array_push($post, new ForumPostModel($row['ID'], $this->getOnderwerpbyid($row['onderwerpID']), 
					$row['titel'], $row['content'], $row['auteurId'], $row['datum'], 0));
			}
			
			$this->close();
			
			return $post[0];
		}
		
		function plaatsPost($post){
			$con = $this->connect();
			
			$datum = date('Y-m-d H:i:s');
			$query = "INSERT INTO `post` (`titel`, `content`, `onderwerpID`, `auteurId`, `datum`) 
				VALUES (?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL 2 HOUR))";
			
			$result = $this->executeQuery4($con, $query, "ssii", $post->titel, 
				$post->content, $post->onderwerp, $post->user->id);
			
			$this->close();
			
			return $result;
		}
		
		function getAllReacties($post_id){
			$con = $this->connect();
			
			$query = "select * from reactie where postId = ? ORDER BY `datum` desc";
			
			$result = $this->executeQuery1($con, $query, "i", $post_id);
			
			$reacties = array();
			
			while($row = $result->fetch_assoc()){
				array_push($reacties, new ReactieModel($row['id'], $row['postId'], 
					$row['portfolioItemId'], $row['auteurId'], $row['content'], $row['datum']));
			}
			
			$this->close();
			
			$reacties = $this->getUsersForReacties($reacties);
			
			return $reacties;
		}
		
		private function getUsersForReacties($reacties){
			$userdao = new userDAO();
			
			$newReacties = array();
			
			foreach ($reacties as $reactie){
				$reactie->user = $userdao->getUserFromId($reactie->user);
				array_push($newReacties, $reactie);
			}
			
			return $newReacties;
		}
		
		function plaatsReactie($reactie){
			$con = $this->connect();
			
			$query = "INSERT INTO `reactie` (`postId`, `auteurId`, `content`, `datum`) 
				VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 2 HOUR))";
			
			$result = $this->executeQuery3($con, $query, "iss", 
				$reactie->postId, $reactie->user->id, $reactie->content);
			
			$this->close();
			
			return $result;
		}
		
		function plaatsPortReactie($reactie)
		{
			$con = $this->connect();
			
			$query = "INSERT INTO `reactie` (`portfolioItemId`, `auteurId`, `content`, `datum`) 
				VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 2 HOUR))";
			
			$result = $this->executeQuery3($con, $query, "iss", 
				$reactie->portfolioId, $reactie->user->id, $reactie->content);
			
			$this->close();
			
			return $result;
		}
		
		function getAllOnderwerpen(){
			$con = $this->connect();
			$result = $con->query("select * from onderwerp");
			
			if ($result == null){$con->close(); return;}
			
			$onderwerpen = array();
			
			while($row = $result->fetch_assoc()){
				$aantalPosts = $this->executeQuery1($con, "SELECT COUNT(ID) FROM `post` WHERE onderwerpID = ?", "i", $row['ID'])->fetch_assoc()['COUNT(ID)'];
				array_push($onderwerpen, new ForumOnderwerpModel($row['ID'], $row['naam'], $aantalPosts));
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
				array_push($onderwerp, new ForumOnderwerpModel($row['ID'], $row['naam'], 0));
			}
			
			$this->close();

			return $onderwerp[0];
		}
		
		function deletePost($id){
			$con = $this->connect();
			$query = "DELETE FROM `post` WHERE `post`.`ID` = ?";
			
			$result = $this->executeQuery1($con, $query, "i", $id);
			
			$this->close();
			
			return;
		}
		
		function deleteReactie($id){
			$con = $this->connect();
			$query = "DELETE FROM `reactie` WHERE `reactie`.`id` = ?";
			
			$this->executeQuery1($con, $query, "i", $id);
			
			$this->close();
			
			return;
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
		
		private function executeQuery4($con, $query, $type, $param1, $param2, $param3, $param4){
			if (!($statement = $con->prepare($query))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				return null;
			}
			
			if (!$statement->bind_param($type, $param1, $param2, $param3, $param4)) {
				echo "Binding parameters failed: (" . $statement->errno . ") " . $statement->error;
				return null;
			}
			
			if (!$statement->execute()){
				echo "Excecute failed: ({$statement->errno}) {$statement->error}";
				return null;
			}
			
			return $statement->get_result();
		}

		/*Code van Josh voor homepagina*/
		
		public function GetLatestPosts()
		{
			$con = $this->connect();
			$sql = "SELECT post.ID, post.titel, post.content, onderwerp.naam, post.datum, user.username 
					FROM post, onderwerp, user 
					WHERE post.auteurId = user.ID AND onderwerp.ID = post.onderwerpID
					ORDER BY post.datum DESC LIMIT 5";
			
			$result = $con->query($sql);
			if ($result == null)
			{ 
				$con->close(); 
				return;
			}
			
			$latestPosts = array();
			
			while($row = $result->fetch_assoc())
			{
				$post = new ForumPostModel($row['ID'], $row['naam'], $row['titel'], $row['content'], $row['username'], $row['datum'], NULL);
				$latestPosts[] = $post;
			}
			
			$this->close();
			
			return $latestPosts;
		}			
	}
?>
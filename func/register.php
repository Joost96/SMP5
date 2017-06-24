<?php
	session_start();

	$username = "";
	$firstName= "";
	$lastName= "";
	$studentId= "";
	$email= "";
	$password= "";

	if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			include_once ("../model/userDAO.php");
			include_once ("../model/user.php");
			$userDAO = new userDAO();
			
			$username = trim_data($_POST["username"]);
			$firstName = trim_data($_POST["firstName"]);
			$lastName = trim_data($_POST["lastName"]);
			$studentId = trim_data($_POST["studentId"]);
			$email = trim_data($_POST["email"]);
			$password = trim_data($_POST["password"]);
			$username = strtolower($username);
			$passwordHash = password_hash($password, PASSWORD_BCRYPT);
			
			$excistingUser = $userDAO->GetUser($username);
			if(isset($excistingUser) && !empty($excistingUser)) {
				echo 'username taken';
			} else {
				$user = $userDAO->CreateUser($username, $firstName, $lastName, $studentId, $email, $passwordHash);
				if (isset($user) && !empty($user)) {
					echo 'valid register';
					$_SESSION["user"] = serialize($user);
				} else {
					echo 'Invalid';
				}
			}
		}
	}

	function trim_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
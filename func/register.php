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
		  

			$passwordHash = password_hash($password, PASSWORD_BCRYPT);
			$user = $userDAO->GetUser($username);
			if (password_verify($password, $user->password)) {
				echo 'valid register';
				$_SESSION["user"] = $user;
			} else {
				echo 'Invalid';
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
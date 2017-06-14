<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();

	$username = "";
	$password = "";

	if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			include_once ("../model/userDAO.php");
			include_once ("../model/user.php");
			$userDAO = new userDAO();
			
			$username = trim_data($_POST["username"]);
			$password = trim_data($_POST["password"]);
		  

			$passwordHash = password_hash($password, PASSWORD_BCRYPT);
			$user = $userDAO->GetUser($username);
			if (password_verify($password, $user->password)) {
				echo 'login';
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
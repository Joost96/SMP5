<?php
	session_start();
	header('Content-Type: application/json');
	$username = "";
	$password = "";

	if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			include_once ("../model/userDAO.php");
			include_once ("../model/user.php");
			$userDAO = new userDAO();
			
			$username = trim_data($_POST["username"]);
			$password = trim_data($_POST["password"]);
			$username = strtolower($username);
			
			$status = "";
			
			$user = $userDAO->GetUser($username);
			if(isset($user) && !empty($user)) {
				if (password_verify($password, $user->password)) {
					$status = 'valid login';
					$_SESSION["user"] = serialize($user);
				} else {
					$status = 'Invalid';
				}
			} else {
				$status = 'Invalid';
			}
			if($status == "valid login") {
				echo json_encode(array('status' => $status,'user'=> $user));
			} else {
				echo json_encode(array('status' => $status));
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
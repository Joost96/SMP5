<?php
	class user {
		var $username;
		var $firstName;
		var $lastName;
		var $studentId;
		var $email;
		var $password;

		public function __construct($username, $firstName, $lastName, $studentId, $email, $password)
		{
			$this->username = $username;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->studentId = $studentId;
			$this->email = $email;
			$this->password = $password;
		}
		
		public function getFullName()
		{
			return $this->$firstname + $this->$lastName;
		}
	}
?>
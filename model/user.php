<?php
	class user {
		var $id;
		var $username;
		var $firstName;
		var $lastName;
		var $studentId;
		var $email;
		var $password;

		public function __construct($id, $username, $firstName, $lastName, $studentId, $email, $password)
		{
			$this->id = $id;
			$this->username = $username;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->studentId = $studentId;
			$this->email = $email;
			$this->password = $password;
		}
		
		public function getFullName()
		{
			return $this->firstName." ".$this->lastName;
		}
	}
?>
<?php
	class user {
		var $id;
		var $user;
		var $functie;
		var $omschrijving;
		var $webLink;

		public function __construct($id, $user, $functie, $omschrijving, $webLink)
		{
			$this->id = $id;
			$this->user = $user;
			$this->functie = $functie;
			$this->omschrijving = $omschrijving;
			$this->webLink = $webLink;
		}
		
	}
?>
<?php
	class alumni {
		var $id;
		var $user;
		var $functie;
		var $omschrijving;
		var $webLink;
		var $afbeelding;

		public function __construct($id, $user, $functie, $omschrijving, $webLink, $afbeelding)
		{
			$this->id = $id;
			$this->user = $user;
			$this->functie = $functie;
			$this->omschrijving = $omschrijving;
			$this->webLink = $webLink;
			$this->afbeelding = $afbeelding;
		}
		
	}
?>
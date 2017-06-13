<?php
	class portfolioItem {
	var $ID;
	var $titel;
	var $auteur;
	var $beschrijving;
	var $afbeelding;
	var $datum;
	var $jaar;

	public function __construct($ID, $titel, $auteur, $beschrijving, $afbeelding, $datum, $jaar)
	{
		$this->ID = $ID;
		$this->titel = $titel;
		$this->auteur = $auteur;
		$this->beschrijving = $beschrijving;
		$this->afbeelding = $afbeelding;
		$this->datum = $datum;
		$this->jaar = $jaar;
	}
	
	public function getTitel()
	{
		return $this->titel;
	}
	}
?>
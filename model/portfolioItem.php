<?php
	class portfolioItem 
	{
		var $ID;
		var $titel;
		var $beschrijving;
		var $jaar;
		var $datum;		
		var $auteur;
		var $thumbnail;
		var $technieken;
		var $youtubelink;

		public function __construct($ID, $titel, $auteur, $beschrijving, $jaar, $datum, $thumbnail, $technieken, $youtubelink)
		{
			$this->ID = $ID;
			$this->titel = $titel;
			$this->auteur = $auteur;
			$this->beschrijving = $beschrijving;
			$this->datum = $datum;
			$this->jaar = $jaar;
			$this->thumbnail = $thumbnail;
			$this->technieken = $technieken;
			$this->youtubelink = $youtubelink;
		}
	}
?>
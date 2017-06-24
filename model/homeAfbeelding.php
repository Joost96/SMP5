<?php
	class homeAfbeelding {
		var $ID;
		var $afbeeldingLink;
		var $titel;
		var $ondertitel;
		var $paginalink;
		
		public function __construct($ID, $afbeeldingLink, $titel, $ondertitel, $paginalink)
		{
			$this->ID = $ID;
			$this->afbeeldingLink = $afbeeldingLink;
			$this->titel = $titel;
			$this->ondertitel = $ondertitel;
			$this->paginalink = $paginalink;
		}
	}
?>
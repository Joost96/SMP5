<?php
	class afbeelding {
		var $afbeeldinglink;
		var $beschrijving;

		public function __construct($afbeeldinglink, $beschrijving)
		{
			$this->afbeeldinglink = $afbeeldinglink;
			$this->beschrijving = $beschrijving;
		}
	}
?>
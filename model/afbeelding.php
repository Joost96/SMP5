<?php
	class afbeelding {
		var $id;
		var $afbeeldinglink;
		var $beschrijving;

		public function __construct($id, $afbeeldinglink, $beschrijving)
		{
			$this->id = $id;
			$this->afbeeldinglink = $afbeeldinglink;
			$this->beschrijving = $beschrijving;
		}
	}
?>
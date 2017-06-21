<?php
	class periode {
		var $id;
		var $jaar;
		var $periode;
		var $naam;
		var $omschrijving;
		var $vakken;

		public function __construct($id, $jaar, $periode, $naam, $omschrijving)
		{
			$this->id = $id;
			$this->jaar = $jaar;
			$this->periode = $periode;
			$this->naam = $naam;
			$this->omschrijving = $omschrijving;
			$this->vakken = array();
		}
		public function addVak($vak) {
			$this->vakken[] = $vak;
		}
		
	}
?>
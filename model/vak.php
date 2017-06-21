<?php
	class vak {
		var $naam;
		var $omschrijving;
		var $onderwerp;
		var $periode;

		public function __construct($naam, $omschrijving, $onderwerp)
		{
			$this->naam = $naam;
			$this->omschrijving = $omschrijving;
			$this->onderwerp = $onderwerp;
		}
		public function setPeriode($periode) {
			$this->periode = $periode;
		}
		
	}
?>
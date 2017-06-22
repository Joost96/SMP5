<?php
	class examenonderdeel
	{
		var $ID;
		var $naam;

		public function __construct($ID, $naam)
		{
			$this->ID = $ID;
			$this->naam = $naam;	
		}
	}
?>
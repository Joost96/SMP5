<?php
	class OnderwerpModel{
		public $id;
		public $naam;
		
		public function __construct($id, $naam){
			$this->id = $id;
			$this->naam = $naam;
		}
	}
?>
<?php
	class ForumOnderwerpModel{
		public $id;
		public $naam;
		public $aantalPosts;
		
		public function __construct($id, $naam, $aantalPosts){
			$this->id = $id;
			$this->naam = $naam;
			$this->aantalPosts = $aantalPosts;
		}
	}
?>
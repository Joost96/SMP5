<?php
	class ForumPostModel{
		public $id;
		public $onderwerp;
		public $titel;
		public $content;
		public $user;
		public $datum;
		public $aantalReacties;
		
		public function __construct($id, $onderwerp, $titel, $content, $user, $datum, $aantalReacties){
			$this->id = $id;
			$this->onderwerp = $onderwerp;
			$this->titel = $titel;
			$this->content = $content;
			$this->user = $user;
			$this->datum = $datum;
			$this->aantalReacties = $aantalReacties;
		}
	}
?>
<?php
	class ForumPostModel{
		public $id;
		public $onderwerpId;
		public $titel;
		public $content;
		public $auteurId;
		public $datum;
		
		public function __construct($id, 
		$onderwerpId, $titel, $content, 
		$auteurId, 
		$datum){
			$this->id = $id;
			$this->onderwerpId = $onderwerpId;
			$this->titel = $titel;
			$this->content = $content;
			$this->auteurId = $auteurId;
			$this->datum = $datum;

		}
	}
?>
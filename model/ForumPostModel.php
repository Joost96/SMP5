<?php
	class PostModel {
		public $id;
		public $onderwerpId;
		public $titel;
		public $content;
		
		public function __construct($id, $onderwerpId, $titel, $content){
			$this->id = $id;
			$this->onderwerpId = $onderwerpId;
			$this->titel = $titel;
			$this->content = $content;
		}
	}
?>
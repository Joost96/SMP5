<?php
	class ForumPostModel{
		public $id;
		public $onderwerpId;
		public $titel;
		public $content;
		public $user;
		public $datum;
		
		public function __construct($id, $onderwerpId, $titel, $content, $user, $datum){
			$this->id = $id;
			$this->onderwerpId = $onderwerpId;
			$this->titel = $titel;
			$this->content = $content;
			$this->user = $user;
			$this->datum = $datum;
		}
	}
?>
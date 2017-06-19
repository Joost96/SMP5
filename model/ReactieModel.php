<?php
	class ReactieModel	{
		public $id;
		public $postId;
		public $content;
		
		public function __construct($id, $postId, $content){
			$this->id = $id;
			$this->postId = $postId;
			$this->content = $content;
		}
	}
?>
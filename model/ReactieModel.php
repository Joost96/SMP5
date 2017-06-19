<?php
	class ReactieModel	{
		public $id;
		public $postId;
		public $portfolioId;
		public $userId;
		public $content;
		
		public function __construct($id, $postId, $portfolioId, $userId, $content, $dateTime){
			$this->id = $id;
			$this->postId = $postId;
			$this->portfolioId = $portfolioId;
			$this->userId = $userId;
			$this->content = $content;
			$this->dateTime = $dateTime;
		}
	}
?>
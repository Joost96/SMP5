<?php
	class ReactieModel	{
		public $id;
		public $postId;
		public $portfolioId;
		public $user;
		public $content;
		public $dateTime;
		
		public function __construct($id, $postId, 
			$portfolioId, $user, $content, $dateTime)
		{
			$this->id = $id;
			$this->postId = $postId;
			$this->portfolioId = $portfolioId;
			$this->user = $user;
			$this->content = $content;
			$this->dateTime = $dateTime;
		}
	}
?>

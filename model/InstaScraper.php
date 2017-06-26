<?php 

	class InstagramScraper
	{
		protected $content;

		public function image($url){
			$this->content = @file_get_contents($url);
			preg_match('#<meta +property=\\"og:image\\" +content=\\"(http.+?\.jpg)\\"#', $this->content, $result);
			return $result[1];
		}
	}	
?>
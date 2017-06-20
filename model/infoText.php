<?php
	class infoText {
		var $page;
		var $locatie;
		var $title;
		var $text;
		var $afbeelding;
		var $taal;

		public function __construct($page, $locatie, $title, $text, $afbeelding, $taal)
		{
			$this->page = $page;
			$this->locatie = $locatie;
			$this->title = $title;
			$this->text = $text;
			$this->afbeelding = $afbeelding;
			$this->taal = $taal;
		}
		
	}
?>
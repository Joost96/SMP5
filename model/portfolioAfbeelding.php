<?php
	class portfolioAfbeelding
	{
		var $ID;
		var $portfolioItemID;
		var $afbeeldingLink;
		var $instagrampostLink;
		var $beschrijving;

		public function __construct($ID, $portfolioItemID, $afbeeldingLink, $instagrampostLink, $beschrijving)
		{
			$this->ID = $ID;
			$this->portfolioItemID = $portfolioItemID;
			$this->afbeeldingLink = $afbeeldingLink;
			$this->instagrampostLink = $instagrampostLink;
			$this->beschrijving = $beschrijving;
		}
	}
?>
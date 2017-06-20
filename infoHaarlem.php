<?php
    require 'func/page_header.php';	
    require 'func/page_footer.php';
	page_header("Over Haarlem","info");
	
	include_once ("model/infoTextDAO.php");
	include_once ("model/infoText.php");
	$infoTextDAO = new infoTextDAO();
	
	
	$infoPage = $infoTextDAO->GetInfoPage("haarlem",0);
	usort($infoPage, "cmp");
	var_dump($infoPage);
	
	
	function cmp($a, $b)
	{
		if ($a->locatie == $b->locatie) {
			return 0;
		}
		return ($a->locatie < $b->locatie	) ? -1 : 1;
	}
	
?>

<main>	
	<?php foreach($infoPage as $infoText): ?>
    
	<article class="textBlock col-12">
		<div class="col-6">
			<img src="<?php echo $infoText->afbeelding->afbeeldinglink ?>" alt="<?php echo $infoText->afbeelding->beschrijving ?>">
		</div>
		<div class="col-6">
			<h1><?php echo $infoText->title; ?></h1>
			<p><?php echo $infoText->text; ?></p>
		</div>
	</article>
	<?php endforeach; ?>

</main>

<?php
	
	page_footer();
?>
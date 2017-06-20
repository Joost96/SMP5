<?php
    require 'func/page_header.php';	
    require 'func/page_footer.php';
	page_header("Buiten school","info");
	
	include_once ("model/infoTextDAO.php");
	include_once ("model/infoText.php");
	$infoTextDAO = new infoTextDAO();
	
	
	$infoPage = $infoTextDAO->GetInfoPage("naSchool",$_SESSION["lang"]);
	usort($infoPage, "cmp");
	
	
	function cmp($a, $b)
	{
		if ($a->locatie == $b->locatie) {
			return 0;
		}
		return ($a->locatie < $b->locatie	) ? -1 : 1;
	}
	
?>

<main>	
	<?php $count = 0;
	foreach($infoPage as $infoText): ?>
    <?php if($infoText->locatie ==0) : ?>
		<div class="col-8 center">
			<p><?php echo $infoText->text; ?></p>
		</div>
	<?php else : ?>

		<article class="textBlock col-12">
			<?php if($count % 2 ==0) : ?>
			<div class="col-6">
				<img src="<?php echo $infoText->afbeelding->afbeeldinglink ?>" alt="<?php echo $infoText->afbeelding->beschrijving ?>">
			</div>
			<?php endif; ?>
			<div class="col-6">
				<h1><?php echo $infoText->title; ?></h1>
				<p><?php echo $infoText->text; ?></p>
			</div>
			<?php if($count % 2 !=0) : ?>
			<div class="col-6">
				<img src="<?php echo $infoText->afbeelding->afbeeldinglink ?>" alt="<?php echo $infoText->afbeelding->beschrijving ?>">
			</div>
			<?php endif; ?>
		</article>
	<?php endif;
	$count++;
	endforeach; ?>

</main>

<?php
	
	page_footer();
?>
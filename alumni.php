<?php
    require 'func/page_header.php';	
    require 'func/page_footer.php';
	page_header("Alumni","alumni");
	
	include_once ("model/alumniDAO.php");
	include_once ("model/alumni.php");
	$alumniDAO = new alumniDAO();
	
	
	$alumnus = $alumniDAO->GetAllAlumni();
	//var_dump($alumnus);
?>

<main>
	<a href="alumniNewPost.php"><input type='submit' id="new-post-btn" value='nieuw post'></a>
	
	<?php foreach($alumnus as $alumni): ?>
    
	<article class="alumni-post col-12">
		<div class="col-4">
			<img src="<?php echo $alumni->afbeelding->afbeeldinglink ?>" alt="<?php echo $alumni->afbeelding->beschrijving ?>">
		</div>
		<div class="col-8">
			<h1><?php echo $alumni->user->getFullName(); ?></h1>
			<h3><?php echo $alumni->functie; ?></h3>
			<p><?php echo $alumni->omschrijving; ?></p>
		</div>
		<a href="<?php echo $alumni->webLink; ?>"><input type='submit' class="linkedin-btn" value='Linkedin'></a>
	</article>
	<?php endforeach; ?>

</main>

<?php
	
	page_footer();
?>
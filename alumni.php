<?php
    require 'func/page_header.php';	
    require 'func/page_footer.php';
	page_header("Alumni");
	
	include_once ("model/alumniDAO.php");
	include_once ("model/alumni.php");
	$alumniDAO = new alumniDAO();
	
	
	$alumnus = $alumniDAO->GetAllAlumni();
	var_dump($alumnus);
?>

<main>
	<input type='button' value='nieuw post'>
	
	<?php foreach($alumnus as $alumni): ?>
    
	<article class="alumni-post col-8">
		<div class="col-6">
			<img src="https://media.licdn.com/mpr/mpr/shrinknp_400_400/AAEAAQAAAAAAAA0KAAAAJGZjYTRmZjkyLWFhN2YtNDQyYy1hZjkwLTBkMGUzZDUxZTcwOA.jpg" alt="profile picture">
		</div>
		<div class="col-6">
			<h1><?php echo $alumni->user->getFullName(); ?></h1>
			<h3><?php echo $alumni->functie; ?></h3>
			<p><?php echo $alumni->omschrijving; ?></p>
		</div>
	</article>
	<?php endforeach; ?>

</main>

<?php
	
	page_footer();
?>
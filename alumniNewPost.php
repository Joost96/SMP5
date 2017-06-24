<?php
    require 'func/page_header.php';	
    require 'func/page_footer.php';
	page_header("Nieuw alumni post","alumni","alumniPost");
?>

<main>
	<h1 class="center">maak een nieuwe alumni post</h1>
	<form class='new-post'>
		<div>
			<label for='functie'>functie</label>
			<input type='text' name='functie'><br>
		</div>
		<div>
			<label for='omschrijving'>omschrijving</label>
			<textarea name='omschrijving'></textarea><br>
		</div>
		<div>
			<label for='link'>Link naar linkedIn page</label>
			<input type='text' name='link'><br>
		</div>
		<div>
			<label for='link'>upload een afbeelding</label>
			<input type='file' name='afbeelding' id="afbeelding"><br>
			<img class="center" id="imgPreview" src="#" alt="your image is not a valid image format"/>
		</div>
		<div class='center buttons'>
			<input id='loginBtn' type='submit'>
			<input type='button' value='Annuleren'>
		</div>
	</form>

</main>

<?php
	
	page_footer();
?>
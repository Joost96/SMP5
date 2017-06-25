<!DOCTYPE HTML>
<html>
	<?php require (dirname(__DIR__).'/smp5/func/page_header.php');
	page_header("Portfolio", "home", "portfolioItemPopUp");
	?>
	
	<aside class="filters">
		<div id="form">
			<h3>FILTERS</h3>

		<div class="talen">
			<p>Talen: </p>
			<hr class="style2">
			<?php include (dirname(__DIR__).'/smp5/func/onderwerpfilters.php');?>
		</div>
		
		<div class="jaar">
			</br>
			<p>Leerjaren: </p>
			<hr class="style2">
			<?php for($i = 1; $i < 5; $i++)
			{
				echo "<label><input type='checkbox' name='jaarfilter' value=$i checked/>Jaar $i</label></br>";
			}?>
		</div>
		</br>
		<input type="submit" id="sorteer" name="portfilterSubmit" value="Sorteer" />
		</div>	
		<div class="test">
		<button id='maakItemBTN' hidden>Maak post</button>
		<?php include (dirname(__DIR__).'/smp5/func/nieuwPortItem.php');?>
		</div>
	</aside>

	<div class="itemsReturn">
	<?php include (dirname(__DIR__).'/smp5/func/portfilters.php'); ?>
	</div>

	<?php require (dirname(__DIR__).'/smp5/func/page_footer.php');
	page_footer();?>
	<script>
	$("#sorteer").click(function(){
		var jaarfilter = [];
			$('input[type=checkbox][name=jaarfilter]').each(function(){
				if($(this).is(':checked'))
				{
					jaarfilter.push($(this).val())
				}
			});
		var onderdeelfilter = [];
			$('input[type=checkbox][name=onderdeelfilter]').each(function(){
				if($(this).is(':checked'))
				{
					onderdeelfilter.push($(this).val())
				}
			});
		$.ajax({
			method: "POST",
			url: "func/portfilters.php", 
			data: {jaarfilter:jaarfilter, onderdeelfilter:onderdeelfilter}
		})
		.done(function(msg){
			$('.itemsReturn').html(msg);
		})
		.fail(function() {
			$('.itemsReturn').html("<p>Er is een fout op getreden bij het communiceren met de database</p>");
		});
		});				
	</script>
</html>
	
	
	
	

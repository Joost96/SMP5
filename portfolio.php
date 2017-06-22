<!DOCTYPE HTML>
<html>
	<?php require (dirname(__DIR__).'/smp5/func/page_header.php');
	page_header("Portfolio", "home","home");
	?>
	<aside class="filters">
	<h3>FILTERS</h3>
		<div id="form">

		<div class="talen">
			<p>Talen: </p>
			<hr class="style2">
			<?php include (dirname(__DIR__).'/smp5/func/onderwerpfilters.php');?>
		</div>
		
		<div class="jaar">
			</br>
			<p>Leerjaren: </p>
			<hr class="style2">
			<?php include (dirname(__DIR__).'/smp5/func/jaarfilters.php');?>
		</div>
		</br>
		<input type="submit" id="sorteer" name="portfilterSubmit" value="Sorteer" />
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
			console.log(onderdeelfilter);
			console.log(jaarfilter);
		$.ajax({
			method: "POST",
		  url: "func/portfilters.php", 
		  data: {jaarfilter:jaarfilter, onderdeelfilter:onderdeelfilter}
		})
		.done(function(msg){
			console.log(msg);
			$('.itemsReturn').html(msg);
		})
		.fail(function() {
			$('.itemsReturn').html("<p>Er is een fout op getreden bij het communiceren met de database</p>");
		});
		});
	</script>
</html>
	
	
	
	

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
		<br />
		<?php if(isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			echo "<button id='maakItemBTN'>Maak post</button>";
		} ?>		
		</div>	
		<div class="popupItem">	
		<?php include (dirname(__DIR__).'/smp5/func/nieuwPortItem.php');?>
		</div>
	</aside>

	<div class="itemsReturn">
	<?php include (dirname(__DIR__).'/smp5/func/toonItems.php'); ?>
	</div>

	<?php require (dirname(__DIR__).'/smp5/func/page_footer.php');
	page_footer();?>
</html>
	
	
	
	

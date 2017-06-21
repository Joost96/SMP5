<?php
    require 'func/page_header.php';	
    require 'func/page_footer.php';
	page_header("Curriculum","curriculum");
	
	include_once ("model/curriculumDAO.php");
	include_once ("model/vak.php");
	include_once ("model/periode.php");
	$curriculumDAO = new curriculumDAO();
	
	
	$periodes = $curriculumDAO->GetAllPeriodes($_SESSION["lang"]);
	
?>
<main>
	<article class="col-12">
		<table class="col-8">
			<thead>
				<tr>
					<th></th>
					<th>Periode 1</th>
					<th>Periode 2</th>
					<th>Periode 3</th>
					<th>Periode 4</th>
				</tr>
			</thead>
			<tbody>
				<?php for($jaar = 0;$jaar<4;$jaar++) : ?>		
					<tr>
						<th>Jaar <?php echo $jaar+1; ?></th>
						<?php for($periode = 0;$periode<4;$periode++) : 
							$periodeItems = array();							
							foreach($periodes as $periodeItem){							
								if ($periodeItem->jaar == $jaar+1 && $periodeItem->periode == $periode+1) {
									$periodeItems[] = $periodeItem;
								}
							}?>
							<th>
								<?php if(count($periodeItems) > 1) :
									foreach($periodeItems as $periodeItem): ?>
										<button class="double"><?php echo $periodeItem->naam; ?></button>	
									<?php endforeach;
								else : ?>
									<button id="<?php echo $periodeItems[0]->id; ?>"><?php echo $periodeItems[0]->naam; ?></button>	
								<?php endif; ?>	
							</th>
						<?php endfor; ?>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
		<div class="omschrijving col-4">
			<h1><?php echo $periodes[0]->naam; ?></h1>
			<p><?php echo $periodes[0]->omschrijving; ?></p>
		</div>
	</article>
</main>

<?php
	
	page_footer();
?>
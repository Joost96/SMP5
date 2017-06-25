<?php 
	include_once(dirname(__DIR__).'/model/user.php');
	include_once(dirname(__DIR__).'/model/portfolioDAO.php');
	
	$portDAO = new portfolioDAO();
	$onderdelen = $portDAO->GetALLExamenOnderdelen();
	
	echo "<div id='itemModal' class='modal'>
			<div class='modal-content'>
				<form class='form' action='#' id='nieuwItem'>
					<h3>New portfolio-item</h3>
					<hr/><br/>
					<label>Dutch title: <span>*</span></label>
					<br/>
					<input type='text' name='titel' id='titel' placeholder='Vul een Nederlandse titel in:'/><br/>
					<br/>
					<label>English Title: <span>*</span></label>
					<br />
					<input type='text' name='title' id='title' placeholder='Please fill in an English title:'/><br/>
					<br/>
					<label>Techniques used<span>*</span></label>
					<br/>
					<input type='text' name='technieken' id='technieken' placeholder='C#, SQL, HTML, etc...'/><br/>
					<br/>
					<label>Subject: <span>*</span></label>
					<br/>";
					foreach($onderdelen as $onderdeel)
					{
						echo "<label><input type='checkbox' name='onderdeel' value=$onderdeel->ID />$onderdeel->naam</label></br>";
					}			
	echo			"<br />
					<select name='leerjaar'>
						<option value=''>Select....</option>
						<option value='1'>Year 1</option>
						<option value='2'>Year 2</option>
						<option value='3'>Year 3</option>
						<option value='4'>Year 4</option>
					</select>
					<br />
					<br />
					<label>Dutch Description:</label>
					<br/>
					<textarea id='beschrijving' placeholder='Dutch description...'></textarea><br/>
					<br/>
					<label>English Description:</label>
					<br/>
					<textarea id='description' placeholder='English description...'></textarea><br/>
					<br/>
					<label>Upload up to four pictures via instagramlink: </label>
					<br />";
					for($i = 0; $i < 4; $i++)
					{
						echo "<input type='text' class='foto' placeholder='instagram.com/p/.....'/><br />";
					}								
	echo			"<br />
					<label>YouTube video<span>*</span></label>
					<br/>
					<input type='text' name='yt' id='yt' placeholder='youtube.com/watch?v=.....'/><br/>
					<br/>
					<input name='post' type='button' id='send' value='Post'/>
					<input type='button' id='cancel' value='Cancel'/>
					<br/>
				</form>
			</div>
		</div>";
?>
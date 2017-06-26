<?php 
	include_once(dirname(__DIR__).'/model/user.php');
	include_once(dirname(__DIR__).'/model/portfolioDAO.php');
	
	$portDAO = new portfolioDAO();
	$onderdelen = $portDAO->GetALLExamenOnderdelen();
	
	echo "<div id='itemModal' class='modal'>
			<div class='modal-content'>
				<form class='itemForm' id='nieuwItem'>
					<h3>New portfolio-item</h3>
					<hr/><br/>
					<label id ='nti'>Dutch title: <span>*</span></label>
					<br/>
					<input type='text' name='titel' id='titel' placeholder='Vul een Nederlandse titel in:'/><br/>
					<br/>
					<label id = 'eti'>English Title: <span>*</span></label>
					<br />
					<input type='text' name='title' id='title' placeholder='Please fill in an English title:'/><br/>
					<br/>
					<label id = 'tec'>Techniques used<span>*</span></label>
					<br/>
					<input type='text' name='technieken' id='technieken' placeholder='C#, SQL, HTML, etc...'/><br/>
					<br/>
					<label id='ond'>Subject: <span>*</span></label>
					<br/>";
					foreach($onderdelen as $onderdeel)
					{
						echo "<label><input type='checkbox' id='onderdeel' name='onderdeel' value=$onderdeel->ID />$onderdeel->naam</label></br>";
					}			
	echo			"<label id='lee'>Year: <span>*</span></label>
					<br />
					<select id='leerjaar'>
						<option value=''>Select....</option>
						<option value='1'>Year 1</option>
						<option value='2'>Year 2</option>
						<option value='3'>Year 3</option>
						<option value='4'>Year 4</option>
					</select>
					<br />
					<br />
					<label id ='bes'>Dutch Description:</label>
					<br/>
					<textarea id='beschrijving' name='beschrijving' placeholder='Dutch description...'></textarea><br/>
					<br/>
					<label id='des'>English Description:</label>
					<br/>
					<textarea id='description' name='description' placeholder='English description...'></textarea><br/>
					<br/>
					<label id='pic'>Upload up to four pictures via instagramlink: </label>
					<br />";
					for($i = 0; $i < 4; $i++)
					{
						echo "<input type='text' id='foto' class='foto' placeholder='instagram.com/p/.....'/><br />";
					}								
	echo			"<br />
					<label id='you'>YouTube video<span>*</span></label>
					<br/>
					<input type='text' name='yt' id='yt' placeholder='youtube.com/watch?v=.....'/><br/>
					<br/>
					<input name='post' type='submit' id='send' value='Post'/>
					<input type='button' id='cancel' value='Cancel'/>
					<br/>
				</form>
			</div>
		</div>";
?>
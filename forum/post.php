<?php
	include_once (dirname(__DIR__).'/func/page_header.php');
	include_once (dirname(__DIR__).'/func/page_footer.php');
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	include_once (dirname(__DIR__).'/model/ForumPostModel.php');
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	
	$post_id = $_GET['post_id'];
	
	$forumdao = new forumDAO();
	
	$post = $forumdao->getPostbyid($post_id);
	
	$reacties = $forumdao->getAllReacties($post_id);
	
	$reacties = array_reverse($reacties);

	$style = "forum";
	
	page_header($post->titel, $style);

	echo "<section id='postPageContent'>";
	echo "
		<h2>{$post->titel}</h2>
		<p>{$post->content}</p>
		<p>{$post->datum}</p>
		";
	
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
		echo "
			<form id='reactieForm' action='plaatsReactie.php' method='post'>
				<label id='reactieLabel' for='reactie'>Reactie:</label>
				<textarea form='reactieForm' rows='8' cols='200' value='' id='reactieTextBox' name='reactie_content'></textarea>
				<input type='hidden' value='{$post_id}' name='post_id' />
				<input type='submit' value='POST' id='postButton'/>
			</form>
		";	
	}
	echo "<table id='reacties'>";
	foreach ( $reacties as $reactie ){
		echo "
			<tr>
				<td id='reactieUsername'>{$reactie->user->username}:</td>
				<td id='reactieContent'>{$reactie->content}</td>
			</tr>
			";
	}
	echo "
		</table>
		</section>
		";
	page_footer();
?>
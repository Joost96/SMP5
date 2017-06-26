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

	$title = "Forum";
	$style = "forum";
	$script = "nieuweReactie";
	
	page_header($title, $style, $script);

	echo "
		<section id='postPageContent'>
		<section class='post'>";
	echo "
		<h6>{$post->titel}</h6>
		<h5>{$post->datum}</h5>
		<p>{$post->content}</p>
		";
	
	echo "
		</section>
		<section class='reactieSection'>
		<section class='reactieForm'>";
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
		echo "
			<form id='reactieForm' method='post'>
				<label id='reactieLabel' for='reactie'>Reactie:</label>
				<textarea form='reactieForm' rows='8' cols='200' value='' id='reactieTextBox' name='reactie_content'></textarea>
				<input id='post_id' type='hidden' value='{$post_id}' name='post_id' />
				<input type='submit' value='POST' id='postButton'/>
			</form>
		";	
	}
	
	echo "
		</section>
		<section class='reacties'>";
	foreach ( $reacties as $reactie ){
		echo "
				<article class='reactieArticle'>
					<h6 id='reactieUsername'>{$reactie->user->username}</h6>
					<h5 id='reactieDatetime'>{$reactie->dateTime}</h5>
					<hr class='lijn'>
					<p id='reactieContent'>{$reactie->content}</p>
				</article>
			";
	}
	echo "
		</section>
		</section>
		</section>
		";
	page_footer();
?>
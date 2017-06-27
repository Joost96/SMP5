<?php
	include_once (dirname(__DIR__).'/model/ReactieModel.php');
	include_once (dirname(__DIR__).'/model/forumDAO.php');
	
	function printReacties ($post_id){
		
		$forumdao = new forumDAO();
		$reacties = $forumdao->getAllReacties($post_id);
		
		$i = 1;

		foreach ( $reacties as $reactie ){
			echo "
					<article class='reactieArticle'>
						<h6 id='reactieUsername'>{$reactie->user->username}</h6>
						<h5 id='reactieDatetime'>{$reactie->dateTime}</h5>
						<hr class='lijn'>
						<p id='reactieContent'>{$reactie->content}</p>
					</article>
				";
			
			$i++;
		}	
	}
?>
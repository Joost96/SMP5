function onLoad (){
	$( "#postBtn" ).click(function(){
		event.preventDefault();
		
		var postTitel = $("#nieuwePostForm input[name=titel]").val();
		var postContent = $("#nieuwePostForm input[name=content]").val();
		var onderwerpId = $("#nieuwePostForm input[name=onderwerp_id]").val();
		
		$.ajax({
			method: "POST",
			url: "/smp5/func/plaatPost.php",
			data: {
				titel: postTitel,
				content: postContent,
				onderwerp_id: onderwerpId
			}
		});
	});
}
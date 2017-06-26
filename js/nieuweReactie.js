function onLoad (){
	$( "#postButton" ).click(function(){
		var reactieContent = ("#reactieTextBox").val();
		var postId = ("#post_id").val();
		
		$.ajax({
			method: "POST",
			url: "/smp5/func/plaatsReactie.php",
			data: {
				reactieContent: reactie_content,
				postId: post_id
			}
		}).done(function(msg){
			console.log(msg);
		}).fail(function(msg) {
			console.log(msg);
		});
	});
}
function onLoad (){
	$( "#reactieForm" ).submit(function( event ){
		$("reactieForm").next(".error").remove();
		event.preventDefault();
		var reactieContent = $("#reactieTextBox").val();
		var postId = $("#post_id").val();
		
		if (reactieContent == ""){
			$("#reactieForm").append($("<p class='error'>Reactie mag niet leeg zijn!</p>"));
			return;
		}
		
		$.ajax({
			method: "POST",
			url: "/smp5/func/plaatsReactie.php",
			data: {
				reactieContent: reactieContent,
				postId: postId
			}
		}).done(function(msg){
			$(".reacties").html(msg);
			$("#reactieTextBox").val("");
		}).fail(function(msg) {
			console.log(msg);
		});
	});
}
function onLoad (){
	$( ".reactieveld" ).submit(function( event ){
		$("reactieveld").next(".error").remove();
		event.preventDefault();
		var reactieContent = $("#veld").val();
		var itemID = $("#ID").val();
		
		if (reactieContent == ""){
			$("#reactieveld").append($("<p class='error'>Reactie mag niet leeg zijn!</p>"));
			return;
		}
		
		$.ajax({
			method: "POST",
			url: "/smp5/func/plaatsPortfolioReactie.php",
			data: {
				reactieContent: reactieContent,
				itemID : itemID
			}
		}).done(function(msg){
			$(".reacties").html(msg);
			$("#veld").val("");
		}).fail(function(msg) {
			console.log(msg);
		});
	});
}
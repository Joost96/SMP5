function onLoad (){
		$("#portforeactie").click(function() {
		var content = $.trim($('#veld').val());
		var itemID = $('#ID').val();
		if(content == '') 
		{
			alert('Je hebt geen reactie ingevoerd!');
		}
		else{
			$.ajax({
				method: "POST",
				url: "/smp5/func/plaatsPortfolioReactie.php",
				data: {itemID:itemID, content:content}
			})
			.done(function(msg){
			console.log(msg);
				$('.reacties').html(msg);
				content = "";
			})
			.fail(function(){
				alert('Er is iets misgegaan bij het plaatsen van je reactie');
			});
			
			event.preventDefault();
		}
	});
	
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
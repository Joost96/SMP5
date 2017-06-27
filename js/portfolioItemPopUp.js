function onLoad() {
	$(document).mouseup(function(e) 
	{
		var container = $(".modal-content");
		
		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) 
		{
			$(".modal").hide();
			$('#nieuwItem')[0].reset();
		}
	});
	
	// Button die het form opent
	$("#maakItemBTN").click(function() {
		$("#itemModal").find(".error").remove();
		$("#itemModal").show();
				
	});
	
	//Button die het form sluit
	$("#itemModal #cancel").click(function(){
		$('#nieuwItem')[0].reset();
		$(".modal").hide();
	});
	
	//button die alle waarden van het form post
	$("#itemModal .itemForm").submit(function(event){
		$(".itemForm").find(".error").remove();
		event.preventDefault();
		
		var titelNL = $('.itemForm input[name=titel]').val();
		var titelEN = $('.itemForm input[name=title]').val();
		var technieken = $('.itemForm input[name=technieken]').val();
		var onderdelen = [];
		$("input:checkbox[name=onderdeel]:checked").each(function(){
			onderdelen.push($(this).val());
		});	
		var jaar = $('.itemForm #leerjaar :selected').val();
		var fotos = [];
		$('.foto').each(function() {
			fotos.push($(this).val());
		});
		var yt = "";
		yt = $('.itemForm input[name=yt]').val();
		var description = $('.itemForm textarea[name=description]').val();
		var beschrijving = $('.itemForm textarea[name=beschrijving]').val();
		var errors = 0;
			
		if(titelNL == "")
		{
			$('#nti').after( $( "<p class='error'>Geen titel ingevoerd</p>"));
			errors++;
		}
		if(titelEN == "")
		{
			var error = $('#eti').after( $( "<p class='error'>You didn't enter a title</p>"));
			errors++;
		}
		if(technieken == "")
		{
			$('#tec').after( $( "<p class='error'>Geen technieken geselecteerd</p>"));
			errors++;
		}
		if(!validateOnderdelen(onderdelen))
		{
			$('#ond').after( $( "<p class='error'>Geen examenonderdeel geselecteerd</p>"));
			errors++;
		}
		if(!$.isNumeric(jaar))
		{
			$('#lee').after( $( "<p class='error'>Geen leerjaar geselecteerd</p>"));
			errors++;
		}
		
		if(!validateFotos(fotos))
		{
			$('#pic').after( $( "<p class='error'>Onjuiste URL, of geen foto toegevoegd.</p>"));
				errors++;
		}
		
		if(!validateYt(yt))
		{
			$('#you').after( $( "<p class='error'>De youtubelink was onjuist</p>"));		
		}
		
		if(beschrijving == "")
		{
			$('#bes').after( $( "<p class='error'>Geen Nederlandse beschrijving toegevoegd</p>"));
			errors++;
		}
		
		if(description == "")
		{
			$('#des').after( $( "<p class='error'>No English description added</p>"));
			errors++;
		}
		
		if(errors == 0)
		{
			$.ajax({
					method: "POST",
					url: "/smp5/func/createItem.php",
					data: {
						titelNL : titelNL,
						titelEN : titelEN,
						technieken : technieken,
						onderdelen : onderdelen,
						jaar : jaar,
						fotos : fotos,
						yt : yt,		
						description : description,
						beschrijving : beschrijving
					}})
				.done(function(msg) {
					console.log(msg);
					$('#nieuwItem')[0].reset();
					$(".modal").hide();
					$("#sorteer").click();
				})
				.fail(function() {
					$('#nieuwItem')[0].reset();
					$(".modal").hide();
				});
		}
		else 
			console.log(errors);
});

	function isLoggedIn(){
		$('#maakItemBTN').show();
	}
		
	$("#sorteer").click(function(){
		var jaarfilter = [];
			$('input[type=checkbox][name=jaarfilter]').each(function(){
				if($(this).is(':checked'))
				{
					jaarfilter.push($(this).val())
				}
			});
		var onderdeelfilter = [];
			$('input[type=checkbox][name=onderdeelfilter]').each(function(){
				if($(this).is(':checked'))
				{
					onderdeelfilter.push($(this).val())
				}
			});
		$.ajax({
			method: "POST",
			url: "func/toonItems.php", 
			data: {jaarfilter:jaarfilter, onderdeelfilter:onderdeelfilter}
		})
		.done(function(msg){
			$('.itemsReturn').html(msg);
		})
		.fail(function() {
			$('.itemsReturn').html("<p>Er is een fout op getreden bij het communiceren met de database</p>");
		});
	});	
		
	$("#deleteknop").click(function(){
			var itemID = $("#hiddenID").val();
			
			$.ajax({
				method: "POST",
				url: "func/deleteItems.php",
				data: {itemID:itemID}
			})
			.done(function(){
				$("#sorteer").click();
			})
			.fail(function(){
				$('.itemsReturn').html("<p>Er is een fout op getreden bij het communiceren met de database</p>");
			});
	});
				
}
function validateOnderdelen(onderdelen)
{
	if($(onderdelen).length !== 0)
	{
		$.each(onderdelen, function(index, value)
		{
			if(!$.isNumeric(value))
				{
					onderdelen.splice(onderdelen.indexOf(value), 1);
				}
		});
		return true;
	}
	else 
		return false;
}
		
function validateFotos(fotos)
{
	var check = "https://www.instagram.";
	
	if($(fotos).length !== 0)
	{
		for(var i = fotos.length -1; i >= 0; i--)
		{
			if(fotos[i] == "")
				fotos.splice(i, 1);
			else if(fotos[i].indexOf(check) == -1)
				fotos.splice(i, 1);
		}
		if($(fotos).length > 0)
			return true;
		else
			return false;
	}
		
}

function validateYt(yt)
{
	var check = "https://www.youtube.com/";
	var check2 = "https://youtu.be/";
	
	if((yt.indexOf(check) > -1) || (yt.indexOf(check2) > -1))
		return true;
	else
		return false;
}

	
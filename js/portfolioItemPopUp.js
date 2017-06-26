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
		$("#itemModal").show();
	});
	
	//Button die het form sluit
	$("#itemModal #cancel").click(function(){
		$('#nieuwItem')[0].reset();
		$(".modal").hide();
	});
	
	//button die alle waarden van het form post
	$("#itemModal .itemForm").submit(function(event){
	$("#itemModal #nieuwItem").find(".error").remove();
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
	var yt = $('.itemForm input[name=yt]').val();
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
		$('#pic').after( $( "<p class='error'>De URL van één van de foto's was onjuist</p>"));
			errors++;
	}
	
	if(!validateYt(yt))
	{
		$('#you').after( $( "<p class='error'>De youtubelink was onjuist</p>"));
		errors++;		
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
					beschrijving : beschrijving,
				}
			})
			.done(function(msg) {
				console.log(msg);});
	}
	else 
		console.log(errors);
});

/*de foute moeten nog uit het array*/
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
		
/*idem hier*/
function validateFotos(fotos)
{
	var check = "https://www.instagram.";
	if($(fotos).length !== 0)
	{
		$.each(fotos, function(index, value)
		{
			if(!value == "")
			{	
				if(value.indexOf(check) == -1)
					fotos.splice(fotos.indexOf(value), 1);
			}
		});
		return true;
	}
	else	
		return true;
}

function validateYt(yt)
{
	var check = "https://youtube.";
	var check2 = "https://youtu.be";
	
	if(!yt == "")
	{
		if((yt.indexOf(check) == -1) || (yt.indexOf(check2) == -1))
			return false;
	}
	else
		return true;
}
}
	
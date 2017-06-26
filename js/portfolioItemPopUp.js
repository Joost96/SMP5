function onLoad() {
	$(document).mouseup(function(e) 
	{
		var container = $(".modal-content");
		
		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) 
		{
			$(".modal").hide();
		}
	});
	
	// Button die het form opent
	$("#maakItemBTN").click(function() {
		$("#itemModal").show();
	});
	
	//Button die het form sluit
	$("#itemModal #cancel").click(function(){
		$(".modal").hide();
	});
	
	//button die alle waarden van het form post
	$("#itemModal #send").click(function(){
	$("#itemModal .itemForm").find(".error").remove();
	
	var titelNL = $('#itemModal input[name=titel]').val();
	var titelEN = $('#itemModal input[name=title]').val();
	var technieken = $('#itemModal input[name=technieken]').val();
	var onderdelen = [];
	$("input:checkbox[name=onderdeel]:checked").each(function(){
		onderdelen.push($(this).val());
	});	
	var jaar = $('#itemModal #leerjaar option:selected').val();
	var fotos = [];
	$('.foto').each(function() {
		fotos.push($(this).val());
	});
	var youtube = $('#itemModal input[name=yt]').val();
	var description = $('#itemModal textarea[name=description]').val();
	var beschrijving = $('#itemModal textarea[name=beschrijving]').val();
		
	if(titelNL == "")
	{
		$('#itemModal .itemForm').parrent().append( $( "<p class='error'>Geen titel ingevoerd</p>"));
	}
	if(titelEN == "")
	{
		var error = $('#itemModal .itemForm').parent().append( $( "<p class='error'>You didn't enter a title</p>"));
	}
	if(technieken == "")
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>Geen technieken geselecteerd</p>"));
		return;
	}
	if(!validateOnderdelen(onderdelen))
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>Geen examenonderdeel geselecteerd</p>"));
		return;
	}
	if(!$.isNumeric(jaar))
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>Geen leerjaar geselecteerd</p>"));
		return;
	}
	if(!validateFotos(fotos))
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>De URL van één van de foto's was onjuist</p>"));
		return;
	}
	
	if(!validateYt(yt))
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>De youtubelink was onjuist</p>"));
		
	}
	
	if(beschrijving == "")
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>Geen Nederlandse beschrijving toegevoegd</p>"));
		return;
	}
	
	if(beschrijving == "")
	{
		$('#itemModal .itemForm').parent().append( $( "<p class='error'>No English description added</p>"));
		return;
	}
	
	else
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
				beschrijving : beschrijving,
				description : description
			}
		})
		.done(function(msg) {
			console.log(msg);});
	
}
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
					return false;
				}
		});
	}
}
		
function validateFotos(fotos)
{
	var check = "https://www.instagram.";
	$.each(fotos, function(index, value)
	{
		if(!value == "")
		{	
			if(value.indexOf(check) == -1)
				return false;
		}
		else
			return false;
	});
}

function validateYt(yt)
{
	var check = "https://youtube.";
	var check2 = "https://youtu.be";
	
	if((yt.indexOf(check) == -1) || (yt.indexOf(check2) == -1))
		return false;
}
	
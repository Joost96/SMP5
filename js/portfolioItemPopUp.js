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
	
	$("#maakItemBTN").click(function() {
		$("#itemModal").show();
	});
	
	$("#itemModal .form").find(".error").remove();
	
	var titelNL = $('#itemModal input[name=titel]').val();
	var titelEN = $('#itemModal input[name=title]').val();
	var technieken = $('#itemModal input[name=technieken]').val();
	var onderdelen = [];
	$("input:checkbox[name=onderdeel]:checked").each(function(){
		onderdelen.push($(this).val());
	});	
	var jaar = document.getElementById("leerjaar");
	var leerjaar = jaar.options[jaar.selectedIndex].value;
	var foto1 = 
}
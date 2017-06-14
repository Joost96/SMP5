window.onload = function() {
	//--login model

	// When the user clicks anywhere outside of the modal, close it
	$(document).mouseup(function(e) 
	{
		var container = $(".modal-content");
		
		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) 
		{
			$(".modal").hide();
		}
	});
	
	$( "#loginModalBtn" ).click(function() {
		$("#loginModel").show();
	});
	
	$( ".close" ).click(function() {
		$(".modal").hide();
	});
	
	$( "#loginBtn" ).click(function() {
		var username = $('input[name=username]').val();
		var password = $('input[name=password]').val();
		$.ajax({
			method: "POST",
			url: "func/login.php",
			data: { username: username, password: password }
		})
		.done(function( msg ) {
			alert(msg );
			if (msg.indexOf("valid login") >= 0)
				$("#loginModel").hide();
		});
	});
	//--register modal
	$( "#registerModalBtn" ).click(function() {
		$("#registerModel").show();
		$("#loginModel").hide();
	});
	
	$( "#registerBtn" ).click(function() {
		var username = $('input[name=username]').val();
		var firstName = $('input[name=firstName]').val();;
		var lastName = $('input[name=lastName]').val();;
		var studentId = $('input[name=studentId]').val();;
		var email = $('input[name=email]').val();;
		var password = $('input[name=password]').val();
		
		$.ajax({
			method: "POST",
			url: "func/login.php",
			data: { 
			username: username, 
			password: password,
			firstName: firstName,
			lastName: lastName,
			studentId: studentId,
			email: email
			}
		})
		.done(function( msg ) {
			alert(msg );
			if (msg.indexOf("valid register") >= 0)
				$("#loginModel").hide();
		});
	});
}

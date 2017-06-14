window.onload = function() {
	//--login model
	// Get the modal
	var modal = document.getElementById('loginModel');

	// Get the button that opens the modal
	var btn = document.getElementById("loginModalBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
		
	$( "#loginBtn" ).click(function() {
		$.ajax({
			method: "POST",
			url: "func/login.php",
			data: { username: $('input[name=username]').val(), password: $('input[name=password]').val() }
		})
		.done(function( msg ) {
			alert(msg );
			if (msg.indexOf("login") >= 0)
				$("#loginModel").hide();
		});
	});
}

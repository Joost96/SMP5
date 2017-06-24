window.onload = function() {
	loggedIn()
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
	//--login model
	//open modal login
	$( "#loginModalBtn" ).click(function() {
		if($("#loginModalBtn").html() == "Inloggen")
			$("#loginModel").show();
		else {
			$.ajax({
				url: "/smp5/func/logout.php"
			})
			.done(function( msg ) {
				console.log(msg);
				$("#username").html("NULL");
				loggedIn();
			}).fail(function() {
				console.log("failed");
			});
		}
	});
	//close modal
	$( ".close, input[value=Annuleren]" ).click(function() {
		$(".modal").hide();
	});
	//clicked login
	$( "#loginBtn" ).click(function() {
		$( "#loginModel .form" ).find(".error").remove();
		
		var username = $('#loginModel input[name=username]').val();
		var password = $('#loginModel input[name=password]').val();
		if(username && password) {
			$.ajax({
				method: "POST",
				url: "/smp5/func/login.php",
				data: { username: username, password: password },
				dataType: 'json'
			})
			.done(function( msg ) {
				console.log(msg );
				if (msg.status.indexOf("valid login") >= 0) {
					$("#loginModel").hide();
					logIn(msg.user);
				} else {
					$( "#loginModel .form" ).append( $( "<p class='error'>Gebruikersnaam of wachtwoord is incorrect</p>" ) );
				}
			}).fail(function() {
				$( "#loginModel .form" ).append( $( "<p class='error'>Verbinding maken met de server is mislukt , probeer het later opnieuw</p>" ) );
			});
		}
	});
	//--register modal
	//open modal
	$( "#registerModalBtn" ).click(function() {
		$("#registerModel").show();
		$("#loginModel").hide();
	});
	//clicked register
	$( "#registerBtn" ).click(function() {
		$( "#registerModel input[name=studentId]" ).next(".error").remove();
		$( "#registerModel input[name=email]" ).next(".error").remove();
		$( "#registerModel input[name=password]" ).next(".error").remove();
		$( "#registerModel input[name=username]" ).next(".error").remove();
		$( "#registerModel .form" ).find(".error").remove();
		
		var username = $('#registerModel input[name=username]').val();
		var firstName = $('#registerModel input[name=firstName]').val();;
		var lastName = $('#registerModel input[name=lastName]').val();;
		var studentId = $('#registerModel input[name=studentId]').val();;
		var email = $('#registerModel input[name=email]').val();;
		var password = $('#registerModel input[name=password]').val();
		var confirmPassword = $('#registerModel input[name=confirmPassword]').val();
		if(!validateStudentId(studentId)) {
			$( "#registerModel input[name=studentId]" ).parent().append( $( "<p class='error'>Student id is incorrect</p>" ) );
			return;
		}
		if(!validateEmail(email)) {
			$( "#registerModel input[name=email]" ).parent().append( $( "<p class='error'>Email is incorrect</p>" ) );
			return;
		}
		if(password.localeCompare(confirmPassword)) {
			$( "#registerModel input[name=password]" ).parent().append( $( "<p class='error'>wachtworden zijn niet gelijk</p>" ) );
			return;
		}
		
		if(username && email && password) {
			$.ajax({
				method: "POST",
				url: "/smp5/func/register.php",
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
				console.log(msg );
				if (msg.indexOf("valid register") >= 0)
				{
					$("#loginModel").hide();
				} else if(msg.indexOf("username taken") >= 0) {
					$( "#registerModel input[name=username]" ).parent().append( $( "<p class='error'>Gebruikersnaam is in gebruik</p>" ) );
				}
			}).fail(function() {
				$( "#registerModel .form" ).append( $( "<p class='error'>Verbinding maken met de server is mislukt , probeer het later opnieuw</p>" ) );
			});
		}
	});
}
function logIn(user) {
	$("#username").html(user.username);
	loggedIn();
}
function loggedIn() {
	if($("#username").html() != "NULL") {
		$("#username").css('display', 'block')
		$("#loginModalBtn").html("Uitloggen");
	} else {
		$("#username").css('display', 'none')
		$("#loginModalBtn").html("Inloggen");
	}
}
function validateEmail(email) 
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validateStudentId(StudentId) 
{
    var re = /^[0-9]*$/;
    return re.test(StudentId);
}
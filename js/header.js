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
			$("#loginModal").show();
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
		$( "#loginModal .form" ).find(".error").remove();
		
		var username = $('#loginModal input[name=username]').val();
		var password = $('#loginModal input[name=password]').val();
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
					$("#loginModal").hide();
					logIn(msg.user);
				} else {
					$( "#loginModal .form" ).append( $( "<p class='error'>Gebruikersnaam of wachtwoord is incorrect</p>" ) );
				}
			}).fail(function() {
				$( "#loginModal .form" ).append( $( "<p class='error'>Verbinding maken met de server is mislukt , probeer het later opnieuw</p>" ) );
			});
		}
	});
	//--register modal
	//open modal
	$( "#registerModalBtn" ).click(function() {
		$("#registerModal").show();
		$("#loginModal").hide();
	});
	//clicked register
	$( "#registerBtn" ).click(function() {
		$( "#registerModal input[name=studentId]" ).next(".error").remove();
		$( "#registerModal input[name=email]" ).next(".error").remove();
		$( "#registerModal input[name=password]" ).next(".error").remove();
		$( "#registerModal input[name=username]" ).next(".error").remove();
		$( "#registerModal .form" ).find(".error").remove();
		
		var username = $('#registerModal input[name=username]').val();
		var firstName = $('#registerModal input[name=firstName]').val();;
		var lastName = $('#registerModal input[name=lastName]').val();;
		var studentId = $('#registerModal input[name=studentId]').val();;
		var email = $('#registerModal input[name=email]').val();;
		var password = $('#registerModal input[name=password]').val();
		var confirmPassword = $('#registerModal input[name=confirmPassword]').val();
		if(!validateStudentId(studentId)) {
			$( "#registerModal input[name=studentId]" ).parent().append( $( "<p class='error'>Student id is incorrect</p>" ) );
			return;
		}
		if(!validateEmail(email)) {
			$( "#registerModal input[name=email]" ).parent().append( $( "<p class='error'>Email is incorrect</p>" ) );
			return;
		}
		if(password.localeCompare(confirmPassword)) {
			$( "#registerModal input[name=password]" ).parent().append( $( "<p class='error'>wachtworden zijn niet gelijk</p>" ) );
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
					$("#loginModal").hide();
				} else if(msg.indexOf("username taken") >= 0) {
					$( "#registerModal input[name=username]" ).parent().append( $( "<p class='error'>Gebruikersnaam is in gebruik</p>" ) );
				}
			}).fail(function() {
				$( "#registerModal .form" ).append( $( "<p class='error'>Verbinding maken met de server is mislukt , probeer het later opnieuw</p>" ) );
			});
		}
	});
	
	//load other js files:
	if (typeof onLoad === "function") { 
		onLoad();
	}
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
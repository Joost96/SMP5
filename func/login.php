<?php
$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim_data($_POST["username"]);
  $password = trim_data($_POST["password"]);
  
  echo $username;
  echo $password;
}

function trim_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<head>
	<link rel='stylesheet' type='text/css' href='../css/login.css'/>
	<link rel='stylesheet' type='text/css' href='../css/style.css'/>
</head>
<body>

<h2>Modal Example</h2>

<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<!-- The Modal for login -->


<script>
// Get the modal
var modal = document.getElementById('login');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

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
</script>
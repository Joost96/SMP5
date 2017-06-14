<?php
session_start();
    //require 'func/page_header.php';
	//page_header("test");
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>
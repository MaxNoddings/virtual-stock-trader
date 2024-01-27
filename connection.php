<?php
    
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "loginSignUp";
     
    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("failed to connect!");
    }
    

    /*
    // Connect and select the "test" database
	$mysqli = new mysqli("localhost", "root", "", "login_signup_db");
	if ($mysqli->connect_errno) {
		die("Connection Failed: ($mysqli->connect_errno) $mysqli->connect_error");
	}
    */
?>
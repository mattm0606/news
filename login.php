<?php
    require 'register.php';
    
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $username, $pwd_hash);
$stmt->fetch();

$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
    // Login succeeded!
    session_start();
	$_SESSION['username'] = $user;  
    // Redirect to your target page
    header("Location: home.php");
} else{
    // Login failed; redirect back to the login screen
    header("Location: login.php");
}
?>
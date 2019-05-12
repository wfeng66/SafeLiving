<?php # Script 12.11 - logout.php
// This page lets the user logout

session_start();

//if no session variable exists, redirect the user;
if (!isset($_SESSION['userid'])){
    require('includes/login_functions.inc.php');
    redirect_user();
}else{  // terminal the session
    $_SESSION = [];         // clear the variable
    session_destroy();      // destroy the session
    setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);     // destroy the cookie
}

$page_title = 'Logged Out!';
include('includes/header.html');

echo "<h1>Logged Out!</h1><p>You are now logged out!</p>";

?>
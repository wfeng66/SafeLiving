<?php # Script 12.9 - loggedin.php #2
// The user is redirected here from login.php.
session_start(); // Start the session.
// If no session value is present, redirect the user:
if (!isset($_SESSION['userid'])) {
	// Need the functions:
	require('includes/login_functions.inc.php');
	//redirect_user();
}
// Set the page title and include the HTML header:
$page_title = 'Logged In!';
include('includes/header.html');
// Print a customized message:
echo "<h1>Logged In!</h1>
<p>You are now logged in, {$_SESSION['name']}!</p>
<p><a href=\"logout.php\">Logout</a></p>";
include('includes/footer.html');
//header("Location: gen_crime.html");
header("Location: showcounty.php");
?>
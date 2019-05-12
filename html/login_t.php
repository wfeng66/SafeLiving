<?php # Script 12.8 - login.php #3
// This page processes the login form submission.
// The script now uses sessions.
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Need two helper files:
	require('includes/login_functions.inc.php');
	require('security/connect_t.php');

	// Check the login:
	
	list ($check, $data) = check_login($dbc, $_POST['username'], $_POST['password']);
	if ($check) { // OK!
		// Set the session data:
		session_start();
		$_SESSION['userid'] = $data['userid'];
		$_SESSION['user'] = $data['user'];
		
		// Redirect:
		redirect_user("loggedin_t.php");
	} else { // Unsuccessful!
		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;
	}
	mysqli_close($dbc); // Close the database connection.
} // End of the main submit conditional.
// Create the page:

include('includes/login_page.inc.php');
?>
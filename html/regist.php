

<?php
ini_set('display_errors',1);            //display error
ini_set('display_startup_errors',1);    //php startup error 
error_reporting(-1);                    // print all error information

/*
function check_regist($dbc, $usern = '', $pass = '', $email = '') {
	$errors = []; // Initialize error array.
	// Validate the Username:
//redirect_user('loggedin.php');
	//echo "You input is: ";
	
	if (empty($usern)) {
		$errors[] = 'You forgot to enter your Username.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($usern));
	}
	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}
    if (empty($email)) {
		$errors[] = 'You forgot to enter your email.';
	} else {
		$ee = mysqli_real_escape_string($dbc, trim($email));
	}
    
    // check if the username exists
    $q_test = "SELECT user FROM users WHERE user='$e'";
    $r_test = mysqli_query($dbc, $q_test);
    if(mysqli_num_rows($r_test)>=1){
		$errors[] = 'User already exists';
	}else{
		if (empty($errors)) {							// If everything's OK.
            // Retrieve the user_id and first_name for that username/password combination:
            $q = "INSERT INTO users(user, password, email) VALUES('$e',SHA1('$p'), '$ee')";
		    $r = mysqli_query($dbc, $q); // Run the query.
		    // Check the result:
            if ($r){
              echo 'Congratulation!!! Register successfully!';
		    } else {
              $errors[] = 'Register fail!';
			  echo "Register fail!";
            } 
		}												// End of empty($errors) IF.
	}

	   // Return false and the errors:
	   return [false, $errors]; 
	}
*/


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Need two helper files:
	require('includes/login_functions.inc.php');
	require('security/connect_t.php');

	// Check the login:
	list ($check, $data) = check_regist($dbc, $_POST['username'], $_POST['password'], $_POST['email']);
	if ($check) { // OK!
		// Set the session data:
		session_start();
		$_SESSION['userid'] = $data['userid'];
		$_SESSION['user'] = $data['user'];
		// Redirect:

		redirect_user("registeredin.php");
	} else { // Unsuccessful!
		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;
	}
	mysqli_close($dbc); // Close the database connection.
}

include('includes/regist_page.inc.php');

?>
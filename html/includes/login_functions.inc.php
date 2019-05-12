<?php # Script 12.2 - login_functions.inc.php
// This page defines two functions used by the login/logout process.
/* This function determines an absolute URL and redirects the user there.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */
function redirect_user($page = 'index.php') {
	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	// Add the page:
	$url .= '/' . $page;
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.
} // End of redirect_user() function.
/* This function validates the form data (the username and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
 
function check_login($dbc, $usern = '', $pass = ''){
		$errors = []; // Initialize error array.
	// Validate the Username:
//redirect_user('loggedin.php');
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
	if (empty($errors)) { // If everything's OK.
		
		// Retrieve the user_id and first_name for that username/password combination:
		$q = "SELECT userid, user FROM users WHERE user='$e' AND password=SHA1('$p')";
		$r = mysqli_query($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
			// Fetch the record:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			echo "Login successful!";
			// Return true and the record:
			return [true, $row];
		} else { // Not a match!
			$errors[] = 'The username and password entered do not match those on file.';
		}
	} // End of empty($errors) IF.
	// Return false and the errors:
	return [false, $errors];
}

// This function is similar as check_login, is used for validated the form data of registering form
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
              $q_getresult = "SELECT userid, user FROM users WHERE user='$e'";
              $r_getresult = mysqli_query($dbc, $q_getresult); // Run the query.
              $row = mysqli_fetch_array($r_getresult, MYSQLI_ASSOC);
              return [true, $row];
		    } else {
              $errors[] = 'Register fail!';
			  echo "Register fail!";
            } 
		}												// End of empty($errors) IF.
	}

	   // Return false and the errors:
	   return [false, $errors]; 
	}
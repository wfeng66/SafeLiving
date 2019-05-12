<?php # Script 12.1 - regist_page.inc.php
// This page prints any errors associated with register
// and it creates the entire register page, including the form.
// Include the header:

//include('includes/header.html');
// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br>';
	foreach ($errors as $msg) {
		echo " - $msg<br>\n";
	}
	echo '</p><p>Please try again.</p>';
}
// Display the form:
?>

<html>
<head>
<title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<body>
    <div class="loginbox">
    <img src="avatar.png" class="avatar">
        <h1>Organization Register</h1>
        <form action="regist.php" method="post">
            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <p>Email</p>
            <input type="email" name="email" placeholder="Enter Email">
            <input type="submit" name="submit" value="Register">
            <a href="login_t.php">Login</a><br>
        </form>
    </div>
</body>
</head>
</html>


<html>
<body>

<?php
// Prepare SQL server connectiion
define('DB_USER', 'wcf');
define('DB_PASSWORD', 'wcf');
define('DB_HOST', 'localhost');
define('DB_NAME', 'proj490');
// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );
// Set the encoding...
mysqli_set_charset($dbc, 'utf8');


?>

</body>
</html>

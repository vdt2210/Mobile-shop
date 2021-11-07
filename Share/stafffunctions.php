<?php
function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'mobileshop';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
// Template header, feel free to customize this
function template_header() {
echo <<<EOT
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mobile shop management</title>
        <link href="../Style/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../Style/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="../Style/css/staffstyles.css" rel="stylesheet" media="screen">
        <link href="../Style/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <main>
</main>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
<script src="../Style/js/staffsearch.js"></script>
<script src="script.js"></script>

</body>
</html>
EOT;
}
?>
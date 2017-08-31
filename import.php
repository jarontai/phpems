<?php
date_default_timezone_set('Asia/Shanghai');

require_once __DIR__ . '/vendor/autoload.php';

use M1\Env\Parser;

$env = Parser::parse(file_get_contents('.env'));
if (!$env) {
    exit('.env is missing or invalid, abort data import!');
}

// database file path
$filename = 'phpems.sql';
// MySQL host
$mysql_host = $env['DB_HOST'] ? $env['DB_HOST'] : 'localhost';
// MySQL username
$mysql_username = $env['DB_USER'] ? $env['DB_USER'] : 'root';
// MySQL password
$mysql_password = $env['DB_PWD'] ? $env['DB_PWD'] : 'roo';
// Database name
$mysql_database = $env['DB_NAME'] ? $env['DB_NAME'] : 'phpems';;
// Connect to MySQL server
$connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// 检查是否需要执行
$table = "x2_app";  
$result = mysqli_query($connection, "SHOW TABLES LIKE '" . $table . "'");
if ($result->num_rows > 0) {
    exit('No need to import, bye!');
}

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line) {
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
		continue;
	// Add this line to the current segment
	$templine .= $line;
	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';') {
		// Perform the query
		if(!mysqli_query($connection, $templine)){
			print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
		}
		// Reset temp variable to empty
		$templine = '';
	}
}
mysqli_close($connection);
echo "Database imported successfully";
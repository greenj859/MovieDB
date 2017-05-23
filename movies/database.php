<?php
//Database credentials
$host = 'localhost';
$name = 'movies';
$user = 'root';
$pass = '';
//Create mysqli object
$mysqli = new mysqli($host, $name);

//Error handler
if($mysqli->connect_error) {
	printf("Connection to db failed: %s\n", $mysqli->connect_error);
	exit();
}

class DBi {
    public static $conn;
}
DBi::$conn = new mysqli($host, $name);


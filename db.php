<?php

define('EMAIL', '');

define('PASSWORD', '');
/*
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'user-verification');*/


/*$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME)
*/


$connection = mysqli_connect('localhost', 'root', '','user-verification' );
	/*if(!$connection){

		echo 'Db not connected:'. mysqli_connect_error();

	}
	else{
		echo "connected";
	}*/

	if($connection->connect_error){
		die('Database error:' . $connection->connect_error);

	}
/*	else{
		die('connected');
	}*/


?>
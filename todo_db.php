<?php

	/*define('DB_HOST', 'localhost');
	define('DB_USER', 'roor');
	define('DB_PASS', '');
	define('DB_NAME', 'fproj');*/

	/*$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);*/
	$connection = mysqli_connect('localhost','root','','user-verification');

	if(!$connection){
		echo 'connection error:'. mysqli_connect_error();
	}


?>
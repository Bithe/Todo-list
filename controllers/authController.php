<?php

session_start();

// if user click on sign up button
require_once('db.php');
require_once 'emailController.php';
/*require_once ('emailController.php');*/

$errors 	= array();
$username 	="" ;
$email 		="" ;

if(isset($_POST['signup-btn'])){
	$username 			= $_POST['username'];
	$email 				= $_POST['email'];
	$password			= $_POST['password'];
	$confirmPassword	= $_POST['passwordConfirm'];

	//validation

	if(empty($username))
	{
		$errors['username'] = "Username Required";

	}

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors['email'] = "Email address is invalid";
	}
 

	if(empty($email)){
		$errors['email'] = "Email Required";

	} 

	if(empty($password)) {
		$errors['password'] = "Password Required";

	}

	if($password !== $confirmPassword){
		$errors['password'] = "The two password do not macth";

	}

	#unique email validation

	$emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
	$statement	= $connection->prepare($emailQuery);
	$statement->bind_param('s',$email);
	$statement->execute();
	$result		= $statement->get_result();
	$userCount	= $result->num_rows;
	$statement->close();

	if($userCount > 0){
		$errors['email'] = "Email already exits";

	}

	#check no error in the form

	if(count($errors) === 0){
		$password 	= password_hash($password, PASSWORD_DEFAULT);
		$token		= bin2hex(random_bytes(50)); // generated unique token for each user
		$verified	= false;

		$sql		= "INSERT INTO users (username, email, verified, token, password) VALUES(?, ?, ?, ?, ?) ";

		$statement	= $connection->prepare($sql);
		$statement->bind_param('ssbss', $username, $email, $verified, $token, $password);

		if($statement->execute()){
			//login user
			$user_id				 = $connection->insert_id;
			$_SESSION['id'] 		 = $user_id;
			$_SESSION['username']	 = $username;
			$_SESSION['email'] 		 = $email;
			$_SESSION['verified']	 = $verified;

			/*$insertTodo		= "INSERT INTO todo (user_id) VALUES ($user_id) ";
			$query = mysqli_query($connection, $insertTodo);*/

			sendVerificationEmail($email, $token);

			//flash message
			$_SESSION['message'] 	 = "You are now looged IN!";
			$_SESSION['alert-class'] = "alert-success";
			header('location: index.php');
			echo $token;
			exit();

		}
		


		else{
			$errors['db_error'] = "Database erros: Failed to register";
		}
	}

}

// if user clicks on the login button
if(isset($_POST['login-btn'])){
	$username 			= $_POST['username'];
	$password			= $_POST['password'];
	
	//validation

	if(empty($username))
	{
		$errors['username'] = "Username Required";

	}

	if(empty($password)) {
		$errors['password'] = "Password Required";

	}

	if(count($errors) === 0){

		$sql = "SELECT * FROM users WHERE email=? OR username =? LIMIT 1";
		$statement = $connection->prepare($sql);
		$statement->bind_param('ss', $username, $email);
		$statement->execute();
		$result = $statement->get_result();
		$user = $result->fetch_assoc();

		if(password_verify($password, $user['password'])){

		//login success
					//login user
			$_SESSION['id'] 		 = $user['id'];
			$_SESSION['username']	 = $user['username'];
			$_SESSION['email'] 		 = $user['email'];
			$_SESSION['verified']	 = $user['verified'];

			/*sendVerificationEmail($email, $token);*/

			//flash message
			$_SESSION['message'] 	 = "You are now looged IN!";
			$_SESSION['alert-class'] = "alert-success";
			header('location: todo_index.php');
			/*$query = "SELECT * FROM todo WHERE user_id=$user"*/
			
			exit();

		}

		else{
			$errors['login_fail'] = "Wrong credentials";
			}

	}

}

//logout 

if(isset($_GET['logout'])){
	session_destroy();
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['email']);
	unset($_SESSION['verified']);
	header('location:login.php');
	exit();
}

//verify user by token

function verifyUser($token){
	global $connection;

	$sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
	//echo $sql;
	$result = mysqli_query($connection, $sql);
	//print_r( $result);

	if(mysqli_num_rows($result) > 0){
		$user 			= mysqli_fetch_assoc($result);
		$update_query 	= "UPDATE users SET verified=1 WHERE token='$token' ";

		if(mysqli_query($connection, $update_query)){
			//login user in

			//login success
					//login user
			$_SESSION['id'] 		 = $user['id'];
			$_SESSION['username']	 = $user['username'];
			$_SESSION['email'] 		 = $user['email'];
			$_SESSION['verified']	 = 1;

			sendVerificationEmail($email, $token);

			//flash message
			/*$_SESSION['message'] 	 = "Your email is sucessfully verified!";
			$_SESSION['alert-class'] = "alert-success";*/
			header('location: index.php');
			exit();


		}
		else{
			echo "not verified";
		}
	}

}


//IF USER CLICK ON FORGOT PASSWORD BUTTON

if(isset($_POST['forgot-password'])){
	$email = $_POST['email'];

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors['email'] = "Email address is invalid";
	}
 

	if(empty($email)){
		$errors['email'] = "Email Required";

	} 
/*
	if (count($errors) == 0) {
		$sql = "SELECT * FROM users WHERE email=? LIMIT 1";
		$statement = $connection->prepare($sql);
		$statement->bind_param('s', $email);
		$statement->execute();
		$result = $statement->get_result();
		$user = $result->fetch_assoc();

		$token = $user['token'];
		sendPasswordResetLink($email, $token);
		header('location: password_message.php');
		exit(0);
	}*/

	if (count($errors) == 0) {

		
		$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result = mysqli_query($connection, $sql);

		$user = mysqli_fetch_assoc($result);

		  $token = $user['token'];
		sendPasswordResetLink($email, $token);
		header('location: password_message.php');
		exit(0);
	}

}

// if user clicked on the reset password button
if(isset($_POST['reset-password-btn'])){
	$password 		= $_POST['password'];
	$confirmPass 	= $_POST['confirmPass'];

	if(empty($password) || empty($confirmPass)) {
		$errors['password'] = "Password Required";

	}

	if($password != $confirmPass){
		$errors['password'] = "The two password do not macth";

	}

	$password 	= password_hash($password, PASSWORD_DEFAULT);
	$email 		= $_SESSION['email'];

	if (count($errors) == 0) {
		$sql = "UPDATE users SET password='$password' WHERE email='$email' ";
		$result = mysqli_query($connection, $sql);
		if($result){
			header('location: login.php');
			exit(0);
		}	


	}

}

function resetPassword($token){
	global $connection;
	$sql 				= "SELECT * FROM users WHERE token='$token' LIMIT 1";
	$result 			= mysqli_query($connection, $sql);
	$user 				= mysqli_fetch_assoc($result);
	$_SESSION['email']  = $user['email'];
	header('location: reset_password.php');
	exit(0);


}


?>
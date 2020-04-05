<?php


	require_once 'controllers/authController.php';
	

	//verify the user using token


	if(isset($_GET['password-token'])){
		$password_token = $_GET['password-token'];
		resetPassword($password_token);

		}



	if(isset($_GET['token'])){
		$token = $_GET['token'];
		verifyUser($token);

	}

	if(!isset($_SESSION['id'])){
		header('location:login.php');
		exit();
	}	

	

?>



<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4 form-div login">

				<!-- <div class="alert alert-success"> -->
				<?php if(isset($_SESSION['message'])): ?>
					<div class="alert <?php echo $_SESSION['alert-class']; ?> ">

						<?php 
							echo $_SESSION['message'];
							unset($_SESSION['message']);
							unset($_SESSION['alert-class']);
						 ?>
					</div>
				<?php endif; ?>
			

				 <h3>Welcome, <?php echo $_SESSION['username']; ?>  </h3>

				<a href="index.php?logout=1" class="logout">Logout</a>
				<!--<a href="todo_index.php" class="logout">Go to todo list</a> -->

				<?php  if(!$_SESSION['verified']): ?>

					<div class="alert alert-warning">
						You need to verify your account. Sign in to your email account and click on the varification link we just emailed you at 
					<!-- <strong>b@gmail.com</strong> -->

						<strong> <?php echo $_SESSION['email']; ?> </strong>					
					</div>
				<?php endif;  ?>

				<?php if($_SESSION['verified']): ?>
					<button class="btn btn-block btn-lg btn-primary">I am verified!</button>
				<?php endif; ?>


			</div>
		</div>
	</div>

	


</body>
</html>
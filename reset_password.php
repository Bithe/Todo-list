<?php

	require_once '..controllers/authController.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4 form-div login">
				<form action="reset_password.php" method="POST">
					<h3 class="text-center">Reset Password</h3>

					<?php if(count($errors) > 0 ):  ?>

						<div class="alert alert-danger">
							<?php  foreach ($errors as $error):  ?>
							<!-- <li>Username Required</li>		 -->
							<li><?php echo $error;  ?></li>

							<?php  endforeach; ?>	
						</div>

					<?php endif;  ?>	

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" class="form-control form-control-lg">
					</div>	

					<div class="form-group">
						<label for="confirmPass">Confirm Password</label>
						<input type="password" name="confirmPass" class="form-control form-control-lg">
					</div>	

					<div class="form-group">
						<button type="submit" name="reset-password-btn" class="btn btn-primary btn-block btn-lg">Reset Password</button>
					</div>	

					
				
						
					</div>

				</form>	
			</div>
		</div>
	</div>


</body>
</html>


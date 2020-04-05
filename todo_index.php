<?php

	include "todo_db.php";
	require_once 'controllers/authController.php';

	if(isset($_GET['token'])){
		$token = $_GET['token'];
		verifyUser($token);

	}

	if(!isset($_SESSION['id'])){
		header('location:login.php');
		exit();
	}	


	/*$_SESSION['id'] 		 = $user['id'];
	echo $_SESSION['id'];*/	
	$id = $_SESSION['id'];
	
	echo  $id;

	$query = "SELECT * FROM todo";
	$result = mysqli_query($connection, $query);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			/*echo "received";*/
			$todo = $_POST['todo'];
			date_default_timezone_set("Asia/Dhaka");
			/*$date = date("Y-m-d h:i:sa");*/
			$date = date("l jS \of F Y h:i:s A");
			/*$date = date('l dS F\, Y');*/

			/*echo $todo;*/
			/*echo $date;*/

			if(empty($todo)){
				$error = "Field is required";
			}

			else{
				$sql = "INSERT INTO todo(name,date_time,user_id) VALUES('$todo', '$date','$id');";

				$results = mysqli_query($connection,$sql);

					if(!$results){
						die("failed");
					}
					else{
						header("Location:todo_index.php?todo-added");
					}				
				}
		}

		if(isset($_GET['delete_todo'])){
			$dlt_todo = $_GET['delete_todo'];
			/*echo $dlt_todo;*/
			/*$sqli = " SET @count =0',
			DELETE FROM todo WHERE id= $dlt_todo AND
			UPDATE todo SET id=@count:= count+1 AND
			ALTER TABLE todo AUTO_INCREMENT =1 ";*/

			$sqli ="DELETE FROM todo WHERE id= $dlt_todo;";

			$deleteSqlres = mysqli_query($connection,$sqli);
				if(!$dlt_todo){
					die("not deleted");
				}else{
					header("Location:todo_index.php?deleted");
				}

		}

?>



<!DOCTYPE html>
<html>
<head>
	<title>ToDo List App</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.todo{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			border-radius: 3px;
			border: 1px solid #cccccc;
			margin-top: 5px;
		}

		.search{
			margin: 5px;
		}

		.fa-sign-out{
			
			align-self:flex-end;
			/*position: fixed;*/
			/*align-self:flex-end;*/
			right: 150px;
			top:30px;
			font-size: 20px;
			

		}	



	</style>
</head>

<body>
	<?php  if(!$_SESSION['verified']): ?>

					<div class="alert alert-warning">
						You need to verify your account. Sign in to your email account and click on the varification link we just emailed you at 
					<!-- <strong>b@gmail.com</strong> -->

						<strong> <?php echo $_SESSION['email']; ?> </strong>					
					</div>
				<?php endif;  ?>
	<div class="container">

		<div class="todo">
			<a href="index.php?logout=1" class="fa fa-sign-out">Logout</a>
			<h1>TODO List App</h1>
			<h3>Add a new TODO</h3>

				<?php
					if(isset($error)){
						echo "<div class='alert alert-danger'>$error
						</div>";
					}
				?>

				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

					<div class="form-group">
						<input class="form-control" type="text" name="todo" placeholder="Todo Name">					
					</div>

					<div class="form-group">
						<input class="btn btn-primary" value="Add a new todo task List" type="submit">					
					</div>
					
				</form>
		</div>

		<div class="col-lg-4 search">
			<form action="search.php" method="POST">
				<input class="form-control" type="text" name="search" placeholder="Search Todo">				
			</form>			
		</div>

		<div class="table-responsive col-lg-12">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<th>ID</th>
					<th>Todo</th>
					<th>Date Added</th>
					<th>Edit Todo</th>
					<th>Delete Todo</th>
				</thead>

				<tbody>
					<?php
						$i=0;
						$sql = "SELECT * FROM todo WHERE user_id = $id";
						$results = mysqli_query($connection,$sql);
						while($row = mysqli_fetch_assoc($results)) {
							$id 	= $row['id'];
							$name 	= $row['name'];
							$date 	= $row['date_time'];
							$i++;
							# code...
					?>

						<tr>
							<td> <?php echo $i; ?> </td>
							<td> <?php echo $name; ?> </td>
							<td> <?php echo $date; ?></td>
							<td> <a href="edit.php?edit-todo=<?php echo $id; ?>" class="btn btn-primary">Edit Todo</a> </td>
							<td> <a href="todo_index.php?delete_todo=<?php echo $id; ?>" class="btn btn-danger">Delete Todo</a></td>
						</tr>
						

					<?php

						}

					?>					
				</tbody>
				
			</table>
		</div>
	</div>


</body>
</html>
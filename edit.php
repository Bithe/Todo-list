<?php
	include "todo_db.php";

	if(isset($_GET['edit-todo'])){
		/*echo "okay";*/
		$e_id = $_GET['edit-todo'];
	}

	if(isset($_POST['edit_submit'])){
		$edit_submit = $_POST['todo'];

		$query = "UPDATE todo SET name = '$edit_submit' WHERE id = $e_id ";
		$run = mysqli_query($connection, $query);

			if(!$run){
				die("not updated");
			}else{
				header("Location: todo_index.php?Updated");
			}
	}

	
?>



<!DOCTYPE html>
<html>
<head>
	<title>ToDo List App</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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
		
	</style>
</head>
<body>
	<div class="container">

		<div class="todo">
			<h1>TODO List App</h1>
			<h3>Add a new TODO</h3>

				<form action="" method="POST">

					<?php
					$sql = "SELECT * FROM todo WHERE id = $e_id";
					$result = mysqli_query($connection, $sql);
					$data = mysqli_fetch_array($result);



					?>

					<div class="form-group">
						<input class="form-control" type="text" name="todo" placeholder="Todo Name" value="<?php echo $data['name']; ?>">					
					</div>

					<div class="form-group">
						<input class="btn btn-primary" value="Add a new todo task List" type="submit" name="edit_submit">					
					</div>
					
				</form>
		</div>

	</div>


</body>
</html>
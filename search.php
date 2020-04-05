<?php
	include "todo_db.php";

	if(isset($_POST['search'])){
		$search = $_POST['search'];
		$query = "SELECT * from todo WHERE name LIKE '%$search%'";
		$result = mysqli_query($connection, $query);
		/*print_r($result);*/

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

		.search{
			margin: 5px;
		}		
	</style>
</head>

<body>
	<div class="container">

		<div class="todo">
			<h1><a href="index.php">Go To Home page(Todo List)</a></h1>
			<h3>Search List of Todo</h3>
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
							if(mysqli_num_rows($result) ===0 ){
								echo "<tr>";
									echo "<td></td>";
									echo "<td>Not Found</td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								echo "</tr>";
							}

							else{				
								$i=0;
								while($row = mysqli_fetch_assoc($result)) {
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
				}

					?>					
				</tbody>
				
			</table>
		</div>
	</div>


</body>
</html>
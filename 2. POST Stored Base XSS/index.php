<?php
define("LOCAL", true);
include_once(dirname(__DIR__) . "/core/connection.php");

if(isset($_POST["name"], $_POST["email"], $_POST["description"])){
	$name = $_POST["name"];
	$email = $_POST["email"];
	$description = base64_encode($_POST["description"]);
	
	$q = mysqli_query($conn, "INSERT INTO users (name, email, password, picture, description) VALUES ('$name', '$email', '', '', '$description')");
	
	header("index.php?message=New user information has been saved!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Level 2 - POST Stored Base XSS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
	<div class="row">
		<div class="col-md-12">
		<?php
			if(isset($_GET["message"])){
			?>
			<div class="alert alert-success">
				<strong>Completed!</strong> <?= $_GET["message"] ?></a>.
			</div>
			<?php
			}
		?>
			<div class="card mb-5">
				<div class="card-body">
					<h4>Add User</h4>
					
					<form action="" method="POST">
						Name:
						<input type="text" class="form-control" name="name" placeholder="Name" /><br />
						
						Email:
						<input type="text" class="form-control" name="email" placeholder="Email" /><br />
						
						Description:
						<textarea class="form-control" name="description" placeholder="Describe this user"></textarea><br />
						
						<button class="btn btn-success" type="submit">
							Save
						</button>
					</form>
				</div>
			</div>
			
			<h4>List User</h4>			
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Description</th>
					</tr>
				</thead>
				
				<tbody>
				<?php
					$q = mysqli_query($conn, "SELECT * FROM users");
					
					$no = 1;
					while($r = mysqli_fetch_objecT($q)){
					?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= $r->name ?></td>
						<td><?= $r->email ?></td>
						<td><?= base64_decode($r->description) ?></td>
					</tr>
					<?php
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>

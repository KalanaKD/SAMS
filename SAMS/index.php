<!DOCTYPE html>
<html>

<head>
	<title>Student Attendance Management System - Login</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #2D2D2D;
		}

		.container {
			width: 400px;
			margin: 100px auto;
			background-color: #3C3F41;
			border-radius: 10px;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);		
			font-family: Arial, sans-serif;
			font-size: 16px;
			line-height: 1.5;
			letter-spacing: 0.5px;
			color: white;
		}

		h1 {
			text-align: center;
		}

		form {
			margin-top: 20px;
			margin-bottom: 20px;
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			box-sizing: border-box;
		}

		input[type="submit"] {
			background-color: #7289da;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			font-size: 16px;
			font-family: Arial, Helvetica, sans-serif;
			margin-top: 20px;
			margin-left: 150px;
			cursor: pointer;
			border-radius: 10px;
			transition: 0.3s;
		}

		input[type="submit"]:hover {
			background-color: #677bc4;
		}

		.error {
			color: red;
			margin-top: 10px;
		}

		input[type="text"]:focus,
		input[type="password"]:focus {
			outline: none;
			border-color: lightblue;
			box-shadow: 0 0 5px lightblue;
		}
		.href{
			color:red;
		}
	</style>
</head>

<body>
	<?php require_once('inc/connection.php'); ?>

	<?php
	if (isset($_POST['login'])) {

		$Pword = $_POST['pw'];
		$Email = $_POST['email'];

		// Sanitize user input and prevent SQL injection
		$Pword = mysqli_real_escape_string($connection, $Pword);
		$Email = mysqli_real_escape_string($connection, $Email);

		$query = "SELECT `user_id`, `role`,`status` FROM `user` WHERE `email`='$Email' AND `password`='$Pword'";

		$result = mysqli_query($connection, $query);

		if ($result) {
			if (mysqli_num_rows($result) == 1) {
				$record = mysqli_fetch_assoc($result);
				$role = $record['role'];
				$u_id = $record['user_id'];
				$status = $record['status'];

				switch ($status) {
					case 'active':
						switch ($role) {
							case 'student':
								$loc = "inc/student/student.php?user_id=" . $u_id;
								header("Location: $loc");
								exit();
								break;
							case 'lecture':
								$loc = "inc/lecture/lecture.php?user_id=" . $u_id;
								header("Location: $loc");
								exit();
								break;
							case 'management assistant':
								$loc = "inc/MA/MA.php?user_id=" . $u_id;
								header("Location: $loc");
								exit();
								break;
						}
						break;

					default:
						$error = "Error in registration!";
						break;
				}
			} else {
				$error = "Error in role";
			}
		} else {
			$error = "Error: " . mysqli_error($connection);
		}
	}
	?>
	<div class="container">
		<h1>Student Attendance Management System</h1>
		<hr>
		<form action="index.php" method="Post">
			Email: <input type="text" name="email"
			placeholder="email@example.com" required><br>
			Password: <input type="password" name="pw" placeholder="********" required><br>
			<span class="error">
				<?php 
					if (isset($error)) {
							echo $error;
					} 
				?>
			</span><br>
			No account? <a href="inc/register_page.php" class="href">Create New Account.</a><br>
			<input type="submit" name="login" value="Log in">
		</form>
	</div>
</body>

</html>
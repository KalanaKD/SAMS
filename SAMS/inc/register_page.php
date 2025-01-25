<?php 
    require_once('connection.php');

    $passwordMismatch = false; // Flag to track password mismatch

    if(isset($_POST['register'])){

        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['pw']);
        $confirmPassword = mysqli_real_escape_string($connection, $_POST['pw2']);
        $role='student';
        $status='pending';

        // Check if passwords match
        if($password !== $confirmPassword) {
            $passwordMismatch = true;
        } else { 

            // Build the SQL query with proper quoting
            $query = "INSERT INTO `user`(`email`, `password`,role,status) VALUES ('$email', '$password', '$role', '$status')";

            $result = mysqli_query($connection, $query);

            if($result){
                $query="SELECT `user_id` FROM `user` WHERE `email`='$email' AND `password`='$password'";
                $result = mysqli_query($connection, $query);
                if($result){
                    $rec=mysqli_fetch_assoc($result);
                    $user_id=$rec['user_id'];
                }
                header("Location: register_details.php?user_id=$user_id");
            } else {
                echo "Error";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>register page</title>
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
        form {
			margin-top: 20px;
			margin-bottom: 20px;
		}
        input[type="text"], input[type="password"] {
			width: 90%;
			padding: 10px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			box-sizing: border-box;
            display: block;
		}
		input[type="submit"] {
			background-color:#7289da;
    		border: none; 
    		color: white; 
    		padding: 15px 32px;
    		text-align: center;
    		font-size: 16px;
			font-family:Arial, Helvetica, sans-serif;
			margin-top: 20px;
    		margin-left: 150px;
    		cursor: pointer;
			border-radius:10px ;
		}
        input[type="submit"]:hover{
            background-color: #677bc4;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: lightblue;
            box-shadow: 0 0 5px lightblue;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Student Attendance Management System</h1> <hr>
    <form action="register_page.php" method="post">
        Email <input type="text" name="email" required><br>
        Password <input type="password" name="pw" required><br>
        Confirm password <input type="password" name="pw2" required><br>
        <?php 
            if ($passwordMismatch) {
                echo "Passwords do not match. Please try again.";
            }
        ?><br>
        <br>

        Already a member? <a href="../index.php" style="color:red">Log in</a>
        <input type="submit" name="register" value="Register">
    </form>
    </div>
</body>
</html>

<?php mysqli_close($connection); ?>

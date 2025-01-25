<?php require_once('../connection.php'); ?>

<?php

$passwordMismatch = false; // Flag to track password mismatch
if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
  $user_id = $_POST['user_id'];
}

if (isset($_POST['change'])) {
  $password = mysqli_real_escape_string($connection, $_POST['pw']);
  $confirmPassword = mysqli_real_escape_string($connection, $_POST['pw2']);

  // Check if passwords match
  if ($password !== $confirmPassword) {
    $passwordMismatch = true;
  } else {

    // Build the SQL query with proper quoting
    $query = "UPDATE `user` SET `password`='$password' WHERE `user_id`='$user_id';";

    $result = mysqli_query($connection, $query);

    if ($result) {
      echo "Password changing is sucssesfull.";
    } else {
      echo "Error";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Reset Password</title>
  <style>
    body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #2D2D2D;
      color:white;
		}
    h1{
      text-align: center;
    }
    .container {
            width: 50%;
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
      input[type="text"], input[type="submit"] ,input[type="password"]{
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
      }
      input[type="submit"] {
            background-color: #7289da;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px; 
            border-radius: 5px;
            transition: 0.5s;
            width:30%;
            margin-left: 200px;
      }
      input[type="submit"]:hover {
            background-color: #677ab6;
      }
  </style>
</head>

<body>
  <div class="container">
    <h1>Reset Password</h1>
    <hr>
    <form action="reset.php" method="post">
      New Password <input type="password" name="pw" required><br>
      Confirm password <input type="password" name="pw2" required><br>
      <?php
      if ($passwordMismatch) {
        echo "Passwords do not match. Please try again.";
      }
      ?><br>
      <br>
      <input type="hidden" name="user_id" value='<?php echo "$user_id"?>'>
      <input type="submit" name="change" value="change">
    </form>

    <form action="lecture.php" method="post">
      <input type="hidden" name='user_id' value="<?php echo "$user_id"?>">
      <input type="submit" name="back" value="back">
    </form>
  </div>




</body>

</html>
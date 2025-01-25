<?php require_once('../connection.php'); ?><br>

<?php 
	if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
		echo "get" . "$user_id";
	} elseif (isset($_POST['user_id'])) {
		$user_id = $_POST['user_id'];
		echo "post" . "$user_id";
	}
	$passwordMismatch = false;
	$oldpasswordMismatch=false;
		 
	$u_id= mysqli_real_escape_string($connection, $u_id);

	$query = "SELECT `password`,`first_name`, `middle_name`, `last_name` FROM `user` WHERE `user_id` = $u_id";

	$record=mysqli_query($connection,$query);

	if($record){
		$result=mysqli_fetch_assoc($record);
		$name = $result['first_name']." ".$result['middle_name']." ".$result['last_name'];
		$old_pw=$result['password'];
	}else{
		echo "Error in database";
	}

	if(isset($_POST['reset'])){
		$old_password= mysqli_real_escape_string($connection, $_POST['old_password']);
		$new_password = mysqli_real_escape_string($connection, $_POST['new_pw']);
        $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_new_pw']);

        if($old_password !==$old_pw){
        	$oldpasswordMismatch =true;
        }else{
        	if($new_password !== $confirm_password){
        		$passwordMismatch =true;
        	}else{
        		$query ="UPDATE `user` SET `password`='$new_password'WHERE `user_id`='$u_id' ";
        		$result = mysqli_query($connection, $query);

            	if($result){
            		echo "<p style=\"color:white\">Password reset successfull</p>";
            	} else {
                	echo "Error";
            	}
        	}
        }
	}else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedOption = $_POST['wh'];

        switch($selectedOption) {
            case "reset":
                header("Location: ../../index.php");
                break;
            case "dashboard":
                $loc="student.php?user_id=".$u_id;
                header("Location: $loc");
                exit();
            case "logout":
                header("Location: ../../index.php");
                break;
            default:
                break;
        }
    }
    }
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
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
        
        h1, hr {
            margin: 10px 0;
        }
        select, input[type="password"], input[type="submit"] {
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
        }
        input[type="submit"]:hover {
            background-color: #677bc4;
        }
        select::placeholder {
            color: rgb(178,190,181); 
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
        <form method="post">
            <select name="wh" onchange="this.form.submit()" placeholder="Select Action">
                <option value="" disabled selected hidden>Select</option>
                <option value="reset" >Password Reset</option>
                <option value="dashboard">Dashboard</option>
                <option value="logout">Log Out</option>
            </select>
        </form>
        
        <h1 style="text-align:center;">Student Attendance Management System</h1>
        <hr>

        <p style="text-align:center;"><strong> Welcome: <?php echo $name; ?></strong></p>
        <hr>

        <h2 style="text-align:center;">Password Reset</h2>
        <?php $loc="reset_pw.php?user_id=".$u_id; ?>
        <form action="<?php echo $loc; ?>" method="post">
            <label for="old_password">Current Password</label>
            <input type="password" name="old_password">
            <?php 
                if ($oldpasswordMismatch) {
                    echo "Old Passwords do not match. Please try again.";
                }
            ?>
            <br>
            <label for="new_pw">New Password</label>
            <input type="password" name="new_pw"><br>
            <label for="confirm_new_pw">Confirm Password</label>
            <input type="password" name="confirm_new_pw">
            <?php 
                if ($passwordMismatch) {
                    echo "Passwords do not match. Please try again.";
                }
            ?>
            <br>
            <input type="submit" name="reset" value="Reset">
        </form>
        <hr>
    </div>
</body>
</html>




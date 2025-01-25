<?php 
    require_once('connection.php');
    $user_id=$_GET['user_id'];

    if(isset($_POST['ok'])){

        $fname = mysqli_real_escape_string($connection, $_POST['Fname']);
        $mname = mysqli_real_escape_string($connection, $_POST['Mname']);
        $lname = mysqli_real_escape_string($connection, $_POST['Lname']);
        $level = mysqli_real_escape_string($connection, $_POST['level']);
        $batch_no = mysqli_real_escape_string($connection, $_POST['batch_no']);
        
        // $academic_year = mysqli_real_escape_string($connection, $_POST['academic_year']);
        $reg_no = mysqli_real_escape_string($connection, $_POST['reg_no']);
        $index_no = mysqli_real_escape_string($connection, $_POST['index_no']);

        $user_query="UPDATE `user` SET `first_name`='$fname' ,`middle_name`='$mname', `last_name`='$lname' WHERE `user_id`='$user_id' ";
        $user_result = mysqli_query($connection, $user_query);
        // $user_row = mysqli_fetch_array($user_result);

        $st_query="INSERT INTO `student`(`student_id`, `index_no`, `reg_no`, `batch_no`, `current_level`) VALUES ('$user_id','$index_no','$reg_no','$batch_no','$level')";
        $st_result=mysqli_query($connection,$st_query);
        // $st_row=mysqli_fetch_array($st_result);




        $loc = "ma_request.php?";
        $loc .= "Fname=" . $fname;
        $loc .= "&Mname=" . $mname;
        $loc .= "&Lname=" . $lname;
        $loc .= "&level=" . $level;
        $loc .= "&batch_no=" . $batch_no;
        $loc .= "&reg_no=" . $reg_no;
        $loc .= "&index_no=" . $index_no;

        header("Location: $loc");

    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #2D2D2D;
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
        lec-table{
            align-items: center;
            text-align: center;
        }
        h1, hr {
            margin: 20px 0; 
            text-align: center;
        }
        
        input[type="text"], input[type="submit"] {
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
            background-color: #677bc4;
        }
        a {
            text-decoration: none;
            color: #0056b3;
            margin-top: 10px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
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
        <h1>Student Attendance Management System</h1>
        <hr>
            <form action="register_details.php?user_id=<?php echo $user_id?>" method="post" >
                <label for="Fname">First Name</label>
                <input type="text" name="Fname" required><br>
                <label for="Mname">Middle Name</label>
                <input type="text" name="Mname" required><br>
                <label for="Lname">Last Name</label>
                <input type="text" name="Lname" required><br>
                <label for="level">Current Level</label>
                <input type="text" name="level" required><br>
                <label for="batch_no">Batch No</label>
                <input type="text" name="batch_no" required><br>
                <label for="reg_no">Registration No</label>
                <input type="text" name="reg_no" required><br>
                <label for="index_no">Index No</label>
                <input type="text" name="index_no" required><br>

                <a href="../index.php" style="color:red">Already a member? Log in</a>
                <br><br>
                <input type="submit" name="ok" value="OK">
            </form>
    </div>
    
</body>
</html>

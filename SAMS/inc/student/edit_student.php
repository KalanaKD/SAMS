<?php require_once('../connection.php'); ?>

<?php 
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } 
    elseif (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    }

        $user_id = mysqli_real_escape_string($connection, $user_id);

        // Fetch user details
        $query = "SELECT `email`, `first_name`, `middle_name`, `last_name` FROM `user` WHERE `user_id` = $user_id";
        $record = mysqli_query($connection, $query);

        if ($record) {
            $result = mysqli_fetch_assoc($record);
            $name = $result['first_name'] . " " . $result['middle_name'] . " " . $result['last_name'];
            $email = $result['email'];
        } else {
            echo "Error in database";
        }

        // Fetch student details
        $query = "SELECT `current_level`, `batch_no`, `reg_no`, `index_no` FROM `student` WHERE `student_id` = $user_id";
        $record2 = mysqli_query($connection, $query);

        if ($record2) {
            $result = mysqli_fetch_assoc($record2);
            $current_level = $result['current_level'];
            $batch_no = $result['batch_no'];
            $reg_no = $result['reg_no'];
            $index_no = $result['index_no'];
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2c2f33; /* Dark background color */
            color: white; 
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .header {
            width: 60%;
            background-color: #36393f; /* Dark header background color */
            padding: 20px 0;
            border: none;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-weight: bold;
            font-size: 24px;
            color: #fff; /* White text color */
            margin: 0;
        }

        .user-info {
            width: 60%;
            background-color: #36393f; /* Dark container background color */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align:center;
            margin-top: 20px;
        }

        .welcome {
            font-weight: bold;
            font-size: 18px;
            color: #fff; /* White text color */
            margin-bottom: 20px;
        }

        .details {
            font-weight: bold;
            font-size: 16px;
            color: #72767d; /* Telegram's accent color */
        }

        .sub {
            background-color: green;
            border: none;
            color: #fff; /* White text color */
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            cursor: pointer;
            border-radius: 10px;
            margin-top: 20px;
        }

        .sub:hover {
            background-color: darkgreen;
        }
        input[type="text"],input[type="email"]{
            border: none;
            color: #fff; /* White text color */
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            cursor: pointer;
            border-radius: 8px;
            background-color: #2c2f33;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1>Welcome: <?php echo $name; ?></h1>
        </div>
        <div class="user-info">
            <div class="details">
                <form action="edit_student.php" method="post">
                <label for="email">Email: <?php echo $email; ?></label><br><br>
                    <label for="current-level">Current Level:</label>
                    <input type="text" id="level" name="cur-level" value="<?php echo $current_level; ?>" required><br>
                    <label for="Batch-No">Batch-No:</label>
                    <input type="text" id="BNo" name="Batch-No" value="<?php echo $batch_no; ?>" required><br>
                    <label for="Registration-No">Registration-No:</label>
                    <input type="text" id="RegNo" name="RegNo" value="<?php echo $reg_no; ?>" required><br>
                    <label for="Index-No">Index-No:</label>
                    <input type="text" id="INo" name="Index-No" value="<?php echo $index_no; ?>" required><br>
                
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="submit" name="submit" value="Update" class="sub">
                </form>
            </div>
        <?php

            if(isset($_POST['submit'])){
                $cur_lev = mysqli_real_escape_string($connection,$_POST['cur-level']);
                $Bt_no = mysqli_real_escape_string($connection,$_POST['Batch-No']);
                $RegNo = mysqli_real_escape_string($connection,$_POST['RegNo']);
                $Ind_no = mysqli_real_escape_string($connection,$_POST['Index-No']);
                $user_id = $_POST['user_id'];

                $query = "UPDATE student SET `index_no`='$Ind_no', `reg_no`='$RegNo', `batch_no`='$Bt_no' ,`current_level`='$cur_lev' WHERE `student_id`='$user_id'";
                $result = mysqli_query($connection, $query);

                // Check if the query executed successfully
                if($result){
                    // Redirect to course_list.php with year and sem parameters
                    header("Location: student.php?user_id=$user_id");
                    exit(); // Stop further execution
                } else {
                    // Display error message if query fails
                    echo "Error: " . mysqli_error($connection);
                }

            }

        ?>

            
</body>
</html>

<?php 
    require_once('../connection.php');
    if (isset($_GET['u_id'])) {
        $u_id = $_GET['u_id'];
    }
    if (isset($_POST['u_id'])) {
        $u_id = $_POST['u_id'];
    }
    echo "$u_id";

    if(isset($_POST['update'])){
        // Retrieve user_id and other form data
        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $profession = $_POST['profession'];

        // Update user table
        $user_update_query = "UPDATE `user` SET `first_name`='$first_name', `middle_name`='$middle_name', `last_name`='$last_name', `email`='$email' WHERE `user_id`='$user_id'";
        $user_update_result = mysqli_query($connection, $user_update_query);

        // Update lecture table
        $lecture_update_query = "UPDATE `lecture` SET `profession`='$profession' WHERE `lecture_id`='$user_id'";
        $lecture_update_result = mysqli_query($connection, $lecture_update_query);

        // Check if both updates were successful
        if($user_update_result && $lecture_update_result) {
            header("Location: lecture_list.php?user_id=$u_id");
        } else {
            echo "Error updating lecturer details.";
        }
    }

    // Check if user_id is set
    if(isset($_GET['lec_id'])) {
        $user_id = $_GET['lec_id'];

        // Query to fetch user details from the user table
        $user_query = "SELECT `first_name`, `middle_name`, `last_name`, `email` FROM `user` WHERE `user_id`='$user_id'";
        $user_record = mysqli_query($connection, $user_query);

        // Query to fetch lecturer details from the lecture table
        $lecturer_query = "SELECT `profession` FROM `lecture` WHERE `lecture_id`='$user_id'";
        $lecturer_record = mysqli_query($connection, $lecturer_query);

        // Check if both queries were successful
        if($user_record && $lecturer_record) {
            // Fetch user details
            $user_details = mysqli_fetch_assoc($user_record);

            // Fetch lecturer details
            $lecturer_details = mysqli_fetch_assoc($lecturer_record);
        } else {
            echo "Error fetching data from database.";
            exit();
        }
    } else {
        echo "User ID not provided.";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Lecturer Details</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2D2D2D;
            color: #D1D1D1;
            /* Set text color to light gray */
        }

        h1 {
            text-align: center;
            color: #D1D1D1;
            /* Set heading color to light gray */
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #3C3F41;
            /* Set container background color to a lighter dark gray */
            border: 1px solid #444;
            /* Add a dark gray border */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            /* Add a subtle shadow */
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #666;
            /* Set select border color to medium gray */
            border-radius: 4px;
            background-color: #3C3F41;
            color: #D1D1D1;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #666;
            /* Set input border color to medium gray */
            border-radius: 4px;
            cursor: pointer;
            width: 95%;
            background-color: #3C3F41;
            /* Set input background color to dark gray */
            color: #D1D1D1;
            /* Set input text color to light gray */
            margin-bottom: 10px;
        }

        input[type="submit"],
        input[type="button"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            /* Set button background color to green */
            color: #fff;
            /* Set button text color to white */
            cursor: pointer;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #3e8e41;
            /* Darken button background color on hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #555;
            /* Set table border color to medium gray */
            text-align: left;
            color: #D1D1D1;
        }

        th {
            background-color: #3C3F41;
            /* Set table header background color to a lighter dark gray */
        }

        tr:nth-child(even) {
            background-color: #333;
            /* Set even row background color to a medium dark gray */
        }

        tr:hover {
            background-color: #3C3F41;
            /* Lighten row background color on hover */
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            /* Set link color to green */
        }

        a:hover {
            color: #3e8e41;
            /* Darken link color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Edit Lecturer Details</h1>
    <form action="lecture_edit.php?&u_id=<?php echo $u_id;?>" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $user_details['first_name']; ?>"><br>
        
        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name" value="<?php echo $user_details['middle_name']; ?>"><br>
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $user_details['last_name']; ?>"><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user_details['email']; ?>"><br>
        
        <label for="profession">Profession:</label>
        <input type="text" id="profession" name="profession" value="<?php echo $lecturer_details['profession']; ?>"><br>

        <div style="display: flex; justify-content: space-between; align-items: center;">

                <input style="width: 100px;" type="submit" name="update" value="Update">
        </form>

        <!-- Cancel button to go back to course_list.php -->
        <form action="lecture_list.php?user_id=<?php echo $u_id; ?>" method="post"> <!-- Pass year and sem back to course_list.php -->
            <input style="width: 100px;background-color: red; color: white;"  type="submit" name="cancel" value="Cancel">
        </form>
    </div>
    </div>
        
</body>
</html>


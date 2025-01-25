<?php
require_once('../connection.php');
if (isset($_GET['user_id'])) {
    $u_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
    $u_id = $_POST['user_id'];
}
echo "$u_id";
$passwordMismatch = false;

if (isset($_POST['add_lec'])) {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $profession = $_POST['profession'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $passwordMismatch = true;
    } else {
        // Hash the password


        // Insert lecturer details into user table
        $user_insert_query = "INSERT INTO `user` (`first_name`, `middle_name`, `last_name`, `email`, `password`, `role`) VALUES ('$first_name', '$middle_name', '$last_name', '$email', '$password', 'lecture')";
        $user_insert_result = mysqli_query($connection, $user_insert_query);

        // Get the user_id of the newly inserted lecturer
        $user_id = mysqli_insert_id($connection);

        // Insert lecturer's profession into lecture table
        $lecture_insert_query = "INSERT INTO `lecture` (`lecture_id`, `profession`) VALUES ('$user_id', '$profession')";
        $lecture_insert_result = mysqli_query($connection, $lecture_insert_query);

        // Check if both insertions were successful
        if ($user_insert_result && $lecture_insert_result) {
            header("Location: lecture_list.php?user_id=$u_id");
        } else {
            echo "Error adding lecturer.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Lecturer</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            letter-spacing: 0.5px;
            color: #D1D1D1;
            /* Set text color to light gray */
            margin: 0;
            padding: 0;
            background-color: #3C3F41;
            /* Set body background color to dark gray */
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #3C3F41;
            /* Set container background color to dark gray */
            border: 1px solid #444;
            /* Add a dark gray border */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            /* Add a subtle shadow */
            color: #D1D1D1;
            /* Set text color to light gray */
        }

        h1 {
            margin-top: 0;
            font-size: 24px;
        }

        hr {
            border: none;
            border-top: 1px solid #555;
            /* Set horizontal rule color to medium gray */
            margin: 20px 0;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        select {
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

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            /* Set button background color to green */
            color: #fff;
            /* Set button text color to white */
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
            /* Darken button background color on hover */
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

        label {
            display: block;
            margin-bottom: 5px;
            color: #D1D1D1;
            /* Set label color to light gray */
        }

        .button-close {
            text-align: center;
            margin-top: 20px;
        }

        .button-close input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f44336;
            /* Set button background color to red */
            color: #fff;
            /* Set button text color to white */
            cursor: pointer;
        }

        .button-close input[type="submit"]:hover {
            background-color: #c9302c;
            /* Darken button background color on hover */
        }

        .error {
            color: #c9302c;
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>Add Lecturer</h1>
        <form action="lecture_add.php?user_id=<?php echo $u_id; ?>" method="post">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>

            <label for="middle_name">Middle Name:</label>
            <input type="text" id="middle_name" name="middle_name"><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <?php
            if ($passwordMismatch) {
                echo "<span class='error'>Passwords do not match. Please try again.</span>";
            }
            ?>

            <label for="profession">Profession:</label>
            <input type="text" id="profession" name="profession" required><br>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <input style="width: 100px;" type="submit" name="add_lec" value="Add">
        </form>
        
        <form action="lecture_list.php?user_id=<?php echo $u_id; ?>" method="post">
            <input style="width: 100px;background-color: red; color: white;" type="submit" name="cancel" value="Cancel">
        </form>
    </div>

    </div>

</body>

</html>
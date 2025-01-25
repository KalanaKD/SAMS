<?php
require_once('../connection.php');
if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
  $user_id = $_POST['user_id'];
}
echo "$user_id";
$batch = $_GET['batch'];

if (isset($_POST['update'])) {
  // Retrieve user_id and other form data
  $student_id = $_POST['student_id'];
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $status = $_POST['status'];
  $index_no = $_POST['index_no'];
  $reg_no = $_POST['reg_no'];
  $batch_no = $_POST['batch_no'];
  $current_level = $_POST['current_level'];

  // Update user table
  // Update user table
  $user_update_query = "UPDATE `user` SET `first_name`='$first_name', `middle_name`='$middle_name', `last_name`='$last_name', `email`='$email', `status`='$status' WHERE `user_id`='$student_id'";
  mysqli_query($connection, $user_update_query);
  $user_update_result = mysqli_query($connection, $user_update_query);

  // Update student table
  $student_update_query = "UPDATE `student` SET `index_no`='$index_no', `reg_no`='$reg_no', `batch_no`='$batch_no', `current_level`='$current_level' WHERE `student_id`='$student_id'";
  mysqli_query($connection, $student_update_query);
  $student_update_result = mysqli_query($connection, $student_update_query);

  // Check if both updates were successful
  if ($user_update_result && $student_update_result) {
    header("Location: student_list.php?user_id=$user_id&batch=$batch_no");
  } else {
    echo "Error updating lecturer details.";
  }
}

// Check if user_id is set
if (isset($_GET['student_id'])) {
  $student_id = $_GET['student_id'];
  $user_query = "SELECT U.first_name, U.middle_name, U.last_name, U.email, U.status, S.index_no, S.reg_no, S.batch_no, S.current_level FROM user U JOIN student S ON U.user_id = S.student_id WHERE U.user_id = '$student_id'";
  $user_record = mysqli_query($connection, $user_query);

  // Check if both queries were successful
  if ($user_record) {
    // Fetch user details
    $user_details = mysqli_fetch_assoc($user_record);
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
    <form action="student_list_edit.php?batch=<?php echo "$batch"; ?>" method="post">

      <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" value="<?php echo $user_details['first_name']; ?>"><br>

      <label for="middle_name">Middle Name:</label>
      <input type="text" id="middle_name" name="middle_name" value="<?php echo $user_details['middle_name']; ?>"><br>

      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" value="<?php echo $user_details['last_name']; ?>"><br>

      <label for="email">Email:</label>
      <input type="text" id="email" name="email" value="<?php echo $user_details['email']; ?>"><br>

      <label for="status">Status:</label>
      <input type="text" id="status" name="status" value="<?php echo $user_details['status']; ?>"><br>

      <label for="index_no">Index_no:</label>
      <input type="text" id="index_no" name="index_no" value="<?php echo $user_details['index_no']; ?>"><br>

      <label for="reg_no">Reg no:</label>
      <input type="text" id="reg_no" name="reg_no" value="<?php echo $user_details['reg_no']; ?>"><br>

      <label for="batch_no">Batch No:</label>
      <input type="text" id="batch_no" name="batch_no" value="<?php echo $user_details['batch_no']; ?>"><br>

      <label for="current_level">Current Level:</label>
      <input type="text" id="current_level" name="current_level" value="<?php echo $user_details['current_level']; ?>"><br>

      <div style="display: flex; justify-content: space-between; align-items: center;">

        <input style="width: 100px;" type="submit" name="update" value="Update">
    </form>

    <!-- Cancel button to go back to course_list.php -->
    <form action="student_list.php?user_id=<?php echo $user_id; ?>" method="post"> <!-- Pass year and sem back to course_list.php -->
      <input style="width: 100px;background-color: red; color: white;padding: 10px 20px;" type="submit" name="cancel" value="Cancel">
    </form>
  </div>
  </div>
</body>

</html>
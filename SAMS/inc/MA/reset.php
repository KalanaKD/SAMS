<?php require_once('../connection.php');
if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
  $user_id = $_POST['user_id'];
}
echo "$user_id"; ?>

<?php
if (isset($_POST['wh'])) {
  $selectedOption = $_POST['wh'];
  echo "$selectedOption";
  header("Location: $selectedOption");
  exit();
}
?>

<?php

$passwordMismatch = false; // Flag to track password mismatch

if (isset($_POST['update'])) {
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
    /* Global styles */

    /* Typography */
    body {
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.5;
      letter-spacing: 0.5px;
      color: #D1D1D1;
      /* Set text color to light gray */
    }

    /* Layout */
    body {
      margin: 0;
      padding: 0;
      background-color: #2D2D2D;
      /* Set background color to dark gray */
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: #3C3F41;
      /* Set container background color to a lighter dark gray */
      border: 1px solid #444;
      /* Add a dark gray border */
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      /* Add a subtle shadow */
    }

    h1 {
      text-align: center;
      margin-top: 0;
      font-size: 24px;
      color: #D1D1D1;
      /* Set heading color to light gray */
    }

    hr {
      border: none;
      border-top: 1px solid #555;
      /* Set horizontal rule color to medium gray */
      margin: 20px 0;
    }

    /* Form styles */
    form {
      margin-top: 20px;
    }

    select {
      padding: 10px;
      border: 1px solid #666;
      /* Set select border color to medium gray */
      border-radius: 4px;
      cursor: pointer;
      width: 95%;
      background-color: #3C3F41;
      color: #D1D1D1;
    }

    input[type="text"],
    select {
      width: 95%;
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

    /* Table styles */
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
    }

    th {
      background-color: #3C3F41;
      /* Set table header background color to a lighter dark gray */
      color: #D1D1D1;
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
  <header>
    <h1>Student Attendance Management System</h1>
    <hr>
  </header>
  <nav>
    <ul>
      <li>
        <form method="post">
          <label for="wh">Select an option:</label>
          <select id="wh" name="wh" onchange="this.form.submit()">

            <option value="reset.php?user_id=<?php echo $user_id; ?>" disabled selected>Reset Password</option>
            <option value="MA.php?user_id=<?php echo $user_id; ?>">Dashboard</option>
            <option value="course_list.php?user_id=<?php echo $user_id; ?>">Course List</option>
            <option value="student_list.php?user_id=<?php echo $user_id; ?>">Student List</option>
            <option value="lecture_list.php?user_id=<?php echo $user_id; ?>">Lecture List</option>
            <option value="course_allocation.php?user_id=<?php echo $user_id; ?>">Course Allocation</option>
            <option value="take_attendence.php?user_id=<?php echo $user_id; ?>">Take Attendance</option>
            <option value="reports.php?user_id=<?php echo $user_id; ?>">Reports</option>
            <option value="../../index.php">Log Out</option>
          </select>
        </form>
      </li>
    </ul>
  </nav>
  <div class="container">
    <h1>Reset Password</h1>
    <hr>
    <form action="reset.php" method="post">
      Password <input type="password" name="pw" required><br>
      Confirm password <input type="password" name="pw2" required><br>
      <?php
      if ($passwordMismatch) {
        echo "<div style='color:red;'>Passwords do not match. Please try again.</div>";

      }
      ?>
      <input type="hidden" name="user_id" value=<?php echo "$user_id"; ?>>
      <div style="display: flex; justify-content: space-between; align-items: center;">

        <input style="width: 100px;" type="submit" name="update" value="Update">
    </form>

    <!-- Cancel button to go back to course_list.php -->
    <form action="MA.php?user_id=<?php echo $user_id; ?>" method="post"> <!-- Pass year and sem back to course_list.php -->
      <input style="width: 100px;background-color: red; color: white;" type="submit" name="cancel" value="Cancel">
    </form>
  </div>


  </div>




</body>

</html>
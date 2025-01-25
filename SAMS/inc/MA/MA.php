<?php require_once('../connection.php');
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}
echo "$user_id"; ?>

<?php
$query = "SELECT S.date, S.start_time, C.course_code,S.schedule_id
          FROM schedule S, course C
          WHERE S.course_id = C.course_id 
          AND S.schedule_id NOT IN (SELECT DISTINCT schedule_id FROM attendance)";

$record = mysqli_query($connection, $query);
?>

<?php
if (isset($_POST['wh'])) {
    $selectedOption = $_POST['wh'];
    echo "$selectedOption";
    header("Location: $selectedOption");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Management System</title>
    <!-- <link rel="stylesheet" href="styles.css"> Add CSS file -->
    <style>
        /* Global styles */

/* Typography */
body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
  letter-spacing: 0.5px;
  color: #D1D1D1; /* Set text color to light gray */
}

/* Layout */
body {
  margin: 0;
  padding: 0;
  background-color: #2D2D2D; /* Set background color to dark gray */
}

.container {
  max-width: 1200px;
  margin: 40px auto;
  padding: 20px;
  background-color: #3C3F41; /* Set container background color to a lighter dark gray */
  border: 1px solid #444; /* Add a dark gray border */
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow */
}

h1 {
  text-align: center;
  margin-top: 0;
  font-size: 24px;
  color: #D1D1D1; /* Set heading color to light gray */
}

hr {
  border: none;
  border-top: 1px solid #555; /* Set horizontal rule color to medium gray */
  margin: 20px 0;
}

/* Form styles */
form {
  margin-top: 20px;
}

select {
  padding: 10px;
  border: 1px solid #666; /* Set select border color to medium gray */
  border-radius: 4px;
  cursor: pointer;
  width: 95%;
  background-color: #3C3F41;
  color: #D1D1D1;
}

input[type="submit"] {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  background-color: #4CAF50; /* Set button background color to green */
  color: #fff; /* Set button text color to white */
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #3e8e41; /* Darken button background color on hover */
}

/* Table styles */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 10px;
  border: 1px solid #555; /* Set table border color to medium gray */
  text-align: left;
}

th {
  background-color: #3C3F41; /* Set table header background color to a lighter dark gray */
  color: #D1D1D1;
}

tr:nth-child(even) {
  background-color: #333; /* Set even row background color to a medium dark gray */
}

tr:hover {
  background-color: #3C3F41; /* Lighten row background color on hover */
}

a {
  text-decoration: none;
  color: #4CAF50; /* Set link color to green */
}

a:hover {
  color: #3e8e41; /* Darken link color on hover */
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
                        <option value="" disabled selected>Dashboard</option>
                        <option value="course_list.php?user_id=<?php echo $user_id; ?>">Course List</option>
                        <option value="student_list.php?user_id=<?php echo $user_id; ?>">Student List</option>
                        <option value="lecture_list.php?user_id=<?php echo $user_id; ?>">Lecture List</option>
                        <option value="course_allocation.php?user_id=<?php echo $user_id; ?>">Course Allocation</option>
                        <option value="take_attendence.php?user_id=<?php echo $user_id; ?>">Take Attendance</option>
                        <option value="reports.php?user_id=<?php echo $user_id; ?>">Reports</option>
                        <option value="reset.php?user_id=<?php echo $user_id; ?>">Reset Password</option>
                        <option value="../../index.php">Log Out</option>
                    </select>
                </form>
            </li>
        </ul>
    </nav>
    <main>
        <div class="container">
        <?php if ($record && $record->num_rows > 0) { ?>
            <table id="attendance-table">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">Course Code</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $record->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['course_code']; ?></td>
                            <td>
                                <form action="take_attendence.php" method="post">
                                    <input type="hidden" name="schedule_id_2" value="<?php echo $row['schedule_id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <input type="submit" class="submit-button" value="Mark Attendance">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No Attendance sheets have to mark.</p>
        <?php } ?>
        </div>

    </main>


</body>

</html>

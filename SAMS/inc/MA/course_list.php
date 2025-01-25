<?php require_once('../connection.php');
if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
  $user_id = $_POST['user_id'];
}
echo "$user_id";
?>

<?php
if (isset($_POST['wh'])) {
  $selectedOption = $_POST['wh'];
  echo "$selectedOption";
  header("Location: $selectedOption");
  exit();
}
?>
<?php
if (isset($_GET['delete'])) {
  $course_id = $_GET['course_id'];
  $query = "DELETE FROM `course` WHERE `course_id`='$course_id' ";

  $record = mysqli_query($connection, $query);
  if ($record) {
    echo "Deleted!";
  } else {
    echo "Something went wrong!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course List - Student Attendance Management System</title>
  <!-- <link rel="stylesheet" href="styles.css"> -->
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

    .form-inline {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 10px;
    }


    .form-inline label,
    .form-inline select,
    .form-inline input[type="submit"] {
      margin: 0;
      padding: 1px;
      border: 1px solid #666;
      border-radius: 4px;
      background-color: #3C3F41;
      color: #D1D1D1;
    }

    .form-inline input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
    }

    .form-inline input[type="submit"]:hover {
      background-color: #3e8e41;
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

    
    .edit,.delete {
            /* Match button background color */
            color: white;
            border: none;
            padding: 4px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit {
            background-color: lightslategrey;
        }

        .delete {
            background-color: red;
        }

        .edit:hover {
            background-color: #3e8e41;
        }

        .delete:hover {
            background-color: #da190b;
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
            <option value="" disabled selected>Course List</option>
            <option value="MA.php?user_id=<?php echo $user_id; ?>">Dashboard</option>
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
      <?php

      // Query to fetch distinct years
      $year_query = "SELECT DISTINCT `year` FROM `course`";
      $year_result = mysqli_query($connection, $year_query);

      // Array to store available years
      $available_years = array();

      // Fetching available years and populating the array
      while ($row = mysqli_fetch_assoc($year_result)) {
        $available_years[] = $row['year'];
      }

      // Check if semester and year are received via $_GET
      if (isset($_GET['year']) && isset($_GET['sem'])) {
        $year = $_GET['year'];
        $sem = $_GET['sem'];
      } else {
        // If not received, use form inputs
        if (isset($_POST['ok'])) {
          $year = $_POST['year'];
          $sem = $_POST['sem'];
        }
      }

      // Fetch courses based on year and semester
      if (isset($year) && isset($sem)) {
        $query = "SELECT `course_id`,`course_name`,`course_code`,`credits`,`lecture_hours` FROM `course` WHERE `year`='$year' AND `semester`='$sem'";
        $record = mysqli_query($connection, $query);

        if ($record) {
          $table = '<table>';
          $table .= '<caption>Semester: ' . $sem . '|  Year: ' . $year . '</caption>' . '<hr>';
          $table .= '<tr><th>Name</th> <th>Code</th> <th>Credits</th> <th>Lecture Hours</th> <th>Action</th></tr>';
          while ($result = mysqli_fetch_assoc($record)) {
            $table .= "<tr>";
            $table .= '<td>' . $result['course_name'] . '</td>';
            $table .= '<td>' . $result['course_code'] . '</td>';
            $table .= '<td>' . $result['credits'] . '</td>';
            $table .= '<td>' . $result['lecture_hours'] . '</td>';
            $table .= '<td><a class="edit" href="course_edit.php?id=' . $result['course_id'] . '&year=' . $year . '&sem=' . $sem . '&user_id=' . $user_id . '">Edit</a> | <a class="delete" href="course_list.php?delete=true&course_id=' . $result['course_id'] . '&year=' . $year . '&sem=' . $sem . '&user_id=' . $user_id . '">Delete</a></td>';
            $table .= "</tr>";
          }
          $table .= '</table>';
        }
      }
      ?>

      <h1>Course List</h1>
      <hr>

      <!-- Form to select year and semester -->
      <form action="course_list.php?user_id=<?php echo $user_id; ?>" method="post" style="display: flex; align-items: center; gap: 10px;">

        <!-- Dynamic generation of year options -->
        <label for="year" style="margin-right: 5px;">Year:</label>
        <select style="width: 25%;" name="year" required>
          <?php foreach ($available_years as $year) { ?>
            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
          <?php } ?>
        </select>

        <label for="sem" style="margin-left: 30px; margin-right: 5px;">Semester:</label>
        <select style="width: 25%;" name="sem" required>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
        </select>

        <input style="margin-left: 60px; margin-top: 0;width:15%" type="submit" name="ok" value="OK">
      </form>


      <!-- Display the table if records are fetched -->
      <?php if (isset($table)) {
        echo $table;
      } else { ?>
        <p>Select year and semester.</p>
      <?php } ?>

      <!-- Add button to add a new course -->
      <div style="display: flex; justify-content: space-between; align-items: center;">

        <form action="MA.php?&user_id=<?php echo $user_id; ?>" method="post" style="margin-right: 0;">
          <input style="width: 100px;background-color: red; color: white;" type="submit" name="back" value="Back">
        </form>

        <form action="course_add.php?&user_id=<?php echo $user_id; ?>" method="post" style="margin: 0;">
          <input style="width: 100px;" type="submit" name="add" value="Add">
        </form>

      </div>


    </div>
  </main>
</body>

</html>
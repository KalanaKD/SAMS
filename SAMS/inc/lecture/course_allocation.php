<?php
require_once('../connection.php');

// Check if user_id is provided in the URL
if (isset($_GET['u_id'])) {
  $user_id = $_GET['u_id'];
} else {
  echo "User ID is missing!";
  exit;
}

// Retrieve available years and semesters
$year_query = "SELECT DISTINCT year FROM course";
$year_result = mysqli_query($connection, $year_query);

$semester_query = "SELECT DISTINCT semester FROM course";
$semester_result = mysqli_query($connection, $semester_query);
$course_list = array();


// Fetch available courses for the selected year and semester
if (isset($_POST['submit'])) {
  $selected_semester = $_POST['semester'];
  $selected_year = $_POST['year'];

  // Retrieve courses available in the selected year and semester
  $course_query = "SELECT C.course_code, C.course_id, 
    COALESCE(U.first_name, 'NULL') AS first_name, 
    COALESCE(U.last_name) AS last_name
    FROM course AS C 
    LEFT JOIN teach AS T ON C.course_id = T.course_id 
    LEFT JOIN lecture AS L ON T.lecture_id = L.lecture_id 
    LEFT JOIN user AS U ON L.lecture_id = U.user_id 
    WHERE C.year='$selected_year' AND C.semester='$selected_semester'
    ORDER BY C.course_code";


  $result_list = mysqli_query($connection, $course_query);

  // Filter courses taught by the lecture
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Course Allocation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #2d2d2d;
    }

    .container {
      width: 400px;
      margin: 100px auto;
      background-color: #3C3F41;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      color:white;
      text-align: center;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    select,
    input[type="submit"] {
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
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      margin-top: 20px;
      border-radius: 5px;
    }

    input[type="submit"]:hover {
      background-color: #628ab6;
    }

    table {
      width: 80%;
      margin: 0 auto;
      border-collapse: collapse;
      margin-top: 20px;
      color:white;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
      color:black;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Course Allocation</h1>
    <form action="course_allocation.php?u_id=<?php echo $user_id; ?>" method="post">
      <label for="semester">Select Semester:</label>
      <select id="semester" name="semester">
        <?php
        while ($row = mysqli_fetch_assoc($semester_result)) {
          echo "<option value='" . $row['semester'] . "'>" . $row['semester'] . "</option>";
        }
        ?>
      </select>

      <label for="year">Select Year:</label>
      <select id="year" name="year">
        <?php
        while ($row = mysqli_fetch_assoc($year_result)) {
          echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
        }
        ?>
      </select>

      <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
      if (mysqli_num_rows($result_list) > 0) {
        echo '<table>';
        echo '<tr><th>Course Code</th><th>Lecturer</th></tr>';

        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result_list)) {
          echo '<tr>';
          echo '<td>' . $row['course_code'] . '</td>';
          echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
          echo '</tr>';
        }

        echo '</table>';
      } else {
        echo 'No courses available.';
      }
    }
    ?>
    <form action="lecture.php?user_id=<?php echo $user_id; ?>" method="post">
      <input type="submit" name="back" value="Back">
    </form>
  </div>
</body>

</html>
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
// Fetch the course details based on the provided course ID
$id = $_GET['id'];
$year = $_GET['year'];
$sem = $_GET['sem'];

// Check if the form is submitted
if (isset($_POST['save'])) {
    // Escape user inputs for security
    $courseID = mysqli_real_escape_string($connection, $id);
    $courseCode = mysqli_real_escape_string($connection, $_POST['code']);
    $courseName = mysqli_real_escape_string($connection, $_POST['name']);
    $credits = mysqli_real_escape_string($connection, $_POST['credits']);
    $lectureHours = mysqli_real_escape_string($connection, $_POST['hours']);

    // Update the course details in the database
    $query = "UPDATE `course` SET `course_code`='$courseCode', `course_name`='$courseName', `credits`='$credits', `lecture_hours`='$lectureHours', `semester`='$sem', `year`='$year' WHERE `course_id`='$courseID'";
    $result = mysqli_query($connection, $query);

    // Check if the query executed successfully
    if ($result) {
        // Redirect to course_list.php with year and sem parameters
        header("Location: course_list.php?year=$year&sem=$sem&user_id=$user_id");
        exit(); // Stop further execution
    } else {
        // Display error message if query fails
        echo "Error: " . mysqli_error($connection);
    }
}

// Fetch the course details based on the provided course ID
$query = "SELECT * FROM `course` WHERE `course_id`='$id'";
$result = mysqli_query($connection, $query);

// Check if the course exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $courseName = $row['course_name'];
    $courseCode = $row['course_code'];
    $credits = $row['credits'];
    $lectureHours = $row['lecture_hours'];
} else {
    echo "Course not found.";
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Course</title>
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
        <h1>Edit Course</h1>
        <hr>

        <!-- Form to edit the course details -->
        <form action="course_edit.php?id=<?php echo $id; ?>&year=<?php echo $year; ?>&sem=<?php echo $sem; ?>&user_id=<?php echo $user_id; ?>" method="post">
            <label for="name">New Course Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $courseName; ?>" required><br>
            <label for="code">New Course Code:</label>
            <input type="text" id="code" name="code" value="<?php echo $courseCode; ?>" required><br>
            <label for="credits">Credits:</label>
            <select id="credits" name="credits" required>
                <option value="3" <?php if ($credits == 3) echo "selected"; ?>>3</option>
                <option value="4" <?php if ($credits == 4) echo "selected"; ?>>4</option>
            </select><br>
            <label for="hours">Lecture Hours:</label>
            <input type="text" id="hours" name="hours" value="<?php echo $lectureHours; ?>" required><br>

            <div style="display: flex; justify-content: space-between; align-items: center;">

                <input style="width: 100px;" type="submit" name="save" value="Save">
        </form>

        <!-- Cancel button to go back to course_list.php -->
        <form action="course_list.php?year=<?php echo $year; ?>&sem=<?php echo $sem; ?>&user_id=<?php echo $user_id; ?>" method="post"> <!-- Pass year and sem back to course_list.php -->
            <input style="width: 100px;background-color: red; color: white;"  type="submit" name="cancel" value="Cancel">
        </form>
    </div>
    </div>
</body>

</html>
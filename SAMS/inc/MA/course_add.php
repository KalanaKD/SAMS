<?php require_once('../connection.php'); 
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}
echo "$user_id";?>

<?php
// Query to retrieve available years
$year_query = "SELECT DISTINCT `year` FROM course";
$year_result = mysqli_query($connection, $year_query);
?>

<?php
if (isset($_POST['save'])) {
    // Escape user inputs for security
    $courseName = mysqli_real_escape_string($connection, $_POST['name']);
    $courseCode = mysqli_real_escape_string($connection, $_POST['code']);
    $year = mysqli_real_escape_string($connection, $_POST['year']);
    $sem = mysqli_real_escape_string($connection, $_POST['sem']);
    $credits = mysqli_real_escape_string($connection, $_POST['credits']);
    $lectureHours = mysqli_real_escape_string($connection, $_POST['hours']);

    // Build the SQL query
    $query = "INSERT INTO `course` (`course_name`, `course_code`, `credits`, `lecture_hours`, `semester`, `year`) 
                  VALUES ('$courseName', '$courseCode', '$credits', '$lectureHours', '$sem', '$year')";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check if query executed successfully
    if ($result) {
        // Redirect to course_list.php after adding the course with year and sem parameters
        header("Location: course_list.php?year=$year&sem=$sem&user_id=$user_id");
        exit(); // Stop further execution
    } else {
        // Display error message if query fails
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            letter-spacing: 0.5px;
            color: #D1D1D1; /* Set text color to light gray */
            margin: 0;
            padding: 0;
            background-color: #3C3F41; /* Set body background color to dark gray */
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #3C3F41; /* Set container background color to dark gray */
            border: 1px solid #444; /* Add a dark gray border */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow */
            color: #D1D1D1; /* Set text color to light gray */
        }

        h1 {
            margin-top: 0;
            font-size: 24px;
        }

        hr {
            border: none;
            border-top: 1px solid #555; /* Set horizontal rule color to medium gray */
            margin: 20px 0;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"], select {
            padding: 10px;
            border: 1px solid #666; /* Set input border color to medium gray */
            border-radius: 4px;
            cursor: pointer;
            width: 95%;
            background-color: #3C3F41; /* Set input background color to dark gray */
            color: #D1D1D1; /* Set input text color to light gray */
            margin-bottom: 10px;
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

        label {
            display: block;
            margin-bottom: 5px;
            color: #D1D1D1; /* Set label color to light gray */
        }

        .button-close {
            text-align: center;
            margin-top: 20px;
        }

        .button-close input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f44336; /* Set button background color to red */
            color: #fff; /* Set button text color to white */
            cursor: pointer;
        }

        .button-close input[type="submit"]:hover {
            background-color: #c9302c; /* Darken button background color on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Course</h1>
        <hr>
        <form action="course_add.php?user_id=<?php echo $user_id;?>" method="post">
            <label for="name">Course Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="code">Course Code:</label>
            <input type="text" id="code" name="code" required><br>
            <label for="hours">Lecture Hours:</label>
            <input type="text" id="hours" name="hours" required><br>

            <label for="year">Year:</label>
            <select id="year" name="year" required>
                <?php
                while ($row = mysqli_fetch_assoc($year_result)) {
                    echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
                }
                ?>
            </select>

            <label for="sem">Semester:</label>
            <select id="sem" name="sem" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>

            <label for="credits">Credits:</label>
            <select id="credits" name="credits" required>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
            <input style="width: 100px;" type="submit" name="save" value="Save">
        </form>
            <form action="course_list.php?user_id=<?php echo $user_id;?>" method="post">
                <input style="width: 100px;background-color: red; color: white;" type="submit" name="cancel" value="Cancel">
            </form>
            </div>
    </div>
</body>

</html>

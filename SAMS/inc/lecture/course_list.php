<?php 
    require_once('../connection.php');
    
    // Check if user_id is provided in the URL
    if(isset($_GET['u_id'])){
        $user_id = $_GET['u_id'];
    } else {
        // If user_id is not provided, handle the error (redirect or display an error message)
        echo "User ID is missing!";
        exit; // Stop further execution
    }

    // Retrieve available years and semesters
    $year_query = "SELECT DISTINCT year FROM course";
    $year_result = mysqli_query($connection, $year_query);

    $semester_query = "SELECT DISTINCT semester FROM course";
    $semester_result = mysqli_query($connection, $semester_query);
    $course_list = array();
    

    // Fetch available courses for the selected year and semester
    if(isset($_POST['submit']) && !isset($_POST['course'])) {
        $selected_semester = $_POST['semester'];
        $selected_year = $_POST['year'];

        // Retrieve courses available in the selected year and semester
        $course_query = "SELECT `course_id` FROM `course` WHERE `semester`='$selected_semester' AND `year`='$selected_year'";
        $course_result = mysqli_query($connection, $course_query);

        // Filter courses taught by the lecture
        
        while($course_row = mysqli_fetch_assoc($course_result)) {
            $course_id = $course_row['course_id'];
            $teach_query = "SELECT * FROM `teach` WHERE `lecture_id`='$user_id' AND `course_id`='$course_id'";
            $teach_result = mysqli_query($connection, $teach_query);
            if(mysqli_num_rows($teach_result) > 0) {
                $course_list[] = $course_id;
            }
        }
    }

    // Display course list with details
    $course_details = array();
    foreach ($course_list as $course_id) {
        $query = "SELECT `course_name`, `course_code`, `credits`, `lecture_hours` FROM `course` WHERE `course_id`='$course_id'";
        $result = mysqli_query($connection, $query);
        $course_details[$course_id] = mysqli_fetch_assoc($result);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Course List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2D2D2D;
        }
        .container {
            width: 50%;
			margin: 100px auto;
			background-color: #3C3F41;
			border-radius: 10px;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);		
			font-family: Arial, sans-serif;
			font-size: 16px;
			line-height: 1.5;
			letter-spacing: 0.5px;
			color: white; 
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
        }
        select, input[type="submit"] {
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
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #3C3F41;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Course List</h1>
        <form action="course_list.php?u_id=<?php echo $user_id; ?>" method="post">
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

        <!-- Display course list with details -->
        <?php if (isset($_POST['submit'])) : ?>
            <h2>Available Courses</h2>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Course Code</th>
                    <th>Credits</th>
                    <th>Lecture Hours</th>
                </tr>
                <?php foreach ($course_details as $course_id => $details) : ?>
                    <tr>
                        <td><?php echo $details['course_name']; ?></td>
                        <td><?php echo $details['course_code']; ?></td>
                        <td><?php echo $details['credits']; ?></td>
                        <td><?php echo $details['lecture_hours']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <form action="lecture.php?user_id=<?php echo $user_id; ?>" method="post">
            <input type="submit" name="back" value="Back">
        </form>
    </div>
</body>
</html>

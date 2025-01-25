<?php require_once('../connection.php');
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}
echo "$user_id";
if (isset($_POST['wh'])) {
    $selectedOption = $_POST['wh'];
    echo "$selectedOption";
    header("Location: $selectedOption");
    exit();
}
?>

<?php
// Retrieve list of existing semesters and years
$semester_query = "SELECT DISTINCT semester FROM course";
$semester_result = mysqli_query($connection, $semester_query);

$year_query = "SELECT DISTINCT year FROM course";
$year_result = mysqli_query($connection, $year_query);

$selected_semester;
$selected_year;

// Check if form submitted
if (isset($_POST['submit']) || isset($_GET['delete'])) {

    if (isset($_GET['delete'])) {
        $course_id = $_GET['course_id'];
        $query = "DELETE FROM `teach` WHERE `course_id`='$course_id'";
        $query2 = "DELETE FROM `enroll` WHERE `course_id`='$course_id'";
        $record = mysqli_query($connection, $query);
        $record2 = mysqli_query($connection, $query2);
        if ($record && $record2) {
            echo "deleted";
        }
        $selected_semester = $_GET['semester'];
        $selected_year = $_GET['year'];
    } else {
        $selected_semester = $_POST['semester'];
        $selected_year = $_POST['year'];
    }


    // Fetch course names based on selected semester and year
    $course_query = "SELECT course_id, course_code FROM course WHERE semester = '$selected_semester' AND year = '$selected_year'";
    $course_result = mysqli_query($connection, $course_query);

    // Fetch lectures associated with selected courses
    $courses = array(); // Array to store course details

    while ($course_row = mysqli_fetch_assoc($course_result)) {
        $course_id = $course_row['course_id'];
        $course_code = $course_row['course_code'];

        // Fetch lectures associated with this course
        $lecture_query = "SELECT lecture_id FROM teach WHERE course_id = '$course_id'";
        $lecture_result = mysqli_query($connection, $lecture_query);

        $lectures = array(); // Array to store lecture details

        while ($lecture_row = mysqli_fetch_assoc($lecture_result)) {
            $lecture_id = $lecture_row['lecture_id'];

            // Fetch lecturer name associated with this lecture
            $lecturer_query = "SELECT first_name, middle_name, last_name FROM user WHERE user_id = '$lecture_id'";
            $lecturer_result = mysqli_query($connection, $lecturer_query);

            $lecturer_row = mysqli_fetch_assoc($lecturer_result);
            $lecturer_name = $lecturer_row['first_name'] . " " . $lecturer_row['middle_name'] . " " . $lecturer_row['last_name'];

            $lectures[] = $lecturer_name;
        }

        // Store course details along with associated lectures and students
        $courses[] = array(
            'course_id' => $course_id,
            'course_code' => $course_code,
            'lectures' => $lectures
        );
    }
}
?>





<!DOCTYPE html>
<html>

<head>

    <title>Course Allocation</title>
    <style>
        /* Global styles */
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

        /* Container styles */
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #3C3F41;
            /* Set container background color */
            border: 1px solid #444;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);

        }

        /* Header styles */
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
            /* Medium gray */
            margin: 20px 0;
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
            /* Medium gray border */
            text-align: left;
        }

        th {
            background-color: #3C3F41;
            /* Light dark gray */
            color: #D1D1D1;
            /* Light gray */
        }

        tr:nth-child(even) {
            background-color: #333;
            /* Medium dark gray */
        }

        tr:hover {
            background-color: #3C3F41;
            /* Lighten on hover */
        }

        /* Form styles */
        form {
            margin-top: 20px;
            margin-bottom: 20px;
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
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #666;
            /* Medium gray border */
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #3C3F41;
            color: #D1D1D1;
            cursor: pointer;
        }

        input[type="submit"] {
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            /* border-radius: 10px; */
            background-color: #4CAF50;
            /* Green background */
        }

        input[type="submit"]:hover {
            background-color: #45a049;
            /* Darken on hover */
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f44336;
            /* Red background */
            color: white;
        }

        button:hover {
            background-color: red;
            /* Darken on hover */
        }

        /* Link styles */
        .edit,
        .delete {
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
            background-color: #f44336;
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
    <h1>Student Attendance Management System</h1>
    <hr>
    </header>
    <nav>
        <ul>
            <li>
                <form method="post">
                    <label for="wh">Select an option:</label>
                    <select id="wh" name="wh" onchange="this.form.submit()">
                        <option value="course_allocation.php?user_id=<?php echo $user_id; ?>" disabled selected>Course Allocation</option>

                        <option value="MA.php?user_id=<?php echo $user_id; ?>">Dashboard</option>
                        <option value="course_list.php?user_id=<?php echo $user_id; ?>">Course List</option>
                        <option value="student_list.php?user_id=<?php echo $user_id; ?>">Student List</option>
                        <option value="lecture_list.php?user_id=<?php echo $user_id; ?>">Lecture List</option>

                        <option value="take_attendence.php?user_id=<?php echo $user_id; ?>">Take Attendance</option>
                        <option value="reports.php?user_id=<?php echo $user_id; ?>">Reports</option>
                        <option value="reset.php?user_id=<?php echo $user_id; ?>">Reset Password</option>
                        <option value="../../index.php">Log Out</option>
                    </select>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1>Course Allocation</h1>

        <hr>
        <form action="course_allocation.php?&user_id=<?php echo $user_id; ?>" method="post" style="display: flex; align-items: center; gap: 10px;">
            <label for="semester" style="margin-right: 5px;">Semester:</label>
            <select style="width: 25%;" id="semester" name="semester">
                <?php
                while ($row = mysqli_fetch_assoc($semester_result)) {
                    echo "<option value='" . $row['semester'] . "'>" . $row['semester'] . "</option>";
                }
                ?>
            </select>

            <label for="year" style="margin-left: 30px; margin-right: 5px;">Year:</label>
            <select style="width: 25%;" id="year" name="year">
                <?php
                while ($row = mysqli_fetch_assoc($year_result)) {
                    echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
                }
                ?>
            </select>

            <input style="margin-left: 60px; margin-top: 0;width:15%" type="submit" name="submit" value="OK">
        </form>

        <?php
        // Display course names and associated lectures if form submitted
        if (isset($_POST['submit']) || isset($_GET['delete'])) {
            echo "<hr>";
            echo "<h4>Semester:$selected_semester Year:$selected_year</h4>";

            echo "<table>";
            echo "<tr><th>Course Name</th><th>Lecturers</th><th>Students</th><th>Action</th></tr>";
            foreach ($courses as $course) {
                echo "<tr>";
                echo "<td>{$course['course_code']}</td>";
                echo "<td>";

                foreach ($course['lectures'] as $lecture) {
                    echo "<li>$lecture</li>";
                }

                echo "<td>";
                $c = $course['course_id'];

                echo '
                    <form method="post">
                        <select name="wh2" onchange="this.form.action = this.value; this.form.submit()">
                            <option value="">' . $selected_year . ' batch</option>
                            <option value="course_allocation_batch.php?course_id=' . $c . '">' . $selected_year . ' batch</option>
                            <option value="course_allocation_individual.php?course_id=' . $c . '">Individual</option>
                        </select>
                    </form>
                ';

                echo "</td>";
                echo "
                        <td>
                            <a class='edit' href='course_allocation_edit.php?user_id=" . $user_id . "&course_id=" . $c . "&year=" . $selected_year . "&semester=" . $selected_semester . "'>Edit</a>
                            |
                            <a class='delete' href='course_allocation.php?delete=true&user_id=" . $user_id . "&course_id=" . $c . "&year=" . $selected_year . "&semester=" . $selected_semester . "'>Delete</a>
                        </td>
                    ";


                echo "</tr>";
            }
            echo "</table>";
        }
        ?>

        <form action="MA.php?&user_id=<?php echo $user_id; ?>" method="post" style="margin-right: 0;">
            <input style="width: 100px;background-color: red; color: white;" type="submit" name="back" value="Back">
        </form>
    </div>
</body>

</html>
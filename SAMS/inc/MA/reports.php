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
$year_query = "SELECT DISTINCT year FROM course";
$year_result = mysqli_query($connection, $year_query);

$semester_query = "SELECT DISTINCT semester FROM course";
$semester_result = mysqli_query($connection, $semester_query);

$course_list = array();
$schedule_list = array();
$selected_semester = "Select Semester";
$selected_year = "Select Year";
$selected_course = "Select Course";
$students_data = array();
$schedule_id = 'NULL';

if (isset($_POST['semester'])) {

    $selected_semester = $_POST['semester'];
    $selected_year = $_POST['year'];

    $query = "SELECT `course_code` FROM `course` WHERE `semester`='$selected_semester' AND `year`='$selected_year'";
    $record = mysqli_query($connection, $query);

    while ($result = mysqli_fetch_assoc($record)) {
        $c_id = $result['course_code'];
        $course_list[] = $c_id;
    }

    if (isset($_POST['course'])) {
        $selected_course = $_POST['course'];

        $query = "SELECT S.reg_no,U.first_name,U.last_name,U.user_id FROM course C,enroll E,student S,user U WHERE C.course_code='$selected_course' AND C.course_id=E.course_id AND E.student_id=S.student_id AND S.student_id=U.user_id";

        $record = mysqli_query($connection, $query);

        while ($result = mysqli_fetch_assoc($record)) {
            $students_data[] = $result;
        }

        $query2 = "SELECT S.schedule_id,S.date,S.start_time FROM course C,schedule S WHERE C.course_code='$selected_course' AND C.course_id=S.course_id";
        $record2 = mysqli_query($connection, $query2);

        while ($result2 = mysqli_fetch_assoc($record2)) {
            $schedule_list[] = $result2;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Take Attendance</title>
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
                        <option value="reports.php?user_id=<?php echo $user_id; ?>" disabled selected>Reports</option>
                        <option value="MA.php?user_id=<?php echo $user_id; ?>">Dashboard</option>
                        <option value="course_list.php?user_id=<?php echo $user_id; ?>">Course List</option>
                        <option value="student_list.php?user_id=<?php echo $user_id; ?>">Student List</option>
                        <option value="lecture_list.php?user_id=<?php echo $user_id; ?>">Lecture List</option>
                        <option value="course_allocation.php?user_id=<?php echo $user_id; ?>">Course Allocation</option>
                        <option value="take_attendence.php?user_id=<?php echo $user_id; ?>">Take Attendance</option>

                        <option value="reset.php?user_id=<?php echo $user_id; ?>">Reset Password</option>
                        <option value="../../index.php">Log Out</option>
                    </select>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container">

        <form action="reports.php" method="post">
            <h1>Reports</h1>
            <hr>
            <label for="semester" style="margin-right: 5px;">Semester:</label>
            <select style="width: 25%;" id="semester" name="semester" required>
                <?php
                // echo "$selected_semester";
                $options = '<option value="" disabled selected>' . htmlspecialchars($selected_semester) . '</option>';
                while ($row = mysqli_fetch_assoc($semester_result)) {
                    $options .= '<option value="' . $row['semester'] . '">' . $row['semester'] . '</option>';
                }
                echo $options;
                ?>
            </select>
            <label for="year" style="margin-left: 30px; margin-right: 5px;">Year:</label>
            <select style="width: 25%;" id="year" name="year" required>
                <?php
                $options = '<option value="" disabled selected>' . htmlspecialchars($selected_year) . '</option>';
                while ($row = mysqli_fetch_assoc($year_result)) {
                    $options .= '<option value="' . $row['year'] . '">' . $row['year'] . '</option>';
                }
                echo $options;
                ?>
            </select>
            <input type="hidden" name="user_id" value=<?php echo "$user_id"; ?>>
            <input style="margin-left: 60px; margin-top: 0;width:15%" type="submit" name="submit" value="OK">

        </form>

        <?php
        if (isset($_POST['semester'])) {
            echo '
        <form action="reports.php" method="post">
            <label for="course">Course</label>
            <label style="padding-left: 12px;">:</label>
            <select style="width: 25%;" id="course" name="course" required onchange="this.form.submit()">
                <option value="" disabled selected>' . htmlspecialchars($selected_course) . '</option>';

            foreach ($course_list as $course_code) {
                echo '<option value="' . $course_code . '">' . $course_code . '</option>';
            }

            echo '
            </select>
            <input type="hidden" name="year" value="' . $selected_year . '">
            <input type="hidden" name="semester" value="' . $selected_semester . '">
            <input type="hidden" name="user_id" value="' . $user_id . '">
        </form>';
        }
        ?>

        <?php
        if (isset($_POST['course'])) {
            if (!empty($students_data)) {
                echo "
                <form action='' method='post'>
                <table border='1'>
                    <thead>
                        <tr>
                            <th>Registration No</th>
                            <th>First Name</th>
                            <th>Last Name</th>";
                $total_dates = 0;
                foreach ($schedule_list as $schedule) {
                    echo "<th>" . $schedule['date'] . " " . $schedule['start_time'] . "</th>";
                    $total_dates++;
                }
                echo "<th>Total</th>";
                echo "<th>%</th>";
                echo "</tr>
                    </thead>
                    <tbody>";
                foreach ($students_data as $st) {
                    echo "<tr>
                    <td>{$st['reg_no']}</td>
                    <td>{$st['first_name']}</td>
                    <td>{$st['last_name']}</td>";
                    $student_id = $st['user_id'];
                    $present_dates = 0;
                    foreach ($schedule_list as $schedule) {
                        $query = "SELECT `attend` FROM `attendance` WHERE `student_id`=$student_id AND `schedule_id`=" . $schedule['schedule_id'];
                        $record = mysqli_query($connection, $query);
                        if ($record && $result = mysqli_fetch_assoc($record)) {
                            if ($result['attend']) {
                                echo "<td>present</td>";
                                $present_dates++;
                            } else {
                                echo "<td>absent</td>";
                            }
                        } else {
                            // If attendance data not available, display a message or leave the cell empty
                            echo "<td>N/A</td>";
                        }
                    }
                    echo "<td>$present_dates</td>";
                    if ($total_dates > 0) {
                        echo "<td>" . round(($present_dates * 100 / $total_dates), 2) . "%</td>";
                    } else {
                        echo "<td>N/A</td>"; // Avoid division by zero
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
                echo "</form>";
            } else {

                echo "<div style='color: red; width: 100%; text-align: center;'>Data are not Available</div>";
            }
        }
        ?>

        <form action="MA.php?user_id=<?php echo $user_id; ?>" method="post">
            <input style="width: 100px;background-color: red; color: white;" type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>

</html>
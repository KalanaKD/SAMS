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
$schedule_id = 'NULL';
if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];
    $ticks = $_POST['tick']; // Assuming tick is an array of student ids

    foreach ($ticks as $tick) {
        $query = "UPDATE `attendance` SET `attend`=1 WHERE `student_id`=$tick AND `schedule_id`=$schedule_id";
        $record = mysqli_query($connection, $query);
        if ($record) {
        }
    }
}

$year_query = "SELECT DISTINCT year FROM course";
$year_result = mysqli_query($connection, $year_query);

$semester_query = "SELECT DISTINCT semester FROM course";
$semester_result = mysqli_query($connection, $semester_query);

$course_list = array();
$lec_list = array();
$lec_id = array();
$date_list = array();
$time_list = array();
$selected_semester = "Select Semester";
$selected_year = "Select Year";
$selected_course = "Select Course";
$selected_lec_name = "Select Lecture";
$selected_date = "Select Date";
$selected_time = "Select Time";
$students_data = array();
$schedule_id = 'NULL';
if (isset($_POST['schedule_id_2'])) {
    $schedule_id = $_POST['schedule_id_2'];
    echo "$schedule_id";
    $query = "SELECT St.reg_no,U.first_name,U.middle_name,U.last_name,U.user_id FROM course C,enroll E,student St,user U,schedule S WHERE S.schedule_id=$schedule_id AND S.course_id=C.course_id AND C.course_id=E.course_id AND E.student_id=St.student_id AND St.student_id=U.user_id";
    $record = mysqli_query($connection, $query);

    while ($result = mysqli_fetch_assoc($record)) {
        $students_data[] = $result;
    }
}

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

        $query = "SELECT U.first_name, U.user_id 
              FROM user U, teach T, course C 
              WHERE C.course_code='$selected_course' 
              AND C.course_id=T.course_id 
              AND T.lecture_id=U.user_id";

        $record = mysqli_query($connection, $query);

        while ($result = mysqli_fetch_assoc($record)) {
            $lec_name = $result['first_name'];
            $l_id = $result['user_id'];
            $lec_list[] = $lec_name;
            $lec_id[] = $l_id;
        }
    }
    if (isset($_POST['lec_name'])) {
        $selected_lec_name = $_POST['lec_name'];
        $query = "SELECT DISTINCT S.date FROM schedule S, user U, course C WHERE U.first_name='$selected_lec_name' AND U.user_id=S.lecture_id AND C.course_code='$selected_course' AND C.course_id=S.course_id";


        $record = mysqli_query($connection, $query);

        while ($result = mysqli_fetch_assoc($record)) {
            $d = $result['date'];
            $date_list[] = $d;
        }
    }

    if (isset($_POST['date'])) {
        $selected_date = $_POST['date'];
        $query = "SELECT S.start_time FROM schedule S, user U, course C WHERE U.first_name='$selected_lec_name' AND U.user_id=S.lecture_id AND C.course_code='$selected_course' AND C.course_id=S.course_id AND S.date='$selected_date'";


        $record = mysqli_query($connection, $query);

        while ($result = mysqli_fetch_assoc($record)) {
            $t = $result['start_time'];
            $time_list[] = $t;
        }
    }

    if (isset($_POST['time'])) {
        $selected_time = $_POST['time'];
        $query = "SELECT St.reg_no,U.first_name,U.middle_name,U.last_name,U.user_id FROM course C,enroll E,student St,user U WHERE C.course_code='$selected_course' AND C.course_id=E.course_id AND St.student_id=E.student_id AND St.student_id=U.user_id ";


        $record = mysqli_query($connection, $query);

        while ($result = mysqli_fetch_assoc($record)) {
            $students_data[] = $result;
        }

        $query2 = "SELECT S.schedule_id FROM schedule S,course C,user U WHERE U.first_name='$selected_lec_name' AND S.lecture_id=U.user_id AND C.course_code='$selected_course' AND C.course_id=S.course_id AND S.date='$selected_date' AND S.start_time='$selected_time'";
        $record2 = mysqli_query($connection, $query2);

        if ($result2 = mysqli_fetch_assoc($record2)) {
            $schedule_id = $result2['schedule_id'];
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>take_attendence</title>
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

        .tab {
            padding-left: 20px;
            /* Adjust the value as per your requirement */
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

                        <option value="take_attendence.php?user_id=<?php echo $user_id; ?>"disabled selected>Take Attendance</option>
                        <option value="MA.php?user_id=<?php echo $user_id; ?>">Dashboard</option>
                        <option value="course_list.php?user_id=<?php echo $user_id; ?>" >Course List</option>
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
    <div class="container">
        <h1>Take Attendance</h1>
        <?php
        if (!isset($_POST['schedule_id_2'])) {
            echo '<form action="take_attendence.php" method="post">';
            echo '<label for="semester" style="margin-right: 5px;">Semester:</label>';
            echo '<select style="width: 25%;" id="semester" name="semester" required>';

            $options = '<option value="" disabled selected>' . htmlspecialchars($selected_semester) . '</option>';
            while ($row = mysqli_fetch_assoc($semester_result)) {
                $options .= '<option value="' . $row['semester'] . '">' . $row['semester'] . '</option>';
            }
            echo $options;

            echo '</select>';
            echo '<label for="year" style="margin-left: 30px; margin-right: 5px;">Year:</label>';
            echo '<select style="width: 25%;" id="year" name="year" required>';

            $options = '<option value="" disabled selected>' . htmlspecialchars($selected_year) . '</option>';
            while ($row = mysqli_fetch_assoc($year_result)) {
                $options .= '<option value="' . $row['year'] . '">' . $row['year'] . '</option>';
            }
            echo $options;

            echo '</select>';
            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            echo '<input style="margin-left: 60px; margin-top: 0;width:15%" type="submit" name="submit" value="OK">';
            echo '</form>';
        }
        ?>

        <?php
        if (isset($_POST['semester'])) {
            echo '
        <form action="take_attendence.php" method="post">
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
            echo '
            <form action="take_attendence.php" method="post">
                <label for="lec_name">Lecture</label>
                <label style="padding-left: 10px;">:</label>
                <select style="width: 25%;" id="lec_name" name="lec_name" required onchange="this.form.submit()">
                    <option value="" disabled selected>' . htmlspecialchars($selected_lec_name) . '</option>';

            foreach ($lec_list as $lec) {
                echo '<option value="' . $lec . '">' . $lec . '</option>';
            }

            echo '
                </select>
                <input type="hidden" name="year" value="' . $selected_year . '">
                <input type="hidden" name="semester" value="' . $selected_semester . '">
                <input type="hidden" name="course" value="' . $selected_course . '">
                <input type="hidden" name="user_id" value="' . $user_id . '">
            </form>';
        }
        ?>


        <?php
        if (isset($_POST['lec_name'])) {
            echo '
        <form action="take_attendence.php" method="post">
            <label for="date">Date</label>
            <label style="padding-left: 31px;">:</label>
            <select style="width: 25%;" id="date" name="date" required onchange="this.form.submit()">
                <option value="" disabled selected>' . htmlspecialchars($selected_date) . '</option>';

            foreach ($date_list as $d) {
                echo '<option value="' . $d . '">' . $d . '</option>';
            }

            echo '
            </select>
            <input type="hidden" name="year" value="' . $selected_year . '">
            <input type="hidden" name="semester" value="' . $selected_semester . '">
            <input type="hidden" name="course" value="' . $selected_course . '">
            <input type="hidden" name="lec_name" value="' . $selected_lec_name . '">
            <input type="hidden" name="user_id" value="' . $user_id . '">
        </form>';
        }
        ?>


        <?php
        if (isset($_POST['date'])) {
            echo '
            <form action="take_attendence.php" method="post">
                <label for="time">Time</label>
                <label style="padding-left: 30px;">:</label>
                <select style="width: 25%;" id="time" name="time" required onchange="this.form.submit()">
                    <option value="" disabled selected>' . htmlspecialchars($selected_time) . '</option>';

            foreach ($time_list as $t) {
                echo '<option value="' . $t . '">' . $t . '</option>';
            }

            echo '
                </select>
                <input type="hidden" name="year" value="' . $selected_year . '">
                <input type="hidden" name="semester" value="' . $selected_semester . '">
                <input type="hidden" name="course" value="' . $selected_course . '">
                <input type="hidden" name="lec_name" value="' . $selected_lec_name . '">
                <input type="hidden" name="user_id" value="' . $user_id . '">
                <input type="hidden" name="date" value="' . $selected_date . '">
            </form>';
        }

        if (!empty($students_data)) {
            echo "<h2>Students Data</h2>
            <form action='' method='post'>
            <table border='1'>
                <thead>
                    <tr>
                        <th>Registration No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Tick</th> <!-- Added column for tick -->
                    </tr>
                </thead>
                <tbody>";
            foreach ($students_data as $st) {
                echo "<tr>
                    <td>{$st['reg_no']}</td>
                    <td>{$st['first_name']}</td>
                    <td>{$st['last_name']}</td>
                    <td><input type='checkbox' name='tick[]' value='{$st['user_id']}'></td> <!-- Checkbox for tick -->
                </tr>";

                $student_id = $st['user_id'];
                $query = "INSERT IGNORE INTO `attendance` (`schedule_id`, `student_id`,`attend`) VALUES ('$schedule_id', '$student_id',0)";
                $record = mysqli_query($connection, $query); // Execute the query
                if (!$record) {
                    echo "Error inserting attendance record: " . mysqli_error($connection);
                }
            }
            echo "</tbody>
            </table>";
            echo "<input type='hidden' name='schedule_id' value='$schedule_id'>"; // Corrected quotation marks
            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            echo '<div style="display: flex; justify-content: space-between; align-items: center;">';
            echo "<input style='width: 100px;' type='submit' name='submit6' value='Save'> <!-- Button to submit attendance -->
            </form>";
        }
        ?>
        <form action="MA.php?user_id=<?php echo $user_id; ?>" method="post">
            <input style="width: 100px;background-color: red; color: white;" type="submit" name="cancel" value="Cancel">
        </form>
    </div>
    </div>
</body>

</html>
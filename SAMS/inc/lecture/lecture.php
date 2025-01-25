<?php require_once('../connection.php'); ?>
<?php

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    echo "get"."$user_id";
} elseif (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    echo "post"."$user_id";
}

$query = "SELECT C.course_id,C.course_code,C.course_name FROM 
            lecture AS L
            JOIN teach AS T ON L.lecture_id=T.lecture_id
            JOIN course AS C ON T.course_id=C.course_id
            WHERE L.lecture_id='$user_id'";
$course_list = mysqli_query($connection, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['wh'])) {
    $selectedOption = $_POST['wh'];

    switch ($selectedOption) {
        case "dashboard":
            header("Location: lecture.php?u_id=$user_id");
            exit();
        case "course_list":
            header("Location: course_list.php?u_id=$user_id");
            exit();
        case "time_schedule":
            header("Location: time_schedule.php?u_id=$user_id");
            exit();
        case "course_allocation":
            header("Location: course_allocation.php?u_id=$user_id");
            exit();
        case "reports":
            header("Location: reports.php?user_id=$user_id");
            exit();
        case "reset":
            header("Location: reset.php?user_id=$user_id");
            exit();
        case "logout":
            header("Location: ../../index.php");
            break;
        default:
            break;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
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
            margin: 20px 0;
            text-align: center;
        }

        .lec-table{
            align-items: center;
            text-align: center;
            margin-left: 75px;
            width: 80%;
            border-collapse: collapse;
        }
        thead tr {
            background-color: #3C3F41;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid white;
            text-align: center;
            color:white;
        }

        select,
        input[type="submit"] {
            width: 100%;
            padding:10px;  
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="hidden"] {
            display: none;
        }

        input[type="submit"] {
            background-color: #7289da;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
            transition: 0.5s;
        }

        input[type="submit"]:hover {
            background-color: #628a62;
        }
    </style>
</head>

<body>
    <div class="container">
            <h1>Student Attendance Management System</h1>
            <form method="post">
                <select name="wh" onchange="this.form.submit()">
                    <option value="" disabled selected hidden>Dashboard</option>
                    <option value="course_list">Course List</option>
                    <option value="time_schedule">Time Schedule</option>
                    <option value="course_allocation">Course Allocation</option>
                    <option value="reports">Reports</option>
                    <option value="reset">Reset Password</option>
                    <option value="logout">Log Out</option>
                </select>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            </form>

            <h1>Course and Attendance</h1>

            <?php
        if (mysqli_num_rows($course_list) > 0) {
            echo '<table class="lec-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Course Code</th>';
            echo '<th>Course Name</th>';
            echo '<th>Action</th>'; // Added Action column
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($course_list)) {
                echo '<tr>';
                echo '<td>' . $row['course_code'] . '</td>';
                echo '<td>' . $row['course_name'] . '</td>';
                echo '<td><form action="reports.php" method="post">
                <input type="hidden" name="course" value="' . $row['course_code'] . '">
                <input type="hidden" name="user_id" value="' . $user_id . '">
                <input type="submit" value="Go Next" class="go_next"></form></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No courses found.';
        }
        ?>
    </div>

</body>

</html>
<?php
require_once('../connection.php');

if (isset($_GET['user_id'])) {
    $u_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
    $u_id = $_POST['user_id'];
}
echo "$u_id";
?>

<?php
if (isset($_POST['wh'])) {
    $selectedOption = $_POST['wh'];
    echo "$selectedOption";
    header("Location: $selectedOption");
    exit();
}

if (isset($_GET['delete'])) {
    $lec_id = $_GET['lec_id'];
    $qu = "DELETE FROM `user` WHERE `user_id`=$lec_id";
    $record = mysqli_query($connection, $qu);
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
    <title>Lecture List</title>
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
                        <option value="lecture_list.php?user_id=<?php echo $u_id; ?>" disabled selected>Lecture List</option>
                        <option value="MA.php?user_id=<?php echo $u_id; ?>">Dashboard</option>
                        <option value="course_list.php?user_id=<?php echo $u_id; ?>">Course List</option>
                        <option value="student_list.php?user_id=<?php echo $u_id; ?>">Student List</option>

                        <option value="course_allocation.php?user_id=<?php echo $u_id; ?>">Course Allocation</option>
                        <option value="take_attendence.php?user_id=<?php echo $u_id; ?>">Take Attendance</option>
                        <option value="reports.php?user_id=<?php echo $u_id; ?>">Reports</option>
                        <option value="reset.php?user_id=<?php echo $u_id; ?>">Reset Password</option>
                        <option value="../../index.php">Log Out</option>
                    </select>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1>Lecturers</h1>
        <hr>

        <?php
        $query = "SELECT `user_id`, `first_name`, `middle_name`, `last_name`, `email` FROM `user` WHERE `role`='lecture'";
        $record = mysqli_query($connection, $query);

        if ($record && mysqli_num_rows($record) > 0) {
            echo "<table>";
            echo "<tr>
                          <th>Full Name</th>
                          <th>Profession</th>
                          <th>Email</th>
                          <th>Action</th>
                      </tr>";

            while ($row = mysqli_fetch_assoc($record)) {
                $user_id = $row['user_id'];
                $full_name = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
                $email = $row['email'];

                $profession_query = "SELECT `profession` FROM `lecture` WHERE `lecture_id`='$user_id'";
                $profession_result = mysqli_query($connection, $profession_query);
                $profession = ($profession_result && mysqli_num_rows($profession_result) > 0) ? mysqli_fetch_assoc($profession_result)['profession'] : "Unknown";

                echo '<tr>
                          <td>' . $full_name . '</td>
                          <td>' . $profession . '</td>
                          <td>' . $email . '</td>
                          <td>
                              <a class="edit" href="lecture_edit.php?u_id=' . $u_id . '&lec_id=' . $user_id . '">Edit</a> |
                              <a class="delete" href="lecture_list.php?delete=true&user_id=' . $u_id . '&lec_id=' . $user_id . '">Delete</a>
                          </td>
                      </tr>';
            }

            echo "</table>";
        } else {
            echo "<p>No lecturers found.</p>";
        }
        ?>
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <form action="MA.php?user_id=<?php echo $u_id; ?>" method="post" style="margin-right: 0;">
                <input class="back" style="width: 100px;background-color: red; color: white;" type="submit" name="back" value="Back">
            </form>

            <form action="lecture_add.php?user_id=<?php echo $u_id; ?>" method="post" style="margin: 0;">
                <input style="width: 100px;" type="submit" name="add" value="Add">
            </form>

        </div>


    </div>



</body>

</html>
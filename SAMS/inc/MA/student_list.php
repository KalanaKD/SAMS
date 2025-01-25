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
if (isset($_POST['action_ex'])) {
    $student_id = $_POST['student_id'];
    $action = $_POST['action_ex'];
    if ($action == 'edit') {
        header("Location:student_list_edit.php?student_id=$student_id&user_id=$user_id&batch=$batch");
        exit();
    } elseif ($action == 'delete') {
        $q = "DELETE FROM `user` WHERE `user_id`=$student_id";
        $result = mysqli_query($connection, $q);

        if ($result) {
            if (mysqli_affected_rows($connection) > 0) {
                echo $action == 'accept' ? "Accepted" : "Deleted";
            } else {
                echo "No rows affected.";
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
}
?>

<?php
$query = "SELECT DISTINCT S.batch_no FROM student S, user U WHERE S.student_id=U.user_id AND U.status='active' ORDER BY batch_no ASC";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    // Create an array to store batch_no values
    $batch_nos = array();

    // Fetch each row and store the batch_no values in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $batch_nos[] = $row['batch_no'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Batch and Students</title>
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
            max-width: 900px;
            margin: auto auto;
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
            background-color: #f44336;
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
                            <option value="student_list.php?user_id=<?php echo $user_id; ?>" disabled selected>Student List</option>

                            <option value="MA.php?user_id=<?php echo $user_id; ?>">Dashboard</option>
                            <option value="course_list.php?user_id=<?php echo $user_id; ?>">Course List</option>
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
            <h1>Batch and Students</h1>
            <hr>
            <form action="student_list.php?&user_id=<?php echo $user_id; ?>" method="post">
                Select Batch:
                <select style="font-size: 100%;width:30%" name="batch" required>
                    <?php
                    // Check if batch_nos array is populated
                    if (!empty($batch_nos)) {
                        // Loop through the batch_nos array to generate <option> tags
                        foreach ($batch_nos as $batch_no) {
                            echo "<option value=\"$batch_no\">$batch_no</option>";
                        }
                    }
                    echo "<option value='Pending Student'>Pending Student</option>";
                    ?>
                </select>
                <input style="width:10%" type="submit" name="ok" value="OK">
            </form>

            <?php
            // Assuming you have established a database connection

            if (isset($_POST['ok']) || isset($_POST['action_ex']) || isset($_GET['batch'])) {
                if (isset($_POST['batch'])) {
                    $batch = $_POST['batch'];
                } else {
                    $batch = $_GET['batch'];
                }

                // Query to fetch student_id and reg_no based on the selected batch
                if ($batch == "Pending Student") {
                    $qu = "SELECT U.user_id, U.first_name, U.middle_name, U.last_name, U.email, S.index_no, S.reg_no, S.batch_no, S.current_level FROM student S JOIN user U ON S.student_id = U.user_id WHERE U.status = 'pending';";
                    $re = mysqli_query($connection, $qu);

                    if ($re) {
                        if (mysqli_num_rows($re) > 0) {
                            echo "<div id='batch_no'><h3>Pending Students</h3></div>";
                            echo "<table border='1'>
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Index No</th>
                            <th>Reg No</th>
                            <th>Batch No</th>
                            <th>Current Level</th>
                            <th>Actions</th>
                        </tr>";

                            while ($row = mysqli_fetch_assoc($re)) {
                                $student_id = $row['user_id'];
                                echo "<tr>
                            <td>{$row['first_name']}</td>
                            <td>{$row['middle_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['index_no']}</td>
                            <td>{$row['reg_no']}</td>
                            <td>{$row['batch_no']}</td>
                            <td>{$row['current_level']}</td>
                            <td>
                                <form method='POST' action='student_list.php' style='display:flex; gap:10px;'>
                                    <input type='hidden' name='student_id' value='{$student_id}' />
                                    <input type='hidden' name='user_id' value='{$user_id}' />
                                    <button style='background:lightslategrey' type='submit' name='action' value='accept'>Accept</button>
                                    <button type='submit' name='action' value='delete'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                            }

                            echo "</table>";
                        } else {
                            echo "<div id='batch_no'><h3>No Pending Students</h3></div>";
                        }
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }
                } else {
                    $query = "SELECT `student_id`,`reg_no` FROM `student` WHERE `batch_no`='$batch'";
                    $records = mysqli_query($connection, $query);
                    if ($records) {
                        echo "<div id='batch_no'><h3>Batch:" . $batch . "</3></div>";
                        echo "<table>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Registration Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>";

                        // Fetch each row
                        while ($row = mysqli_fetch_assoc($records)) {
                            $student_id = $row['student_id'];
                            $reg_no = $row['reg_no'];

                            // Query to fetch details from the user table based on student_id
                            $qu = "SELECT `first_name`,`middle_name`, `last_name`,`email` ,`status` FROM `user` WHERE `user_id`='$student_id'";
                            $result = mysqli_query($connection, $qu);

                            // Check if the query was successful
                            if ($result) {
                                // Fetch user details
                                $user_details = mysqli_fetch_assoc($result);

                                // Combine first name, middle name, and last name to form full name
                                $full_name = $user_details['first_name'] . " " . $user_details['middle_name'] . " " . $user_details['last_name'];

                                // Display data in table row
                                echo "<tr>
                                    <td>$full_name</td>
                                    <td>{$user_details['email']}</td>
                                    <td>$reg_no</td>
                                    <td>{$user_details['status']}</td>
                                    <td>
                                    <form method='POST' action='student_list.php' style='display:flex; gap:10px;'>
                                        <input type='hidden' name='student_id' value='{$student_id}' />
                                        <input type='hidden' name='batch' value='{$batch}' />
                                        <input type='hidden' name='user_id' value='{$user_id}' />
                                        <button style='background:lightslategrey ' type='submit' name='action_ex' value='edit'>Edit</button>
                                        <button type='submit' name='action_ex' value='delete'>Delete</button>
                                    </form>
                                </td>
                                </tr>";
                            }
                        }
                        echo "</table>";
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }
                }


                // Check if the query was successful

            } else {
                if (isset($_POST['action'])) {
                    $student_id = $_POST['student_id'];
                    $action = $_POST['action'];

                    if ($action == 'accept') {
                        $q = "UPDATE `user` SET `status`='active' WHERE `user_id`=$student_id";
                    } elseif ($action == 'delete') {
                        $q = "DELETE FROM `user` WHERE `user_id`=$student_id";
                    }

                    $result = mysqli_query($connection, $q);

                    if ($result) {
                        if (mysqli_affected_rows($connection) > 0) {
                            echo $action == 'accept' ? "Accepted" : "Deleted";
                        } else {
                            echo "No rows affected.";
                        }
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }
                }

                $qu = "SELECT U.user_id, U.first_name, U.middle_name, U.last_name, U.email, S.index_no, S.reg_no, S.batch_no, S.current_level FROM student S JOIN user U ON S.student_id = U.user_id WHERE U.status = 'pending';";
                $re = mysqli_query($connection, $qu);

                if ($re) {
                    if (mysqli_num_rows($re) > 0) {
                        echo "<div id='batch_no'><h3>Pending Students</h3></div>";
                        echo "<table border='1'>
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Index No</th>
                            <th>Reg No</th>
                            <th>Batch No</th>
                            <th>Current Level</th>
                            <th>Actions</th>
                        </tr>";

                        while ($row = mysqli_fetch_assoc($re)) {
                            $student_id = $row['user_id'];
                            echo "<tr>
                            <td>{$row['first_name']}</td>
                            <td>{$row['middle_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['index_no']}</td>
                            <td>{$row['reg_no']}</td>
                            <td>{$row['batch_no']}</td>
                            <td>{$row['current_level']}</td>
                            <td>
                                <form method='POST' action='student_list.php' style='display:flex; gap:10px;'>
                                    <input type='hidden' name='student_id' value='{$student_id}' />
                                    <input type='hidden' name='user_id' value='{$user_id}' />
                                    <button style='background:lightslategrey ' type='submit' name='action' value='accept'>Accept</button>
                                    <button type='submit' name='action' value='delete'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "<div id='batch_no'><h3>No Pending Students</h3></div>";
                    }
                } else {
                    echo "Error: " . mysqli_error($connection);
                }
            }
            ?>
            <form action="MA.php?&user_id=<?php echo $user_id; ?>" method="post">
                <input style="width: 20%; background-color:#f44336;" type="submit" name="back" value="Back">
            </form>
        </div>





    </body>

</html>
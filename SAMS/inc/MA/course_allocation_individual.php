<?php require_once("../connection.php");?>

<?php 
    $course_id = $_GET['course_id'];

    $year;

    $query = "SELECT `student_id` FROM `enroll` WHERE `course_id`='$course_id'";
    $record = mysqli_query($connection, $query);
    $student = array();

    if ($record) {
        while ($result = mysqli_fetch_assoc($record)) {
            $student[] = $result['student_id'];
        }
    }
   
    $student_batch = array();

    foreach ($student as $st) {
        //$std = $st;
        $query = "SELECT `batch_no` FROM `student` WHERE `student_id`='$st'";
        $record = mysqli_query($connection, $query);

        if ($record) {
            $result = mysqli_fetch_assoc($record);
            $batch_no = $result['batch_no'];

            $query = "SELECT `year` FROM `course` WHERE `course_id`='$course_id'";
            $record = mysqli_query($connection, $query);

            if ($record) {
                $year = mysqli_fetch_assoc($record);

                if ($batch_no != $year['year']) {
                    $student_batch[] = $st;
                }
            }
        }
    }
 ?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students Enrolled</title>
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
    <div class="container">
    <h1>Students Enrolled in Course</h1>
    <table>
        <thead>
            <tr>
                <th>Student Registration Number</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($student_batch as $student_id) {
                    // Fetch student details from database based on student ID
                    $query = "SELECT reg_no FROM student WHERE student_id='$student_id'";
                    $record = mysqli_query($connection, $query);
                    if ($record) {
                        $student_details = mysqli_fetch_assoc($record);
                        echo "<tr>";
                        echo "<td>{$student_details['reg_no']}</td>";
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
    
    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    </div>
</body>
</html>

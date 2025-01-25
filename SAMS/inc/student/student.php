<!DOCTYPE html>
<html>

<head>
	<title>Student Attendance Management System - Dashboard</title>
	<style>
		
		body {
		font-family: Arial, sans-serif;
		margin: 0;
		padding: 0;
		background-color: #2c2f33; /* Dark background color */
		color: white; 
		}

		.container {
		width: 95%;
		margin: 50px auto;
		background-color: #36393f; /* Dark container background color */
		border-radius: 10px;
		padding: 10px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		h1 {
		text-align: center;
		font-weight: bold;
		font-size: 24px;
		color: #fff; /* White text color */
		margin-bottom: 20px;
		}

		.navigation {
		text-align: center;
		margin-bottom: 20px;
		}

		.user-info {
		text-align: center;
		margin-bottom: 20px;
		}

		.details {
		font-weight: bold;
		font-size: 16px;
		color: #72767d; /* Telegram's accent color */
		}

		.semester-selection {
		text-align: center;
		margin: 10px;
		}

		table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 10px;
  border: 1px solid #555; /* Set table border color to medium gray */
  text-align: left;
}

th {
  background-color: #3C3F41; /* Set table header background color to a lighter dark gray */
  color: #D1D1D1;
}

tr:nth-child(even) {
  background-color: #333; /* Set even row background color to a medium dark gray */
}

tr:hover {
  background-color: #3C3F41; /* Lighten row background color on hover */
}

		.dash {
		position: relative;
		display: inline-block;
		padding: 8px 16px;
		border: none;
		border-radius: 20px;
		background-color: #7289da; /* Telegram's accent color */
		cursor: pointer;
		color: #fff; /* White text color */
		transition: background-color 0.3s ease;
		}

		.dash:hover {
		background-color: #677bc4; /* Slightly darker accent color on hover */
		}

		.dash::-ms-expand {
		display: none;
		}

		.dash::after {
		content: '';
		position: absolute;
		top: 50%;
		right: 15px;
		transform: translateY(-50%);
		width: 0;
		height: 0;
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-top: 5px solid #fff; /* White arrow color */
		}

		.dash.open::after {
		transform: translateY(-50%) rotate(180deg);
		}

		.dash select {
		appearance: none;
		-webkit-appearance: none;
		-moz-appearance: none;
		cursor: pointer;
		}

		.dash select::-ms-expand {
		display: none;
		}

		.dash select {
		padding-right: 25px;
		}

		input[type="submit"] {
		border: none;
		color: #fff; 
		padding: 10px 20px;
		text-align: center;
		font-size: 16px;
		font-family: Arial, Helvetica, sans-serif;
		cursor: pointer;
		border-radius: 10px;
		margin-right: 10px;
		}

		.edit{
			background-color: green;
		}
		.sem{
			background-color: #7289da;
		}
		.edit:hover{
			background-color: darkgreen;
		}
		.sem:hover {
		background-color: #677bc4; /* Slightly darker accent color on hover */
		}

		.welcome {
		font-weight: bold;
		font-size: 18px;
		color: #fff; /* White text color */
		text-align: center;
		display: block;
		margin-bottom: 20px;
		}

		.other-text {
		font-weight: bold;
		font-size: 16px;
		color: #72767d; /* Telegram's accent color */
		text-align: center;
		display: block;
		margin-bottom: 20px;
		}

		.error {
		color: red;
		margin-top: 10px;
		}

		input[type="text"]:focus {
		outline: none;
		border-color: #7289da; /* Telegram's accent color */
		box-shadow: 0 0 5px #7289da; /* Lighter box shadow on focus */
		}

		.total {
		text-align: right;
		width: 100px; /* Adjust the width as needed */
		}

	</style>
</head>

<body>
	<?php require_once('../connection.php'); ?>

	<?php
	if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
		echo "get" . "$user_id";
	} elseif (isset($_POST['user_id'])) {
		$user_id = $_POST['user_id'];
		echo "post" . "$user_id";
	}

	$user_id = mysqli_real_escape_string($connection, $user_id);

	$query = "SELECT `email`, `first_name`, `middle_name`, `last_name` FROM `user` WHERE `user_id` = '$user_id'";

	$record = mysqli_query($connection, $query);

	if ($record) {
		$result = mysqli_fetch_assoc($record);
		$name = $result['first_name'] . " " . $result['middle_name'] . " " . $result['last_name'];
		$email = $result['email'];
	} else {
		echo "Error in database";
	}

	$query = "SELECT `current_level`, `batch_no`,`reg_no`,`index_no` FROM `student` WHERE `student_id`='$user_id' ";

	$record2 = mysqli_query($connection, $query);
	if ($record2) {
		$result = mysqli_fetch_assoc($record2);
		$current_level = $result['current_level'];
		$batch_no = $result['batch_no'];
		$reg_no = $result['reg_no'];
		$index_no = $result['index_no'];
	}
	?>

	<?php
	if (isset($_POST['wh'])) {
		$selectedOption = $_POST['wh'];
		echo "$selectedOption";
    header("Location: $selectedOption");
    exit();
	}
	?>


	<div class="container">
		<h1>Student Attendance Management System</h1>
		<div class="navigation">
			<form method="post">
				<select class="dash" name="wh" onchange="this.form.submit()">
					<option value="" disabled selected>Dashboard</option>
					<option value="reset_pw.php?user_id=<?php echo $user_id; ?>">Password Reset</option>
					<option value="../../index.php">Log Out</option>
				</select>
			</form>
		</div>
		<div class="user-info">
			<span class="welcome">Welcome: <?php echo $name; ?> ...</span>
			<div class="details">
				<span class="other-text">
					Current level:<?php echo $current_level; ?><br>
					Batch No:<?php echo $batch_no; ?><br>
					Registration No:<?php echo $reg_no; ?> <br>
					Index No:<?php echo $index_no; ?><br>
					Email: <?php echo $email; ?></span><br>
				<form action="edit_student.php?id=<?php echo $user_id ?>" method="post">
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
					<input type="submit" name="edit" value="EDIT" class="edit">
				</form>
			</div>
		</div>

		<div class="semester-selection">
			<form action="student.php" method="post">
				<input type="submit" name="sem" value="Semester 1" class="sem">
				<input type="submit" name="sem" value="Semester 2" class="sem">
				<input type="submit" name="sem" value="Semester 3" class="sem">
				<input type="submit" name="sem" value="Semester 4" class="sem">
				<input type="submit" name="sem" value="Semester 5" class="sem">
				<input type="submit" name="sem" value="Semester 6" class="sem">
				<input type="submit" name="sem" value="Semester 7" class="sem">
				<input type="submit" name="sem" value="Semester 8" class="sem">
				<input type="hidden" name="user_id" value='<?php echo "$user_id" ?>'>
			</form>
		</div>

		<?php
		if (isset($_POST['sem'])) {
			$selected_sem = null;
			$sem = $_POST['sem'];
			switch ($sem) {
				case "Semester 1":
					$selected_sem = 1;
					break;
				case "Semester 2":
					$selected_sem = 2;
					break;
				case "Semester 3":
					$selected_sem = 3;
					break;
				case "Semester 4":
					$selected_sem = 4;
					break;
				case "Semester 5":
					$selected_sem = 5;
					break;
				case "Semester 6":
					$selected_sem = 6;
					break;
				case "Semester 7":
					$selected_sem = 7;
					break;
				case "Semester 8":
					$selected_sem = 8;
					break;
			}

			// Prepare and execute the first query using prepared statements

			$query1 = "SELECT DISTINCT C.course_id, C.course_code FROM enroll AS E JOIN course AS C ON E.course_id=C.course_id WHERE E.student_id=? AND C.semester=?";
			$stmt1 = mysqli_prepare($connection, $query1);
			mysqli_stmt_bind_param($stmt1, "ii", $user_id, $selected_sem);
			mysqli_stmt_execute($stmt1);
			$record1 = mysqli_stmt_get_result($stmt1);

			while ($c = mysqli_fetch_assoc($record1)) {
				$c_id = $c['course_id'];
				$c_code = $c['course_code'];

				// Output the table header
				echo '<table>';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Course Code</th>';

				// Prepare and execute the second query using prepared statements
				$query2 = "SELECT S.date, S.start_time, A.attend FROM schedule AS S JOIN attendance AS A ON S.schedule_id=A.schedule_id WHERE S.course_id=? AND A.student_id=?";
				$stmt2 = mysqli_prepare($connection, $query2);
				mysqli_stmt_bind_param($stmt2, "ii", $c_id, $user_id);
				mysqli_stmt_execute($stmt2);
				$record2 = mysqli_stmt_get_result($stmt2);

				$attendance_array = array();
				$day_count = 0;
				$p_count = 0; // Corrected variable name
				while ($day = mysqli_fetch_assoc($record2)) {
					$day_count++;
					$date = $day['date'];
					$time = $day['start_time'];
					$attendance_array[] = $day['attend'];
					echo '<th>' . $date . ' ' . $time . '</th>';

					// Increment p_count if attendance is 1
					if ($day['attend'] == 1) {
						$p_count++;
					}
				}
				echo '<th>Total</th>'; // Added Action column
				echo '</tr>';
				echo '</thead>';

				// Output the table body
				// Output the table body
				echo '<tbody>';
				echo '<tr>';
				echo "<td>$c_code</td>";
				foreach ($attendance_array as $a) {
					echo "<td>$a</td>";
				}
				echo "<td class='total'>$p_count/$day_count</td>"; // Total column with class 'total'
				echo '</tr>';
				echo '</tbody>';
				echo '</table>';
			}
		}
		?>

	</div>
</body>

</html>
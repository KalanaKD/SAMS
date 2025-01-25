<?php
require_once('../connection.php');

// Initialize the user_id and schedule_id variables
$user_id = '';
$sch_id = '';

// Check if u_id is set in either GET or POST and sanitize the input
if (isset($_GET['u_id'])) {
    $user_id = mysqli_real_escape_string($connection, $_GET['u_id']);
} elseif (isset($_POST['u_id'])) {
    $user_id = mysqli_real_escape_string($connection, $_POST['u_id']);
}

if (isset($_POST['schedule_id'])) {
    $sch_id = mysqli_real_escape_string($connection, $_POST['schedule_id']);
}

// Print the user ID for debugging purposes (remove in production)
echo htmlspecialchars($user_id);

// Fetch the schedule details if schedule_id is provided
if (!empty($sch_id)) {
    $query = "SELECT chapter, date, start_time, end_time FROM schedule WHERE schedule_id = '$sch_id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $record = mysqli_fetch_array($result);
        // Check if the record exists
        if ($record) {
            // Access the fetched data
            $chapter = htmlspecialchars($record['chapter']);
            $date = htmlspecialchars($record['date']);
            $start_time = htmlspecialchars($record['start_time']);
            $end_time = htmlspecialchars($record['end_time']);
        } else {
            echo "No record found with schedule_id: $sch_id";
        }
    } else {
        echo "Error executing query: " . mysqli_error($connection);
    }
} else {
    echo "Schedule ID is not set.";
}

// Handle form submission to update the record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $new_chapter = mysqli_real_escape_string($connection, $_POST['chapter']);
    $new_date = mysqli_real_escape_string($connection, $_POST['date']);
    $new_start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $new_end_time = mysqli_real_escape_string($connection, $_POST['end_time']);

    $update_query = "UPDATE schedule SET chapter = '$new_chapter', date = '$new_date', start_time = '$new_start_time', end_time = '$new_end_time' WHERE schedule_id = '$sch_id'";
    
    if (mysqli_query($connection, $update_query)) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Schedule</title>
</head>
<body>
    <?php if (!empty($record)): ?>
        <form action="" method="post">
            <input type="hidden" name="u_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($sch_id); ?>">

            <label for="chapter">Chapter:</label>
            <input type="text" id="chapter" name="chapter" value="<?php echo $chapter; ?>" required><br>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>" required><br>

            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo $start_time; ?>" required><br>

            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo $end_time; ?>" required><br>

            <input type="submit" name="update" value="Update">
        </form>
        <form action="time_schedule.php" method="post">
          <input type="hidden" name="u_id" value="<?php echo htmlspecialchars($user_id); ?>">
          <input type="submit" name="back" value="Back">
        </form>
    <?php endif; ?>
</body>
</html>

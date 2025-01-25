<!-- not using -->
<!-- <?php require_once('../connection.php'); 
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}
echo "$user_id";
?>

<?php 
    $course_id = $_GET['id'];
    $year = $_GET['year'];
    $sem = $_GET['sem'];
    $query = "DELETE FROM `course` WHERE `course_id`='$course_id' ";

    $record = mysqli_query($connection,$query);

    if(isset($_POST['delete_b'])){
        if($record){
            header('Location: course_list.php?year=' . $year . '&sem=' . $sem.'&user_id='.$user_id); // Redirect to course_list.php with year and sem parameters
        } else {
            echo "Something went wrong!";
        } 
    }
 ?>

 <!DOCTYPE html>
 <html>
 <head>
     <title>Course Delete</title>
     <style>
        body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: lightblue;
		}
		.container {
			width: 600px;
			margin: 100px auto;
			background-color:aliceblue;
			border-radius: 10px;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display:flex;
            flex-direction: row;
            vertical-align: auto;
		}
        input[type="submit"] {
			background-color:lightblue;
    		border: none; 
    		color: white; 
    		padding: 12px 28px;
    		text-align: center;
    		font-size: 16px;
			font-family:Arial, Helvetica, sans-serif;
			margin-top: 15px;
    		cursor: pointer;
			border-radius:10px ;
            display: flex;
            align-items: center;
            margin-right: 10px;
		}
		input[type="submit"]:hover {
			background-color: #0056b3;
		}
        h1{
            text-align: center;
        }
     </style>
 </head>

 <body>
    <div class="container">
        <h1>Confirm before delete!</h1><hr>

        <form action="course_delete.php?id=<?php echo $course_id; ?>&year=<?php echo $year; ?>&sem=<?php echo $sem; ?>&user_id=<?php echo $user_id;?>" method="post" > <!-- Pass id, year, and semester as parameters in the action URL -->
            <input type="submit" name="delete_b" value="DELETE">
        </form>
        <form action="course_list.php?year=<?php echo $year; ?>&sem=<?php echo $sem; ?>&user_id=<?php echo $user_id;?>" method="post" >
            <input type="submit" value="NO">
        </form>
    </div>
 </body>
 </html> -->

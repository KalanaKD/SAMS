<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            text-align: center; 
            color:white;
        }
        h1, hr {
            margin: 20px 0; 
        }
        form {
            width: 400px;
            margin: 50px auto;
            background-color: #3C3F41;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: left; 
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #7289da;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px; 
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #677bc4;
        }
        a {
            text-decoration: none;
            color: #0056b3;
            margin-top: 10px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: lightblue;
            box-shadow: 0 0 5px lightblue;
        }
    </style>
</head>
<body>
    <h1>Student Attendance Management System</h1>
    <hr>

		<h2>Request has been received by MA</h2>

		<form action="../index.php" action="post">
			<input type="submit" value="Back">
		</form>
</body>
</html>

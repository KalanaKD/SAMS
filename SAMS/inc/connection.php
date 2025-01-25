<?php 
	$connection = mysqli_connect('localhost', 'root', '' ,'studentam');

	if(mysqli_connect_errno()){
		die("error");
	}else{
		echo "connected";
	}
 ?>
<?php 
	include 'php_files/functions.php';
	session_start();
	clearSessionBools();
	if(isset($_SESSION['usr']) && isset($_SESSION['pswd'])){
		//user logged in proceed
	}else{
		//not logged in, redirect to login
		header("Location: ../login.html");
		exit();
	}
?>


<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
<body>
hi
	<div id="container">
		<div id="header">
			<center><img src="../resources/back1.png"></center>
		</div>
		<div id="nav">
			<ul>
				<li><a href="../index.html">Back to Home</a></li>
			</ul>
		</div>
		<center><div class="createusersbox" style="height:300px">
			<br>
			<br>
			<em>Page Not Found.</em>
			<br>
			<br>
		</div></center>
    </div>
</body>
</html>
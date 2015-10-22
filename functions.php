<?php 
	include 'functions.php';
	session_start();
	clearSessionBools();




	function clearSessionBools(){
		unset($_SESSION['tmppostbool']);
		unset($_SESSION['tmppostemail']);
		unset($_SESSION['tmppostuserfname']);
		unset($_SESSION['tmppostuserlname']);
		unset($_SESSION['tmppostphone']);
	}



	if(isset($_SESSION['usr']) && isset($_SESSION['pswd'])){
		//user logged, redirect to 404
		header("Location: notfound.html");
		exit();
	}else{
		//not logged in, redirect to login
		header("Location: login.html");
		exit();
	}

	
?>
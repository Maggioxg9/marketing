<?php 
	function clearSessionBools(){
		print_r($_SESSION);
		unset($_SESSION['tmppostbool']);
		unset($_SESSION['tmppostemail']);
		unset($_SESSION['tmppostuserfname']);
		unset($_SESSION['tmppostuserlname']);
		unset($_SESSION['tmppostphone']);
	}
	
?>
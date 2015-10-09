<?php

	// the message
$msg = "Hello\nWorld";
$from = "aemarketingtechsupport@gmail.com";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("zacharym@accelentertainment.com","My subject",$msg, "From: <aemarketingtechsuport@gmail.com>");

echo"sent";
?>
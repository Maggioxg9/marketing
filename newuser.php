<?php
	session_start();

?>

<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
<body>
	<div id="container">
		<div id="header">
			<center><img src="back1.png"></center>
		</div>
		<div id="nav">
		</div>
		<center><div class="createusersbox">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<div style="margin-top: 8%;">
						<br>
					</div>
					<div class="createdetails">
						<span class="formfont">Desired Username:</span>
							<input class="textbox" type="text" name="username" size="30" maxlength="20">
					</div>
					<div class="createdetails">
						<span class="formfont">New Password:</span>
							<input class="textbox" type="password" name="password" size="30" maxlength="20">
					</div>
					<div class="createdetails">
						<span class="formfont">Re-type Password:</span>
							<input class="textbox" type="password" name="repassword" size="30" maxlength="20">
					</div>
					<div class="createdetails">
						<span class="formfont">First Name:</span>
							<input class="textbox" type="text" name="firstname" size="30" maxlength="20">
					</div>
					<div class="createdetails">
						<span class="formfont">Last Name:</span>
							<input class="textbox" type="text" name="lastname" size="30" maxlength="20">
					</div>
					<div class="createdetails">
						<span class="formfont">E-Mail:</span>
							<input class="textbox" type="text" name="email" size="30" maxlength="20">
					</div>
					<div class="createdetails">
						<span class="formfont">Phone:</span>
							<input class="textbox" type="text" name="phone" size="30" maxlength="20">
					</div>
					<div> 
						<br>
					</div>
					<div class="g-recaptcha" data-sitekey="6Ld-CA4TAAAAADicP5F1_KcIIBagpsNeE-TG7nip"></div>



					<div id="createbtn">
						<br>
						<input id="createbutton" type="submit" value="Create Account">
					</div>
				</form>
				<script src='https://www.google.com/recaptcha/api.js'></script>
		</div></center>
    </div>
</body>
</html>
<?php
	session_start();
	require_once "recaptchalib.php";

	$secret= "6Ld-CA4TAAAAAER5Lq6-85en9z0XjFVI3sX1ure5";
	$response = null;

	$recaptcha = new ReCaptcha($secret);

	if($_POST["g-recaptcha-response"]){
		$response= $recaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
	}
	if($response !=null && $response->success){
		if(empty($_POST["username"])||empty($_POST["password"])||empty($_POST["repassword"])||empty($_POST["firstname"])||empty($_POST["lastname"])||empty($_POST["email"])){
			echo "Please fill out all required fields";
			exit();
		}else if($_POST["password"]!=$_POST["repassword"]){
			echo "passwords dont match";
			exit();
		}else{
			//everything is valid, assign variables

			//database constants
			$servername = "localhost";
			$username = "root";
			$password = "raspberry";
			$dbname = "marketing";
			$newuser= htmlspecialchars($_POST["username"]);
			$newpass= htmlspecialchars($_POST["password"]);
			$repass= htmlspecialchars($_POST["repassword"]);
			$firstname= htmlspecialchars($_POST["firstname"]);
			$lastname= htmlspecialchars($_POST["lastname"]);
			$email= htmlspecialchars($_POST["email"]);
			$phone= htmlspecialchars($_POST["phone"]);
		
			try{

				//create a database connection
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				//create and execute sql query to check if username exists
				$stmt= $conn->prepare("select userid from users where username= :name");
				$stmt->execute(array(':name' => "$newuser"));

				//check to see if user record was found
				if($stmt->rowcount() > 0){
					//user already exists
					echo "user already exists";
					$conn=null;
					exit();
				}else{
					//username is free, setup new user
				}
				$conn=null;
			}catch(PDOException $e){
		
				//print error details to screen
				echo $result . "<br>" . $e->getMessage();

				//close database connection
				$conn = null;
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">

	<script>
		function changeReferral(){
			console.log("here");
			var field=document.getElementById("referralfield");
			if(field.style.display=='block'){
				field.style.display= 'none';
			}else{
				field.style.display= 'block';
			}
		}

	</script>
	</head>
	
<body>
	<div id="container">
		<div id="header">
			<center><img src="back1.png"></center>
		</div>
		<div id="nav">
		</div>
		<center><div class="createusersbox">
				<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
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
					<div class="createdetails">
							<input id="clientbtn" type="radio" name="accounttype" value="client" checked="checked" onclick="changeReferral()">Client Account
							<input id="employeebtn" type="radio" name="accounttype" value="accelemployee" onclick="changeReferral()">Accel Entertainment Employee
					</div>
					<div> 
						<br>
					</div>
					<div class="createdetails" id="referralfield">
						<span class="formfont">Referral Code:</span>
							<input class="textbox" type="text" name="refcode" size="30" maxlength="20">
						<br><br>
					</div>
					<div class="g-recaptcha" data-sitekey="6Ld-CA4TAAAAADicP5F1_KcIIBagpsNeE-TG7nip"></div>



					<div id="createbtn">
						<br>
						<input id="createbutton" type="submit" value="Create Account">
					</div>
				</form>
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<script> changeReferral(); </script>
		</div></center>
    </div>
</body>
</html>
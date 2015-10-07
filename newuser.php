<?php
	session_start();
	require_once "recaptchalib.php";

	$secret= "6Ld-CA4TAAAAAER5Lq6-85en9z0XjFVI3sX1ure5";
	$response = null;

	$recaptcha = new ReCaptcha($secret);
if(isset($_POST['submit'])){
	unset($_POST['submit']);
	if(isset($_POST["g-recaptcha-response"])){
		$response= $recaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
		if($response !=null && $response->success){
			if(empty($_POST["username"])||empty($_POST["password"])||empty($_POST["repassword"])||empty($_POST["firstname"])||empty($_POST["lastname"])||empty($_POST["email"])){
				$_SESSION['badcreate']="Please fill out all fields.";
			}else if($_POST["password"]!=$_POST["repassword"]){
				$_SESSION['badcreate']="Passwords must match.";
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
						$_SESSION['badcreate']="Username already exists, please choose a different username.";
						$conn=null;
					}else{
						//username is free, setup new user
					}
					$conn=null;
					header("Location: newuser.php");
					
				}catch(PDOException $e){
			
					//print error details to screen
					echo $result . "<br>" . $e->getMessage();
	
					//close database connection
					$conn = null;
				}
			}
		
		}else{
			//recaptcha wasnt valid
			$_SESSION['badcreate']="Click the reCaptcha box before submitting.";
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
			var field=document.getElementById("referralfield");
			var cbtn = document.getElementById("clientbtn");
			if(cbtn.checked){
				field.style.display="block";
			}else{
				field.style.display="none";
			}
		}

	</script>
	<script>
		function initializeForm(){
			var errorspan=document.getElementById("message");
			var errorstring="<?php if(isset($_SESSION['badcreate'])){
							echo $_SESSION['badcreate'];
							unset($_SESSION['badcreate']);
						}else{
							echo "";
						}
					?>";
			errorspan.textContent=errorstring;
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
				<form action="newuser.php?submit=true" method="post">
					<div style="margin: 4%;">
						<span id="message"></span>
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
	
					<div class="createdetails">
							<input id="clientbtn" type="radio" name="accounttype" value="client" checked="checked" onclick="changeReferral()">Client Account
							<input id="employeebtn" type="radio" name="accounttype" value="accelemployee" onclick="changeReferral()">Accel Entertainment Employee
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
				<script> initializeForm(); </script>
		</div></center>
    </div>
</body>
</html>
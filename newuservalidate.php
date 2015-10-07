<?php	
	session_start();
	require_once "recaptchalib.php";

	$secret= "6Ld-CA4TAAAAAER5Lq6-85en9z0XjFVI3sX1ure5";
	$response = null;

	$recaptcha = new ReCaptcha($secret);

	$_SESSION['tmpuser']=$_POST['username'];
	$_SESSION['tmppass']=$_POST['password'];
	$_SESSION['tmprepass']=$_POST['repassword'];
	$_SESSION['tmpfname']=$_POST['firstname'];
	$_SESSION['tmplname']=$_POST['lastname'];
	$_SESSION['tmpemail']=$_POST['email'];
	$_SESSION['tmpphone']=$_POST['username'];
	$_SESSION['tmpref']=$_POST['refcode'];
	
	if(isset($_POST["g-recaptcha-response"])){
		$response= $recaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
		if($response !=null && $response->success){
			if(empty($_POST["username"])||empty($_POST["password"])||empty($_POST["repassword"])||empty($_POST["firstname"])||empty($_POST["lastname"])||empty($_POST["email"])){
				$_SESSION['badcreate']="Please fill out all fields.";
				header("Location:newuser.html");
				exit();
			}else if($_POST["password"]!=$_POST["repassword"]){
				$_SESSION['badcreate']="Passwords must match.";
				header("Location:newuser.html");
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
						$_SESSION['badcreate']="Username already exists, please choose a different username.";
						$conn=null;
						header("Location:newuser.html");
					}else{
						//username is free, setup new user


						//clear saved variables
						unset($_SESSION['tmpuser']);
						unset($_SESSION['tmppass']);
						unset($_SESSION['tmprepass']);
						unset($_SESSION['tmpfname']);
						unset($_SESSION['tmplname']);
						unset($_SESSION['tmpemail']);
						unset($_SESSION['tmpphone']);
						unset($_SESSION['tmpref']);
						$conn=null;
						header("Location:usercreated.html");
						exit();
					}
				}catch(PDOException $e){
			
					//print error details to screen
					echo $result . "<br>" . $e->getMessage();
	
					//close database connection
					$conn = null;
				}
			}
		
		}else{
			//recaptcha wasnt valid, should technically never get here, error on googles end
			$_SESSION['badcreate']="Complete the reCaptcha box before submitting.";
			header("Location:newuser.html");
			exit();
		}
	}else{
		//user never entered captcha
		$_SESSION['badcreate']="Click the reCaptcha box before submitting.";
		header("Location:newuser.html");
		exit();
	}
?>
<?php
session_start();
include('config.php');

    $email = $password = '';
	$errors = array('email' => '', 'password' => '');

	if(isset($_POST['submit'])){
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'Email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
        }
        
        // check password
		if(empty($_POST['password'])){
			$errors['password'] = 'Password is required';
		} else{
			$password = $_POST['password'];
        }
        
        
		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
            // escape sql chars
            $email = mysqli_real_escape_string($connect, $_POST['email']);
			$password = mysqli_real_escape_string($connect, $_POST['password']);

			$sqlid = "SELECT *
		            FROM
						individuals
					WHERE
					email = '$email' AND password = '$password'";

			$sqlcom = "SELECT *
		            FROM
						companies
					WHERE
					email = '$email' AND password = '$password'";
			$resultid = mysqli_query($connect, $sqlid);
			$resultcom = mysqli_query($connect, $sqlcom);

			if(mysqli_num_rows($resultid)==1){
				$_SESSION["email"] = $email;
				header('Location: homeid.php');
			}elseif(mysqli_num_rows($resultcom)==1){
				$_SESSION["email"] = $email;
				header('Location: homecom.php');
			}
			else{
				$errors['email'] = 'Incorrect email or password';
				}




			
		}

	} // end POST check
    mysqli_close($connect);
?>

<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
<title>Sign in</title>
</header>
<body>


<div class="menu">
    <a href="homeout.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeout.php"><p class="menu-text ">Home</p></a>
    <a href="support.php"><p class="menu-text">Support</p></a>
    <a href="sign-in.php"><button class="btn selected">Sign in</button></a>
    <a href="register.php"><button class="btn btn-r">Register</button></a>
</div>



<div class="white-sheet  white-sheet-form shadow">
    <h1 class="white-sheet-title">Please enter</h1>
	<form class="form-r" action="sign-in.php" method="POST" >
	<label>Email: <?php echo $errors['email']; ?></label>
  	<input class="input input-form shadow" type="text" name="email" placeholder="Enter Email"  value="<?php echo htmlspecialchars($email);  ?>" >
	  <label>Password: <?php echo $errors['password']; ?></label>
  	<input class="input input-form shadow" type="password" name="password" placeholder="Enter Password" value="<?php echo htmlspecialchars($password); ?>" ><br>
  	<input class="btn btn-f" type="submit" name="submit" value="sign in">
	</form>
</div>

<div class="footer">
    <a class="footer-fix" href="homeout.php"> <img class="footer-logo" src="logo.svg"> </a>
     <div class="footer-white shadow"></div>
     <p class="footer-rights">Copyright © 2020 Hirrre Inc. All rights reserved.</p>
</div>




</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/core.js"></script>
<script src="js/index.js"></script>
</html>

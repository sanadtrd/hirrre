<?php
    include('config.php');
    $email = $name = $password = $field = $description = $website =  $location= '';
	$errors = array('email' => '', 'name' => '', 'password' => '' , 'field' => '');

	if(isset($_POST['submit'])){

        // check name
		if(empty($_POST['name'])){
			$errors['name'] = 'Company name is required';
		} else{
			$name = $_POST['name'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
				$errors['name'] = 'Comapny name must be letters and spaces only';
			}
			$sqlu = "SELECT name FROM companies WHERE name= '$name'";
			$resultu = mysqli_query($connect, $sqlu);
	
			if(mysqli_num_rows($resultu) == 1){
				$errors['name'] = 'Company name is already used';
			}
		}
		
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'Email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
			$sqle = "SELECT email FROM companies WHERE email= '$email'";
			$resulte = mysqli_query($connect, $sqle);
	
			if(mysqli_num_rows($resulte) == 1){
				$errors['email'] = 'Email is already used';
			}
        }
        
        // check password
		if(empty($_POST['password'])){
			$errors['password'] = 'Password is required';
		} else{
			$password = $_POST['password'];
        }
        

		// check position
		if(empty($_POST['field'])){
			$errors['field'] = 'Field is required';
		} else{
			$position = $_POST['field'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $position)){
				$errors['field'] = 'Field must be letters only';
			}
        }
        
        
		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
            // escape sql chars
            $name = mysqli_real_escape_string($connect, $_POST['name']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $password = mysqli_real_escape_string($connect, $_POST['password']);
			$field = mysqli_real_escape_string($connect, $_POST['field']);
			// create sql
			$sql = "INSERT INTO companies(name,email,password,field,description,website,location) VALUES('$name','$email','$password','$field','$description','$website','$location')";

			// save to db and check
			if(mysqli_query($connect, $sql)){
				// success
				$_SESSION["email"] = $email;
				header('Location: homecom.php');
			} else {
				echo 'query error: '. mysqli_error($connect);
			}

			
		}

	} // end POST check
    mysqli_close($connect);
?>

<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
<title>Sign up | Company</title>
</header>

<body>
<div class="menu">
    <a href="homeout.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeout.php"><p class="menu-text ">Home</p></a>
    <a href="support.php"><p class="menu-text">Support</p></a>
    <a href="sign-in.php"><button class="btn ">Sign in</button></a>
    <a href="register.php"><button class="btn btn-r selected">Register</button></a>
</div>


<div class="white-sheet  white-sheet-form shadow">
<h1 class="white-sheet-title">Fill info</h1>
<form  class="form-r"  action="signup-com.php" method="POST" >
<label>Name: <?php echo $errors['name']; ?></label>
  <input class="input input-form shadow"  type="text" name="name" placeholder="Company name" value="<?php echo htmlspecialchars($name) ?>"> 
  <label>Email: <?php echo $errors['email']; ?></label>
  <input class="input input-form shadow"  type="text" name="email" placeholder="Email"  value="<?php echo htmlspecialchars($email) ?>" >
  <label>Password: <?php echo $errors['password']; ?></label>
  <input class="input input-form shadow"  type="password" name="password" placeholder="Password" value="<?php echo htmlspecialchars($password) ?>" >
  <label>Field: <?php echo $errors['field']; ?></label>
  <input class="input input-form shadow"  type="text"  name="field" placeholder="Company field ex.Design"  value="<?php echo htmlspecialchars($field) ?>" >
  <input class="btn btn-f"  type="submit" name="submit" value="Submit">
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

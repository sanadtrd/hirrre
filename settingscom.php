<?php
session_start();
$mcheck = $_SESSION["mcheck"] ;
$mresult = 0;
$sid = $_SESSION['id'];
include('config.php');
        //menu
        if ((isset($_SESSION["id"])) && ($mcheck == 2) ){
            //company
            $mresult= 2;
        }elseif( (isset($_SESSION["id"])) && ($mcheck == 1) ){
            //Employee
            $mresult=1;
        } elseif(!isset($_SESSION["id"])){
            //guest
            $mresult = 0;
        }


    $sql = "SELECT * FROM companies WHERE id=$sid";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $email = $row['email'];
    $password = $row['password'];
    $field = $row['field'];
    $des = $row['description'];
    $website = $row['website'];
    $location = $row['location'];





    if(isset($_POST['update'])){
        $name = mysqli_real_escape_string($connect, $_POST['name']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);
        $field = mysqli_real_escape_string($connect, $_POST['field']);
        $des = mysqli_real_escape_string($connect, $_POST['des']);
        $website = mysqli_real_escape_string($connect, $_POST['website']);
        $location = mysqli_real_escape_string($connect, $_POST['location']);
        $sql = "UPDATE companies SET name = '$name',  password ='$password', email ='$email' , field ='$field' , description ='$des', website ='$website' , location ='$location' WHERE id=$sid";

        if(mysqli_query($connect, $sql)){
            // success
            $_SESSION['email'] = $email;
        } else {
            echo 'query error: '. mysqli_error($connect);


        }
    }


?>


<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
<title>Settings</title>
</header>
<body>
    
<?php if ($mresult == 2) : ?>
<div class="menu">
    <a href="homecom.php"> <img class="logo" src="logo.svg"></a>
    <a href="homecom.php"><p class="menu-text">Home</p></a>
    <a href="profile-com.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text"><?php echo $_SESSION["name"] ?></p></a>
    <a href="settingscom.php"><button class="btn">Settings</button></a>
    <a href="logout.php"><button class="btn btn-r">Logout</button></a>
</div>

<?php endif; ?>

    <div class="white-sheet  white-sheet-form shadow">
    <h1 class="white-sheet-title">Settings - Personal Info</h1>
    <form class="form-r" action="settingscom.php" method="POST">
    <label>Name:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Name"  name="name" value="<?php echo $name?>" >
        <label>Email:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Email"  name="email" value="<?php echo $email?>" >
        <label>Password:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Password"  name="password" value="<?php echo $password?>" >
        <label>Field:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Field"  name="field" value="<?php echo $field?>" >
        <label>Website:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Website"  name="website" value="<?php echo $website?>" >
        <label>Location:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Locaion"  name="location" value="<?php echo $location?>" >
        <label>Description:</label>
        <textarea  class="shadow"  type="text" placeholder="Enter Description"  name="des" ><?php echo $des?></textarea>
        <input class="btn btn-f" type="submit" name="update" value="submit">
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


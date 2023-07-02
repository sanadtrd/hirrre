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



    $sql = "SELECT * FROM individuals WHERE id=$sid";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $email = $row['email'];
    $username = $row['username'];
    $password = $row['password'];
    $des = $row['description'];
    $cp = $row['current_position'];



    if(isset($_POST['update'])){

        $name = mysqli_real_escape_string($connect, $_POST['name']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);
        $des = mysqli_real_escape_string($connect, $_POST['des']);
        $cp = mysqli_real_escape_string($connect, $_POST['cp']);
        $sql = "UPDATE individuals SET name = '$name', username ='$username' , password ='$password', email ='$email' , description ='$des', current_position ='$cp' WHERE id=$sid";

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

<?php if ($mresult == 1): ?>

    <div class="menu">
    <a href="homeid.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeid.php"><p class="menu-text">Home</p></a>
    <a href="profile-in.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text"><?php echo $_SESSION["name"] ?></p></a>
    <a href="settings.php"><button class="btn  selected">Settings</button></a>
    <a href="logout.php"><button class="btn btn-r">Logout</button></a>
    </div>

<?php endif; ?>


    <div class="white-sheet  white-sheet-form shadow">
    <h1 class="white-sheet-title">Settings - Personal Info</h1>
    <form class="form-r" action="settings.php" method="POST">
    <label>Name:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Name" name="name" value="<?php echo $name?>" >
        <label>Username:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Username" name="username" value="<?php echo $username?>" >
        <label>Email:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Email" name="email" value="<?php echo $email?>" >
        <label>Password:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Password" name="password" value="<?php echo $password?>" >
        <label>Current Position:</label>
        <input class="input input-form shadow"  type="text" placeholder="Enter Current Position" name="cp" value="<?php echo $cp?>" >
        <label>Description:</label>
        <textarea class="shadow" type="text" placeholder="Enter Description"  name="des" ><?php echo $des?></textarea>
        <input  class="btn btn-f" type="submit" name="update" value="submit">
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


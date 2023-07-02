<?php
session_start();
include('config.php');
$email = $_SESSION["email"] ;
$sql = "SELECT * FROM companies WHERE email = '$email'";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_array($result);
    $_SESSION["id"] = $row['id'];
    $_SESSION["name"] = $row['name'];
    $_SESSION["password"] = $row['password'];
    $_SESSION["field"] = $row['field'];
    $_SESSION["des"] = $row['description'];
    $_SESSION["website"] = $row['website'];
    $_SESSION["location"] = $row['location'];
    $_SESSION["mcheck"] = $row['mcheck'];

}

if (isset($_SESSION["id"])){
$mcheck = $_SESSION["mcheck"] ;
}
$mresult = 0;

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

mysqli_close($connect);
?>

<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
<title>Home</title>
</header>
<style>
.form-out{
    grid-template-columns:1fr;
}
</style>
<body>
    
<?php if ($mresult == 2) : ?>
<div class="menu">
    <a href="homecom.php"> <img class="logo" src="logo.svg"></a>
    <a href="homecom.php"><p class="menu-text  selected">Home</p></a>
    <a href="profile-com.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text"><?php echo $_SESSION["name"] ?></p></a>
    <a href="settingscom.php"><button class="btn">Settings</button></a>
    <a href="logout.php"><button class="btn btn-r">Logout</button></a>
</div>
<?php endif; ?>

<div class="white-sheet white-sheet-search shadow">
    <h1 class="white-sheet-title">Find new staff</h1>
    <form class ="form-out"  action="searchcom.php" method="GET">
        <input  class="input shadow" type="text" name="keywords" placeholder="Search by Name or Position">
        <input class=" btn btn-action shadow" style="margin-right:0px;" type="submit" name="search" value="search">
        <!--Filter-->
        <input class=" hide" type="text" name="type" placeholder="Type">
        <input class=" hide" type="text" name="salary" placeholder="Salary minimum">
        <input class="hide" type="text" name="exp" placeholder="Experience">
        <input  class="hide" type="text" name="cfield" placeholder="Company Field">
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
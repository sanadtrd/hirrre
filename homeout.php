<?php
include('config.php');


mysqli_close($connect);
?>

<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
    <title>Home </title>
</header>
<html>
<style>
.form-out{
    grid-template-columns:1fr;
}
</style>
<body>

<div class="menu">
    <a href="homeout.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeout.php"><p class="menu-text selected">Home</p></a>
    <a href="support.php"><p class="menu-text">Support</p></a>
    <a href="sign-in.php"><button class="btn">Sign in</button></a>
    <a href="register.php"><button class="btn btn-r">Register</button></a>
</div>

<h3 class="title">Searching for vacancies &amp; career opportunities?</h3>

<div class="white-sheet white-sheet-search shadow">
    <h1 class="white-sheet-title">Find Your New Job</h1>
    <form class ="form-out"  action="searchid.php" method="GET">
        <input  class="input shadow" type="text" name="keywords" placeholder="Search by position or company">
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
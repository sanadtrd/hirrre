<?php
session_start();
include('config.php');
$email = $_SESSION["email"] ;
$sql = "SELECT * FROM individuals WHERE email = '$email'";
$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_array($result);
    $_SESSION["id"] = $row['id'];
    $_SESSION["name"] = $row['name'];
    $_SESSION["password"] = $row['password'];
    $_SESSION["username"] = $row['username'];
    $_SESSION["email"] = $row['email'];
    $_SESSION["cp"] = $row['current_position'];
    $_SESSION["des"] = $row['description'];
    $_SESSION["mcheck"] = $row['mcheck'];

    //get suggestions
    $cp= $_SESSION["cp"] ;
    $sqlcp = "SELECT company_id,job_title,job_type,experience,salary,o_description,name FROM offered_jobs LEFT JOIN companies ON offered_jobs.company_id = companies.id WHERE offered_jobs.job_title ='$cp' OR offered_jobs.job_title LIKE'%$cp%'" ;
    $cpresult = mysqli_query($connect, $sqlcp);
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

<?php if ($mresult == 1) : ?>
    <div class="menu">
    <a href="homeid.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeid.php"><p class="menu-text  selected">Home</p></a>
    <a href="profile-in.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text"><?php echo $_SESSION["name"] ?></p></a>
    <a href="settings.php"><button class="btn">Settings</button></a>
    <a href="logout.php"><button class="btn btn-r">Logout</button></a>
    </div>
<?php endif; ?>



    <div class="white-sheet white-sheet-search shadow">
    <h1 class="white-sheet-title">Discover New Job</h1>
    <form class ="form-out"  action="searchid.php" method="GET">
        <input  class="input shadow" type="text" name="keywords" placeholder="Search by position or company">
        <input class=" btn btn-action shadow" style="margin-right:0px;"  type="submit" name="search" value="search">
        <!--Filter-->
        <input class=" hide" type="text" name="type" placeholder="Type">
        <input class=" hide" type="text" name="salary" placeholder="Salary minimum">
        <input class="hide" type="text" name="exp" placeholder="Experience">
        <input  class="hide" type="text" name="cfield" placeholder="Company Field">
    </form>
    </div>


    <div class="white-sheet shadow" style="height:auto;">
    <h1 class="white-sheet-title">For you</h1>

    <?php
    while($fetchcp= mysqli_fetch_array($cpresult)){
?>

    <div class="white-sheet shadow record">
    <a href="profile-com.php?id= <?php echo $fetchcp['company_id'] ?>" ><h1 class="white-sheet-title"><?php echo $fetchcp['name'];?> - <?php echo $fetchcp['job_title'];?></h1></a>
    <section class="moreinfo">
    <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Job type: <?php echo $fetchcp['job_type'];?> </label> 
    <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;"> Salary: <?php echo $fetchcp['salary'];?> </label> 
    <label class="label-fix" style="grid-column: 3/4; grid-row:1/2;"> Experience : <?php echo $fetchcp['experience'];?>  years</label> 
    </section>
    <p class="edit-des"><?php echo $fetchcp['o_description'];?></p>
    <button class="btn btn-ex btn-apply" style="grid-column:1/3;">Apply</button></a>
    </div>
    <?php
    }
    mysqli_free_result($cpresult);
?>
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
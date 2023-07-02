<?php
session_start();
include('config.php');
$check = false;
$mresult = 0;



if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($connect, $_GET['id']);

    //company
    if (isset($_SESSION["id"])){
        $mcheck = $_SESSION["mcheck"] ;
        if ($id == $_SESSION["id"] && ($mcheck ==2)){
            $check = true;
            include('jobs.php');
        }
    }

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

    //info
    $infosql = "SELECT * FROM companies WHERE id = $id";
    $inforesult = mysqli_query($connect, $infosql);
    $fetchinfo = mysqli_fetch_assoc($inforesult);
    mysqli_free_result($inforesult);


    // jobs
    $jobsql = "SELECT * FROM offered_jobs WHERE company_id = $id";
    $jobresult = mysqli_query($connect, $jobsql);
    mysqli_close($connect);
}
?>


<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
<title><?php echo $fetchinfo['name']; ?></title>
</header>
<style>
.hide{
    display:none;
}

</style>
<body>

<?php if ($mresult == 2) : ?>
<div class="menu">
    <a href="homecom.php"> <img class="logo" src="logo.svg"></a>
    <a href="homecom.php"><p class="menu-text">Home</p></a>
    <a href="profile-com.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text"><?php echo $_SESSION["name"] ?></p></a>
    <a href="settingscom.php"><button class="btn">Settings</button></a>
    <a href="logout.php"><button class="btn btn-r">Logout</button></a>
</div>
<?php elseif ($mresult == 1): ?>

    <div class="menu">
    <a href="homeid.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeid.php"><p class="menu-text">Home</p></a>
    <a href="profile-in.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text"><?php echo $_SESSION["name"] ?></p></a>
    <a href="settings.php"><button class="btn">Settings</button></a>
    <a href="logout.php"><button class="btn btn-r">Logout</button></a>
    </div>

<?php else: ?>
    <div class="menu">
    <a href="homeout.php"> <img class="logo" src="logo.svg"></a>
    <a href="homeout.php"><p class="menu-text">Home</p></a>
    <a href="support.html"><p class="menu-text">Support</p></a>
    <a href="sign-in.php"><button class="btn">Sign in</button></a>
    <a href="register.php"><button class="btn btn-r">Register</button></a>
    </div>

<?php endif; ?>


<!--INFO-->
<div class="profile-pic shadow"><img class="bi" src="pic.png"></div>
<h1 class="name"><?php echo $fetchinfo['name']; ?></h1>
<div class="info-pack">
        <div class="info shadow"><a href="<?php echo $fetchinfo['website']; ?>" class="info-text purple" ><h6 class="info-text purple"><?php echo $fetchinfo['website']; ?></h6></a></div>
        <div class="info shadow"><h6 class="info-text purple"><?php echo $fetchinfo['location']; ?></h6></div>
</div>

<!--INFO END-->


<!--Overview-->
<section class="overview-pack">
<div class="white-sheet white-sheet-skill shadow">
    <h1 class="white-sheet-title">Info</h1>
    <div class="underline"></div>
    <ul>
        <li>Field:</li>
        <li> <?php echo $fetchinfo['field']; ?></li>


    </ul>

</div>
<div class="white-sheet white-sheet-overview shadow">
    <h1 class="white-sheet-title">Overview</h1>
    <p class="overview-desc">
     <?php echo $fetchinfo['description']; ?>
    </p>
</div>
</section>
<!--Overview END-->


<!--Jobs-->
<div id ="job" class="white-sheet white-sheet-edit shadow">
    <h1 class="white-sheet-title">Jobs Offered</h1>

    <?php if ($check == true): ?>
        <form class ="form-edit" action="jobs.php" method="post">
            <input type="hidden" name="idjob" value="<?php echo $idjob?>">

            <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Job Title: </label> 
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:1/2;" type="text" placeholder="Enter Job title" name="jobtitle" value="<?php echo $jobtitle ?>">

            <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Job Type: </label>
            <input class="input input-table shadow"style="grid-column: 2/3; grid-row:1/2;" type="text" placeholder="Enter Job type" name="jobtype" value="<?php echo $jobtype ?>" >

            <label class="label-fix" style="grid-column: 1/2; grid-row:2/3;">Experience: </label>
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:2/3;" type="text" placeholder="Enter years" name="exp" value="<?php echo $exp ?>">

            <label class="label-fix label-fix2" style="grid-column: 2/3; grid-row:2/3;">Salary: </label>
            <input class="input input-table shadow" style="grid-column: 2/3; grid-row:2/3;" type="text" placeholder="Enter salary" name="salary" value="<?php echo $salary ?>">

            <textarea class=" area-fix shadow" type="text" placeholder="Enter Description" name="dis"> <?php echo $dis ?> </textarea>

            <?php if ($update == true): ?>
                <input class="btn btn-f btn-edit" type="submit" name="update" value="update">
            <?php else: ?>
                <input  class="btn btn-f btn-edit" type="submit" name="submit" value="submit">
            <?php endif; ?>
        </form>
    <?php endif; ?>

     <!--RECORDS-->
     <?php while($fetchjob= mysqli_fetch_array($jobresult)){ ?>

    <div class="white-sheet shadow record">
    <h1 class="white-sheet-title"><?php echo $fetchjob['job_title']; ?></h1>
    <section class="moreinfo">
    <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;"><?php echo $fetchjob['job_type']; ?> </label> 
    <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Experience: <?php echo $fetchjob['experience']; ?> years </label> 
    <label class="label-fix" style="grid-column: 3/4; grid-row:1/2;">Salary: <?php echo $fetchjob['salary']; ?> </label> 
    </section>
    
    <p class="edit-des"><?php echo $fetchjob['o_description']; ?></p>



    <?php if ($check == true): ?>
        <a href="profile-com.php?id=<?php echo $id ?>&edit=<?php echo $fetchjob ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">edit</button></a>
        <a href="profile-com.php?id=<?php echo $id ?>&delete=<?php echo $fetchjob ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">delete</button></a>
    <?php else: ?>
    <button class="btn btn-ex btn-apply" style="grid-column:1/3;">Apply</button></a>
    <?php endif; ?>
    </div>
    <?php } mysqli_free_result($jobresult);?>

    <!--END RECORDS-->


</div>


<!--Jobs END-->

<div class="footer">
    <a class="footer-fix" href="homeout.php"> <img class="footer-logo" src="logo.svg"> </a>
     <div class="footer-white shadow"></div>
     <p class="footer-rights">Copyright © 2020 Hirrre Inc. All rights reserved.</p>
 </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/core.js"></script>
<script src="js/index.js"></script>
</html>

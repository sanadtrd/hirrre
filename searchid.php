<?php
    session_start();
    include('config.php');
    if (isset($_SESSION["id"])){
        $mcheck = $_SESSION["mcheck"] ;
    }
    $mresult = 0;
    $output= false;

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


$keywords= $type =$salary = $exp = $cfield= '';
$errors = array('keywords' => '', 'type' => '', 'salary' => '' , 'exp' => '', 'cfield' => '');

if(isset($_GET['search'])){
    if(empty($_GET['keywords'])){
        $errors['keywords'] = ' | Enter something';
    } else{
        $keywords = mysqli_real_escape_string($connect, $_GET['keywords']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $keywords)){
            $errors['keywords'] = 'Search inputs must be letters and spaces only';
        }
    } 

//Filter input
$type = mysqli_real_escape_string($connect, $_GET['type']);
$salary = mysqli_real_escape_string($connect, $_GET['salary']);
$exp = mysqli_real_escape_string($connect, $_GET['exp']);
$cfield = mysqli_real_escape_string($connect, $_GET['cfield']);
//Filter inputs end

/*FILTER EEORRS */

/*FILTER EEORRS END */
if(array_filter($errors)){
        //echo 'errors in form';
} else {
            if( ($type !="") || ($salary !="") || ($exp !="") || ($cfield !="") ){
                $sqlcname = "SELECT company_id,job_title,job_type,experience,salary,o_description,name,field FROM offered_jobs 
                LEFT JOIN companies ON offered_jobs.company_id = companies.id 
                WHERE  companies.name ='$keywords' OR offered_jobs.job_type ='$type' OR offered_jobs.experience ='$exp' 
                OR offered_jobs.salary ='$salary' OR companies.field ='$cfield'  ";

                $sqljtitle = "SELECT company_id,job_title,job_type,experience,salary,o_description,name,field FROM offered_jobs 
                LEFT JOIN companies ON offered_jobs.company_id = companies.id 
                WHERE offered_jobs.job_title ='$keywords'
                OR offered_jobs.job_type ='$type' OR offered_jobs.experience ='$exp'
                OR offered_jobs.salary ='$salary' OR companies.field ='$cfield'";

            }else{
                //take this 2 lines for companies ignore else and if parent:
                $sqlcname = "SELECT company_id,job_title,job_type,experience,salary,o_description,name FROM offered_jobs LEFT JOIN companies ON offered_jobs.company_id = companies.id WHERE companies.name ='$keywords'  ";
                $sqljtitle = "SELECT company_id,job_title,job_type,experience,salary,o_description,name FROM offered_jobs LEFT JOIN companies ON offered_jobs.company_id = companies.id WHERE offered_jobs.job_title ='$keywords' or offered_jobs.job_title LIKE'%$keywords%' ";
            }

            $resultcname = mysqli_query($connect, $sqlcname);
            $resultjtitle = mysqli_query($connect, $sqljtitle);
        
            if(mysqli_num_rows($resultcname) > 0){
                $output= true;
                $result = $resultcname;
                
                }elseif(mysqli_num_rows($resultjtitle) > 0){
                    $result = $resultjtitle;
                    $output= true;
                }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdn.rawgit.com/mfd/09b70eb47474836f25a21660282ce0fd/raw/e06a670afcb2b861ed2ac4a1ef752d062ef6b46b/Gilroy.css">
<title>Search</title>
</header>
<style>
.record{
    grid-column:1/13;
    margin: 35px 0px;
}
</style>

<body>

<?php if ($mresult == 1): ?>
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
    <a href="support.php"><p class="menu-text">Support</p></a>
    <a href="sign-in.php"><button class="btn">Sign in</button></a>
    <a href="register.php"><button class="btn btn-r">Register</button></a>
    </div>

<?php endif; ?>

<div class="white-sheet white-sheet-search white-sheet-sid shadow">
    <h1 class="white-sheet-title">Discover New Job  <?php  echo $errors['keywords']; ?></h1>
    <form class ="form-out"  action="searchid.php" method="GET">
        <input style="grid-column:1/3; grid-row:1/2;" class="input shadow" type="text" name="keywords" placeholder="Search by position or company" value="<?php echo $keywords ?>">
        <input style="grid-column:2/3; grid-row:4/5; justify-self:end; margin-right:0px;" class=" btn btn-action shadow" type="submit" name="search" value="search">
        <!--Filter-->
        <input  style="grid-column:1/2; grid-row:2/3;" class="shadow input input-form" type="text" name="type" placeholder="Type" value="<?php echo $type ?>" >
        <input style="grid-column:2/3; grid-row:2/3;" class="shadow input input-form" type="text" name="salary" placeholder="Salary minimum" value="<?php echo $salary ?>">
        <input style="grid-column:1/2; grid-row:3/4;" class="shadow input input-form" type="text" name="exp" placeholder="Experience" value="<?php echo $exp ?>">
        <input  style="grid-column:2/3; grid-row:3/4;" class="shadow input input-form" type="text" name="cfield" placeholder="Company Field" value="<?php echo $cfield ?>">
    </form>
</div>

        
 

        <?php
        if($output == true){ 
        ?>
        <h2 class="result">Showing results for <?php echo $keywords; ?></h2>
            <?php  while($fetch= mysqli_fetch_array($result)){
        ?>

<div class="white-sheet shadow record">
    <a href="profile-com.php?id= <?php echo $fetch['company_id'] ?>" class="white-sheet-title-fix"><h1 class="white-sheet-title"><?php echo $fetch['name'];?> - <?php echo $fetch['job_title'];?></h1></a>
    <section class="moreinfo">
    <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Job type: <?php echo $fetch['job_type'];?> </label> 
    <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;"> Salary: <?php echo $fetch['salary'];?></label> 
    <label class="label-fix" style="grid-column: 3/4; grid-row:1/2;"> Experience : <?php echo $fetch['experience'];?>  years </label> 
    </section>
    <p class="edit-des"><?php echo $fetch['o_description'];?></p>
    <button class="btn btn-ex btn-apply" style="grid-column:1/3;">Apply Now</button></a>
</div>

        <?php
            }}
        
        ?>


<div class="footer">
    <a class="footer-fix" href="homeout.php"> <img class="footer-logo" src="logo.svg"> </a>
     <div class="footer-white shadow"></div>
     <p class="footer-rights">Copyright © 2020 Hirrre Inc. All rights reserved.</p>
 </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/core.js"></script>
<script src="js/index.js"></script>
</html>
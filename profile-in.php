<?php
    session_start();
    include('config.php');
    $check = false;
    $mresult = 0;



	if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($connect, $_GET['id']);

        if (isset($_SESSION["id"])){
            $mcheck = $_SESSION["mcheck"] ;
            if ($id == $_SESSION["id"] && ($mcheck ==1)){
                $check = true;
                include('edu.php');
                include('exp.php');
                include('acom.php');
    
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

      
 

		// escape sql chars

        //info
        $infosql = "SELECT * FROM individuals WHERE id = $id";
        $inforesult = mysqli_query($connect, $infosql);
        $fetchinfo = mysqli_fetch_assoc($inforesult);
        mysqli_free_result($inforesult);

        // education
        $edusql = "SELECT * FROM individuals_education WHERE individual_id = $id";
        $eduresult = mysqli_query($connect, $edusql);


        //experience
        $expsql = "SELECT * FROM individuals_experience WHERE individual_id = $id";
        $expresult = mysqli_query($connect, $expsql);


        //accomplishments
        $accsql = "SELECT * FROM individuals_accomp WHERE individual_id = $id";
        $accresult = mysqli_query($connect, $accsql);



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
    <a href="profile-in.php?id= <?php echo $_SESSION["id"] ?> "><p class="menu-text "><?php echo $_SESSION["name"] ?></p></a>
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
        <div class="info shadow" style="grid-column:1/3;"><h6 class="info-text purple"><?php echo $fetchinfo['current_position']; ?></h6></div>
</div>

<!--INFO END-->


<!--Overview-->
<div class="white-sheet shadow">
    <h1 class="white-sheet-title">Description</h1>
    <p class="overview-desc">
    <?php echo $fetchinfo['description']; ?>
    </p>
</div>

<!--Overview END-->


<!--Edu-->
<div id="edu" class="white-sheet white-sheet-edit shadow">
    <h1 class="white-sheet-title">Education </h1>

    <?php if ($check == true): ?>
        <form class ="form-edit form-id-fix" action="edu.php" method="post">
         <input type="hidden" name="idedu" value="<?php echo $idedu ?>">

            <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Instution: <?php echo $errorsedu['ins'];?></label> 
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:1/2;" type="text" placeholder="Enter Instution name" name="ins" value="<?php echo $ins ?>">


            <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Type: </label>
            <input class="input input-table shadow"style="grid-column: 2/3; grid-row:1/2;" type="text" placeholder="Enter  type" name="type" value="<?php echo $type ?>" >


            <label class="label-fix" style="grid-column: 1/2; grid-row:2/3;">Start Year: </label>
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:2/3;" type="text" placeholder="Enter start year" name="startyear" value="<?php echo $startyear ?>">


            <label class="label-fix label-fix2" style="grid-column: 2/3; grid-row:2/3;">End Year: </label>
            <input class="input input-table shadow" style="grid-column: 2/3; grid-row:2/3;" type="text" placeholder="Enter end year" name="endyear" value="<?php echo $endyear ?>">


            <?php if ($updateedu == true): ?>
                <input class="btn btn-f btn-edit" type="submit" name="updateedu" value="update">
            <?php else: ?>
                <input  class="btn btn-f btn-edit" type="submit" name="submitedu" value="submit">
            <?php endif; ?>
        </form>
    <?php endif; ?>

     <!--RECORDS-->
     <?php while($fetchedu= mysqli_fetch_array($eduresult)){ ?>

    <div class="white-sheet shadow record">
    <h1 class="white-sheet-title"><?php echo $fetchedu['institution_name']; ?></h1>
    <section class="moreinfo">
    <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Type: <?php echo $fetchedu['ins_type']; ?></label> 
    <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Start Year: <?php echo $fetchedu['start_year']; ?> </label> 
    <label class="label-fix" style="grid-column: 3/4; grid-row:1/2;">End Year: <?php echo $fetchedu['end_year']; ?></label> 
    </section>
    

    <?php if ($check == true): ?>
        <a href="profile-in.php?id=<?php echo $id ?>&editedu=<?php echo $fetchedu ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">edit</button></a>
        <a href="profile-in.php?id=<?php echo $id ?>&deleteedu=<?php echo $fetchedu ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">delete</button></a>
    <?php endif; ?>
    </div>
    <?php } mysqli_free_result($eduresult);?>

    <!--END RECORDS-->

</div>
<!--EDU END-->



<!--EXP-->
<div  id="exp" class="white-sheet white-sheet-edit shadow">
    <h1 class="white-sheet-title">Experience </h1>
    <?php if ($check == true): ?>
        <form class ="form-edit form-id-fix" action="exp.php" method="post">
         <input type="hidden" name="idexp" value="<?php echo $idexp ?>">

            <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Company Name: </label> 
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:1/2;" type="text" placeholder="Enter Company name" name="compname" value="<?php echo $compname ?>">


            <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Position: </label>
            <input class="input input-table shadow"style="grid-column: 2/3; grid-row:1/2;" type="text" placeholder="Enter  Position" name="position" value="<?php echo $position ?>" >


            <label class="label-fix" style="grid-column: 1/2; grid-row:2/3;">Start Year: </label>
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:2/3;" type="text" placeholder="Enter start year" name="startwyear" value="<?php echo $startwyear ?>">


            <label class="label-fix label-fix2" style="grid-column: 2/3; grid-row:2/3;">End Year: </label>
            <input class="input input-table shadow" style="grid-column: 2/3; grid-row:2/3;" type="text" placeholder="Enter end year" name="endwyear" value="<?php echo $endwyear ?>">


            <?php if ($updateexp == true): ?>
                <input class="btn btn-f btn-edit" type="submit" name="updateexp" value="update">
            <?php else: ?>
                <input  class="btn btn-f btn-edit" type="submit" name="submitexp" value="submit">
            <?php endif; ?>
        </form>
    <?php endif; ?>

     <!--RECORDS-->
     <?php while($fetchexp= mysqli_fetch_array($expresult)){ ?>

    <div class="white-sheet shadow record">
    <h1 class="white-sheet-title"><?php echo $fetchexp['company_name']; ?></h1>
    <section class="moreinfo">
    <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Position: <?php echo $fetchexp['position']; ?></label> 
    <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Start Year: <?php echo $fetchexp['start_wyear']; ?></label> 
    <label class="label-fix" style="grid-column: 3/4; grid-row:1/2;">End Year: <?php echo $fetchexp['end_wyear']; ?></label> 
    </section>
    

    <?php if ($check == true): ?>
        <a href="profile-in.php?id=<?php echo $id ?>&editexp=<?php echo $fetchexp ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">edit</button></a>
        <a href="profile-in.php?id=<?php echo $id ?>&deleteexp=<?php echo $fetchexp ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">delete</button></a>
    <?php endif; ?>
    </div>
    <?php } mysqli_free_result($expresult);?>

    <!--END RECORDS-->

</div>
<!--EXP END-->



<!--ACC-->
<div  id="acc"  class="white-sheet white-sheet-edit shadow">
    <h1 class="white-sheet-title">Accomplishments </h1>
    <?php if ($check == true): ?>
        <form class ="form-edit form-id-fix" action="acom.php" method="post">
        <input type="hidden" name="idacc" value="<?php echo $idacc ?>">


            <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;"> Title: </label> 
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:1/2;" type="text" placeholder="Enter Title" name="acctitle" value="<?php echo $acctitle ?>">


            <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;">Type: </label>
            <input class="input input-table shadow"style="grid-column: 2/3; grid-row:1/2;" type="text" placeholder="Enter Type" name="acctype" value="<?php echo $acctype ?>" >


            <label class="label-fix" style="grid-column: 1/2; grid-row:2/3;">Year: </label>
            <input class="input input-table shadow" style="grid-column: 1/2; grid-row:2/3;" type="text" placeholder="Enter Year" name="year" value="<?php echo $year ?>">


            <?php if ($updateacc == true): ?>
                <input class="btn btn-f btn-edit" type="submit" name="updateacc" value="update">
            <?php else: ?>
                <input  class="btn btn-f btn-edit" type="submit" name="submitacc" value="submit">
            <?php endif; ?>
        </form>
    <?php endif; ?>

     <!--RECORDS-->
     <?php while($fetchacc= mysqli_fetch_array($accresult)){ ?>

    <div class="white-sheet shadow record">
    <h1 class="white-sheet-title"><?php echo $fetchacc['acc_title']; ?></h1>
    <section class="moreinfo">
    <label class="label-fix" style="grid-column: 1/2; grid-row:1/2;">Type : <?php echo $fetchacc['acc_type']; ?></label> 
    <label class="label-fix" style="grid-column: 2/3; grid-row:1/2;"> Year: <?php echo $fetchacc['year']; ?></label> 
    </section>
    

    <?php if ($check == true): ?>
        <a href="profile-in.php?id=<?php echo $id ?>&editacc=<?php echo $fetchacc ['id'] ?>" class=" btn-ex"><button class="btn btn-ex">edit</button></a>
        <a href="profile-in.php?id=<?php echo $id ?>&deleteacc=<?php echo $fetchacc['id'] ?>" class=" btn-ex"><button class="btn btn-ex">delete</button></a>
    <?php endif; ?>
    </div>
    <?php } mysqli_free_result($accresult);?>

    <!--END RECORDS-->

</div>
<!--ACC END-->


<!--NAVIGATION-->
<div class="footer">
    <a class="footer-fix" href="homeout.php"> <img class="footer-logo" src="logo.svg"> </a>
     <div class="footer-white shadow"></div>
     <p class="footer-rights">Copyright © 2020 Hirrre Inc. All rights reserved.</p>
 </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/core.js"></script>
<script src="js/index.js"></script>
</html>
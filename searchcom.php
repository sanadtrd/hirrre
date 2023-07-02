<?php
    session_start();
    include('config.php');
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

$output= false;
$keywords=  '';
$errors = array('keywords' => '');

if(isset($_GET['search'])){
    if(empty($_GET['keywords'])){
        $errors['keywords'] = ' | Enter something';
    } else{
        $keywords = mysqli_real_escape_string($connect, $_GET['keywords']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $keywords)){
            $errors['keywords'] = 'Search inputs must be letters and spaces only';
        }
    } 



if(array_filter($errors)){
        //echo 'errors in form';
} else {

         $sql = "SELECT id,name ,current_position,description FROM individuals  WHERE name ='$keywords' or name LIKE'%$keywords%' or current_position ='$keywords' or current_position LIKE'%$keywords%' ";
         $result = mysqli_query($connect, $sql);
            if(mysqli_num_rows($result) > 0){
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
<style>
.white-sheet{
    grid-column:1/13;
    justify-self:center;
}
.white-sheet-title{
    grid-column:1/3;
}

.edit-des{
    grid-column:1/3;
    grid-row:2/3;
}
.white-sheet-title-fix{
    grid-column:1/3;
}
.form-out{
    grid-template-columns:1fr;
}


</style>
<title>Search</title>
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

        <div class="white-sheet white-sheet-search shadow">
        <h1 class="white-sheet-title">Discover New staff <?php echo $errors['keywords']; ?></h1>
		<form class ="form-out"  action="searchcom.php" method="GET">
        <input  class="input shadow" type="text" name="keywords" placeholder="Search ">
        <input class=" btn btn-action shadow"  style="margin-right:0px;" type="submit" name="search" value="search">
        </form>
        </div>
        
 

        
        <?php
        if($output == true){ 
        ?>
        <h2 class="result">Showing results for <?php echo $keywords; ?></h2>
            <?php  while($fetch= mysqli_fetch_array($result)){
        ?>


        <div class="white-sheet shadow record">
        <a href="profile-in.php?id= <?php echo $fetch['id'] ?>"   class="white-sheet-title-fix"><h1 class="white-sheet-title"><?php echo $fetch['name'];?> - <?php echo $fetch['current_position'];?></h1></a>
        <p class="edit-des"><?php echo $fetch['description'];?></p>
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
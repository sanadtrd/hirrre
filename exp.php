<?php
    @session_start();
    $sid= $_SESSION["id"];
    include('config.php');
  
    //Submit new
    $updateexp=false;
    $idexp = 0;
    $compname = $position = $startwyear = $endwyear = '';
    $errors = array('compname' => '', 'position' => '', 'startwyear' => '' , 'endwyear' => '');
    
    if(isset($_POST['submitexp'])){
        if(empty($_POST['compname'])){
            $errors['compname'] = 'Campany name is required';
        } else{
            $compname = $_POST['compname'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $compname)){
            $errors['compname'] = 'Company name must be letters and spaces only';
            }
        }

        if(empty($_POST['position'])){
            $errors['position'] = 'Position is required';
        } else{
            $position= $_POST['position'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $position)){
            $errors['position'] = 'Position must be letters and spaces only';
            }
        }

        if(empty($_POST['startwyear'])){
            $errors['startwyear'] = 'Start year is required';
        } else{
            $startwyear = $_POST['startwyear'];
            if(!is_numeric($startwyear)){
                $errors['startwyear'] = 'Start year must be a number';
                }
        }

        if(empty($_POST['endwyear'])){
            $errors['endwyear'] = 'End year is required';
        } else{
            $endwyear = $_POST['endwyear'];
            if(!is_numeric($endwyear)){
                $errors['endwyear'] = 'End year must be a number';
                }
        }
    
    if(array_filter($errors)){
        //echo 'errors in form';
    } else {
        // escape sql chars
        $compname = mysqli_real_escape_string($connect, $_POST['compname']);
        $position = mysqli_real_escape_string($connect, $_POST['position']);
        $startwyear = mysqli_real_escape_string($connect, $_POST['startwyear']);
        $endwyear = mysqli_real_escape_string($connect, $_POST['endwyear']);

        // create sql
        $sql = "INSERT INTO individuals_experience(individual_id,company_name,position,start_wyear,end_wyear) VALUES('$sid','$compname','$position','$startwyear','$endwyear')";

        // save to db and check
        if(mysqli_query($connect, $sql)){
            // success
            header("Location: profile-in.php?id=$sid");
        } else {
            echo 'query error: '. mysqli_error($connect);
        }

    }
}

    //Edit
    if(isset($_GET['editexp'])){
        $idexp = mysqli_real_escape_string($connect, $_GET['editexp']);
        $updateexp = true;
        $sql = "SELECT * FROM individuals_experience WHERE id=$idexp";
        $result = mysqli_query($connect, $sql);

        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_array($result);
            $compname = $row['company_name'];
            $position = $row['position'];
            $startwyear = $row['start_wyear'];
            $endwyear = $row['end_wyear'];
        }
        
    }

    if(isset($_POST['updateexp'])){

        if(empty($_POST['compname'])){
            $errors['compname'] = 'Campany name is required';
        } else{
            $compname = $_POST['compname'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $compname)){
            $errors['compname'] = 'Company name must be letters and spaces only';
            }
        }

        if(empty($_POST['position'])){
            $errors['position'] = 'Position is required';
        } else{
            $position= $_POST['position'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $position)){
            $errors['position'] = 'Position must be letters and spaces only';
            }
        }

        if(empty($_POST['startwyear'])){
            $errors['startwyear'] = 'Start year is required';
        } else{
            $startwyear = $_POST['startwyear'];
            if(!is_numeric($startwyear)){
                $errors['startwyear'] = 'Start year must be a number';
                }
        }

        if(empty($_POST['endwyear'])){
            $errors['endwyear'] = 'End year is required';
        } else{
            $endwyear = $_POST['endwyear'];
            if(!is_numeric($endwyear)){
                $errors['endwyear'] = 'End year must be a number';
                }
        }
        
        if(array_filter($errors)){
            //echo 'errors in form';
            $compname = $position = $startwyear = $endwyear = '';
        } else {
            // escape sql chars
            $idexp = mysqli_real_escape_string($connect, $_POST['idexp']);
            $compname = mysqli_real_escape_string($connect, $_POST['compname']);
            $position = mysqli_real_escape_string($connect, $_POST['position']);
            $startwyear = mysqli_real_escape_string($connect, $_POST['startwyear']);
            $endwyear = mysqli_real_escape_string($connect, $_POST['endwyear']);
        $sql = "UPDATE individuals_experience SET company_name = '$compname', position = '$position' , start_wyear = '$startwyear', end_wyear ='$endwyear' WHERE id=$idexp";



        if(mysqli_query($connect, $sql)){
            // success
            header("Location: profile-in.php?id=$sid");
        } else {
            echo 'query error: '. mysqli_error($connect);


        }
        }
    }

    //Delete
    if(isset($_GET['deleteexp'])){
        $id = mysqli_real_escape_string($connect, $_GET['deleteexp']);
        $sql = "DELETE FROM individuals_experience WHERE id=$id";
        $result = mysqli_query($connect, $sql);
        header("Location: profile-in.php?id=$sid");

    }

    ?>

<body style="font-family:sans-serif;">
    <div class="hide" style="text-align:center;">
    <?php echo $errors['compname']; ?><br><br>
    <?php echo $errors['position']; ?><br><br>
    <?php echo $errors['startwyear']; ?><br><br>
    <?php echo $errors['endwyear']; ?><br><br>
    <a  href="profile-in.php?id=<?php echo $sid;?>" style="text-decoration:none; color:blue; margin:25px 0px;">back</a>
    </div>
</body>




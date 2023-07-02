<?php
    @session_start();
    $sid= $_SESSION["id"];
    include('config.php');
  
    //Submit new
    $updateacc=false;
    $idacc = 0;
    $acctitle = $acctype = $year = '';
    $errors = array('acctitle' => '', 'acctype' => '', 'year' => '' );
    
    if(isset($_POST['submitacc'])){
        if(empty($_POST['acctitle'])){
            $errors['acctitle'] = 'Title is required';
        } else{
            $acctitle = $_POST['acctitle'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $acctitle)){
            $errors['acctitle'] = 'Title must be letters and spaces only';
            }
        }

        if(empty($_POST['acctype'])){
            $errors['acctype'] = 'Type is required';
        } else{
            $acctype= $_POST['acctype'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $acctype)){
            $errors['acctype'] = 'Type must be letters and spaces only';
            }
        }

        if(empty($_POST['year'])){
            $errors['year'] = 'Year is required';
        } else{
            $year = $_POST['year'];
            if(!is_numeric($year)){
                $errors['year'] = 'Year must be a number';
                }
        }

    
    if(array_filter($errors)){
        //echo 'errors in form';
    } else {
        // escape sql chars
        $acctitle = mysqli_real_escape_string($connect, $_POST['acctitle']);
        $acctype = mysqli_real_escape_string($connect, $_POST['acctype']);
        $year = mysqli_real_escape_string($connect, $_POST['year']);
        // create sql
        $sql = "INSERT INTO individuals_accomp(individual_id,acc_title,acc_type,year) VALUES('$sid','$acctitle','$acctype','$year')";

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
    if(isset($_GET['editacc'])){
        $idacc = mysqli_real_escape_string($connect, $_GET['editacc']);
        $updateacc = true;
        $sql = "SELECT * FROM individuals_accomp WHERE id=$idacc";
        $result = mysqli_query($connect, $sql);

        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_array($result);
            $acctitle = $row['acc_title'];
            $acctype = $row['acc_type'];
            $year = $row['year'];

        }
        

    }

    if(isset($_POST['updateacc'])){

        if(empty($_POST['acctitle'])){
            $errors['acctitle'] = 'Title is required';
        } else{
            $acctitle = $_POST['acctitle'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $acctitle)){
            $errors['acctitle'] = 'Title must be letters and spaces only';
            }
        }

        if(empty($_POST['acctype'])){
            $errors['acctype'] = 'Type is required';
        } else{
            $acctype= $_POST['acctype'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $acctype)){
            $errors['acctype'] = 'Type must be letters and spaces only';
            }
        }

        if(empty($_POST['year'])){
            $errors['year'] = 'Year is required';
        } else{
            $year = $_POST['year'];
            if(!is_numeric($year)){
                $errors['year'] = 'Year must be a number';
                }
        }

        if(array_filter($errors)){
            //echo 'errors in form';
            $acctitle = $acctype = $year ='';
        } else {
        $idacc = mysqli_real_escape_string($connect, $_POST['idacc']);
        $acctitle = mysqli_real_escape_string($connect, $_POST['acctitle']);
        $acctype = mysqli_real_escape_string($connect, $_POST['acctype']);
        $year = mysqli_real_escape_string($connect, $_POST['year']);
        $sql = "UPDATE individuals_accomp SET acc_title = '$acctitle', acc_type = '$acctype' , year = '$year' WHERE id=$idacc";



        if(mysqli_query($connect, $sql)){
            // success
            header("Location: profile-in.php?id=$sid");
        } else {
            echo 'query error: '. mysqli_error($connect);


        }
        }
    }

    //Delete
    if(isset($_GET['deleteacc'])){
        $id = mysqli_real_escape_string($connect, $_GET['deleteacc']);
        $sql = "DELETE FROM individuals_accomp WHERE id=$id";
        $result = mysqli_query($connect, $sql);
        header("Location: profile-in.php?id=$sid");

    }

    ?>

<body style="font-family:sans-serif;">
    <div class="hide" style="text-align:center;">
    <?php echo $errors['acctitle'];?><br><br>
    <?php echo $errors['acctype']; ?><br><br>
    <?php echo $errors['year']; ?><br><br>
    <a  href="profile-in.php?id=<?php echo $sid;?>" style="text-decoration:none; color:blue; margin:25px 0px;">back</a>
    </div>
</body>



     
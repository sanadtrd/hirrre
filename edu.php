<?php
    @session_start();
    $sid= $_SESSION["id"];
    include('config.php');
    //Submit new
    $updateedu=false;
    $idedu = 0;
    $ins = $type = $startyear = $endyear = '';
    $errorsedu = array('ins' => '', 'type' => '', 'startyear' => '' , 'endyear' => '');
    
    if(isset($_POST['submitedu'])){
        if(empty($_POST['ins'])){
            if(empty($_POST['ins'])){
                $errorsedu['ins'] = 'Institution name is required';
            } else{
                $ins = $_POST['ins'];
                if(!preg_match('/^[a-zA-Z\s]+$/', $ins)){
                $errorsedu['ins'] = 'Institution name must be letters and spaces only';
                }
            }
    
            if(empty($_POST['type'])){
                $errorsedu['type'] = 'Type is required';
            } else{
                $type= $_POST['type'];
                if(!preg_match('/^[a-zA-Z\s]+$/', $type)){
                $errorsedu['type'] = 'Type must be letters and spaces only';
                }
            }
    
            if(empty($_POST['startyear'])){
                $errorsedu['startyear'] = 'Start year is required';
            } else{
                $startyear = $_POST['startyear'];
                if(!is_numeric($startyear)){
                    $errorsedu['startyear'] = 'Start year must be a number';
                    }
            }
    
            if(empty($_POST['endyear'])){
                $errorsedu['endyear'] = 'End year is required';
            } else{
                $endyear = $_POST['endyear'];
                if(!is_numeric($endyear)){
                    $errorsedu['endyear'] = 'End year must be a number';
                    }
            }
    
    if(array_filter($errorsedu)){
        
    } else {
        // escape sql chars
        $ins = mysqli_real_escape_string($connect, $_POST['ins']);
        $type = mysqli_real_escape_string($connect, $_POST['type']);
        $startyear = mysqli_real_escape_string($connect, $_POST['startyear']);
        $endyear = mysqli_real_escape_string($connect, $_POST['endyear']);
        // create sql
        $sql = "INSERT INTO individuals_education(individual_id,institution_name,ins_type,start_year,end_year) VALUES('$sid','$ins','$type','$startyear','$endyear')";

        // save to db and check
        if(mysqli_query($connect, $sql)){
            // success
            header("Location: profile-in.php?id=$sid");
        } else {
            echo 'query error: '. mysqli_error($connect);
        }

    }
}
    }
    //Edit
    if(isset($_GET['editedu'])){
        $idedu = mysqli_real_escape_string($connect, $_GET['editedu']);
        $updateedu = true;
        $sql = "SELECT * FROM individuals_education WHERE id=$idedu";
        $result = mysqli_query($connect, $sql);

        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_array($result);
            $ins = $row['institution_name'];
            $type = $row['ins_type'];
            $startyear = $row['start_year'];
            $endyear = $row['end_year'];
        }
        

    }

    if(isset($_POST['updateedu'])){

        if(empty($_POST['ins'])){
            $errorsedu['ins'] = 'Institution name is required';
        } else{
            $ins = $_POST['ins'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $ins)){
            $errorsedu['ins'] = 'Institution name must be letters and spaces only';
            }
        }

        if(empty($_POST['type'])){
            $errorsedu['type'] = 'Type is required';
        } else{
            $type= $_POST['type'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $type)){
            $errorsedu['type'] = 'Type must be letters and spaces only';
            }
        }

        if(empty($_POST['startyear'])){
            $errorsedu['startyear'] = 'Start year is required';
        } else{
            $startyear = $_POST['startyear'];
            if(!is_numeric($startyear)){
                $errorsedu['startyear'] = 'Start year must be a number';
                }
        }

        if(empty($_POST['endyear'])){
            $errorsedu['endyear'] = 'End year is required';
        } else{
            $endyear = $_POST['endyear'];
            if(!is_numeric($endyear)){
                $errorsedu['endyear'] = 'End year must be a number';
                }
        }

        if(array_filter($errorsedu)){
            //echo 'errors in form';
            $ins = $type = $startyear = $endyear = '';
        } else {
        $idedu = mysqli_real_escape_string($connect, $_POST['idedu']);
        $ins = mysqli_real_escape_string($connect, $_POST['ins']);
        $type = mysqli_real_escape_string($connect, $_POST['type']);
        $startyear = mysqli_real_escape_string($connect, $_POST['startyear']);
        $endyear = mysqli_real_escape_string($connect, $_POST['endyear']);
        $sql = "UPDATE individuals_education SET institution_name = '$ins', ins_type = '$type' , start_year = '$startyear', end_year ='$endyear' WHERE id=$idedu";



        if(mysqli_query($connect, $sql)){
            // success
            header("Location: profile-in.php?id=$sid");
        } else {
            echo 'query error: '. mysqli_error($connect);


        }
        }
    }

    //Delete
    if(isset($_GET['deleteedu'])){
        $id = mysqli_real_escape_string($connect, $_GET['deleteedu']);
        $sql = "DELETE FROM individuals_education WHERE id=$id";
        $result = mysqli_query($connect, $sql);
        header("Location: profile-in.php?id=$sid");

    }

    ?>
    <body style="font-family:sans-serif;">
    <div class="hide" style="text-align:center;">
    <?php echo $errorsedu['ins'];?><br><br>
    <?php echo $errorsedu['type'];?><br><br>
    <?php echo $errorsedu['startyear']; ?><br><br>
    <?php echo $errorsedu['endyear'];?><br><br>
    <a  href="profile-in.php?id=<?php echo $sid;?>" style="text-decoration:none; color:blue; margin:25px 0px;">back</a>
    </div>
    </body>
 





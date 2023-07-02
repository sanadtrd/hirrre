<?php
    @session_start();
    $sid= $_SESSION["id"];
    include('config.php');

$update=false;
$idjob = 0;
$jobtitle= $jobtype= $exp = $salary= $dis = '';
$errors = array('jobtitle' => '', 'jobtype' => '', 'exp' => '' , 'salary' => '', 'dis' => '');

if(isset($_POST['submit'])){
    if(empty($_POST['jobtitle'])){
        $errors['jobtitle'] = 'Job title is required';
    } else{
        $jobtitle = $_POST['jobtitle'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $jobtitle)){
        $errors['jobtitle'] = 'Job title must be letters and spaces only';
        }
    }

    if(empty($_POST['jobtype'])){
        $errors['jobtype'] = 'Jobtype is required';
    } else{
        $jobtype= $_POST['jobtype'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $jobtype)){
        $errors['jobtype'] = 'Jobtype must be letters and spaces only';
        }
    }

    if(empty($_POST['exp'])){
        $errors['exp'] = 'Experience is required';
    } else{
        $exp = $_POST['exp'];
        if(!is_numeric($exp)){
            $errors['exp'] = 'Experience must be a number';
            }
    }
    if(empty($_POST['salary'])){
        $errors['salary'] = 'Salary is required';
    } else{
        $salary = $_POST['salary'];
        if(!is_numeric($salary)){
            $errors['salary'] = 'Salary must be a number';
            }
    }
    
    if(empty($_POST['dis'])){
        $errors['dis'] = 'Description is required';
    } else{
        $dis = $_POST['dis'];
    }

if(array_filter($errors)){
    //echo 'errors in form';
} else {
    // escape sql chars
    $jobtitle = mysqli_real_escape_string($connect, $_POST['jobtitle']);
    $jobtype = mysqli_real_escape_string($connect, $_POST['jobtype']);
    $exp = mysqli_real_escape_string($connect, $_POST['exp']);
    $salary = mysqli_real_escape_string($connect, $_POST['salary']);
    $dis = mysqli_real_escape_string($connect, $_POST['dis']);
    $deleteid = 1;
    // create sql
    $sql = "INSERT INTO offered_jobs(company_id,job_title,job_type,experience,salary,o_description) VALUES('$deleteid','$jobtitle','$jobtype','$exp','$salary','$dis')";

    // save to db and check
    if(mysqli_query($connect, $sql)){
        // success
        header("Location: profile-com.php?id=$sid");
    } else {
        echo 'query error: '. mysqli_error($connect);
    }

}
}

//Edit
if(isset($_GET['edit'])){
    $idjob = mysqli_real_escape_string($connect, $_GET['edit']);
    $update = true;
    $sql = "SELECT * FROM offered_jobs WHERE id=$idjob";
    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result)==1){
        $row = mysqli_fetch_array($result);
        $jobtitle = $row['job_title'];
        $jobtype = $row['job_type'];
        $exp = $row['experience'];
        $salary = $row['salary'];
        $dis = $row['o_description'];
    }
    

}

if(isset($_POST['update'])){
    if(empty($_POST['jobtitle'])){
        $errors['jobtitle'] = 'Job title is required';
    } else{
        $jobtitle = $_POST['jobtitle'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $jobtitle)){
        $errors['jobtitle'] = 'Job title must be letters and spaces only';
        }
    }

    if(empty($_POST['jobtype'])){
        $errors['jobtype'] = 'Jobtype is required';
    } else{
        $jobtype= $_POST['jobtype'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $jobtype)){
        $errors['jobtype'] = 'Jobtype must be letters and spaces only';
        }
    }

    if(empty($_POST['exp'])){
        $errors['exp'] = 'Experience is required';
    } else{
        $exp = $_POST['exp'];
        if(!is_numeric($exp)){
            $errors['exp'] = 'Experience must be a number';
            }
    }
    if(empty($_POST['salary'])){
        $errors['salary'] = 'Salary is required';
    } else{
        $salary = $_POST['salary'];
        if(!is_numeric($salary)){
            $errors['salary'] = 'Salary must be a number';
            }
    }
    
    if(empty($_POST['dis'])){
        $errors['dis'] = 'Description is required';
    } else{
        $dis = $_POST['dis'];
    }


    if(array_filter($errors)){
        //echo 'errors in form';
        $jobtitle = $jobtype = $exp = $salary = $dis = '';
    } else {
    $idjob= mysqli_real_escape_string($connect, $_POST['idjob']);
    $jobtitle = mysqli_real_escape_string($connect, $_POST['jobtitle']);
    $jobtype = mysqli_real_escape_string($connect, $_POST['jobtype']);
    $exp = mysqli_real_escape_string($connect, $_POST['exp']);
    $salary = mysqli_real_escape_string($connect, $_POST['salary']);
    $dis = mysqli_real_escape_string($connect, $_POST['dis']);
    $sql = "UPDATE offered_jobs SET job_title = '$jobtitle', job_type = '$jobtype' , experience = '$exp', salary ='$salary', o_description ='$dis' WHERE id=$idjob";



    if(mysqli_query($connect, $sql)){
        // success
        header("Location: profile-com.php?id=$sid");
    } else {
        echo 'query error: '. mysqli_error($connect);


    }
    }
}

//Delete
if(isset($_GET['delete'])){
    $id = mysqli_real_escape_string($connect, $_GET['delete']);
    $sql = "DELETE FROM offered_jobs WHERE id=$id";
    $result = mysqli_query($connect, $sql);
    header("Location: profile-com.php?id=$sid");

}
?>
    <body style="font-family:sans-serif;">
    <div class="hide" style="text-align:center;">
    <?php echo $errors['jobtitle']; ?><br><br>
    <?php echo $errors['jobtype']; ?><br><br>
    <?php echo $errors['exp']; ?><br><br>
    <?php echo $errors['salary']; ?><br><br>
    <?php echo $errors['dis']; ?><br>
    <a  href="profile-com.php?id=<?php echo $sid;?>" style="text-decoration:none; color:blue; margin:25px 0px;">back</a>
    </div>
    </body>
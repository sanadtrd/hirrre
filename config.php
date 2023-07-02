<?php

// edit coonect with configuration data :
$connect = mysqli_connect('localhost', 'ahmed', '123','hirrre');
if(!$connect){
    echo "Coonection Error" . mysqli_connect_error();
}

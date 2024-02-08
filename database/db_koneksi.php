<?php
    if(isset($_SESSION)){
        session_start();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db_apotekterang";

    $query = mysqli_connect($servername, $username, $password, $database);


    if($conn = $query){
    }
    else{
    }
?>
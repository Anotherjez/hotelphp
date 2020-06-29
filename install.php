<?php

include('libs/utils.php');

if($_POST){

    foreach($_POST as &$value){
        $value = addslashes($value);
    }        
    
    extract($_POST);

    $con = mysqli_connect($servername,$username,$password);

    $sql = "DROP DATABASE IF EXISTS {$dbname};";
    mysqli_query($con, $sql);
    $sql = "CREATE DATABASE {$dbname};";
    mysqli_query($con, $sql);

    mysqli_query($con, "use {$dbname}");
    
    $sql = "CREATE TABLE guests(
    id int(11) not null primary key auto_increment,
    nombre varchar(250) not null,
    apellido varchar(250) not null,
    pasaporte varchar(250) not null,
    correo varchar(250) not null,
    telefono varchar(250) not null,
    pais varchar(250) not null,
    firstdate date,
    lastdate date,
    room int(11));";

    mysqli_query($con, $sql);
    mysqli_close($con);

    if($con == true){
        $config = "<?php
        define('DB_HOST', '{$servername}');
        define('DB_USER', '{$username}');
        define('DB_PASS', '{$password}');
        define('DB_NAME', '{$dbname}');
        ?>";

        if(!file_exists("./libs/configx.php")){
            file_put_contents('./libs/configx.php', $config, FILE_APPEND | LOCK_EX);
        }else{    
            file_put_contents("libs/configx.php", $config);
        }
        header("Location:index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Instalar Hotel Magno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.scss">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body> 
    <img src="./assets/images/hotelicon.png" class="rounded mx-auto d-block" style="padding-top: 40px;">

    <?php

        if(!file_exists("./libs/configx.php")){
            LoadInstall();
        }else{
            Installed();
        }
    ?>
    
</body>
</html>
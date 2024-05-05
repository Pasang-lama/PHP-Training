<?php 
$servername = "localhost";
$port = 8080;
$username = "root";
$password = "";
$dbname = "pk";


$connection = mysqli_connect($servername, $username, $password, $dbname );

if($connection){
    // echo "Db connected";
}else{
    die("Error ". mysqli_connect_error());
}

?>
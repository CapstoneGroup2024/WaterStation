<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waterDb";

//Create Connection to Database
$con = mysqli_connect($servername, $username, $password, $dbname);

//Check Database Connection
if(!$con){
    die("Connection Failed ". mysqli_connect_error());
}


?>
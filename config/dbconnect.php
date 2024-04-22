<?php
session_start(); // START SESSION

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aquaflowdb";

// CREATE CONNECTION TO DATABASE
$con = mysqli_connect($servername, $username, $password, $dbname);

// CHECK DATABASE CONNECTION
if(!$con){
    die("Connection Failed ". mysqli_connect_error());
}

?>
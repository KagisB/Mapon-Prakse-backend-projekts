<?php
$servername = "";
$username = "admin";
$password = "password";

$conn = mysqli_connect($servername,$username,$password);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "CREATE DATABASE carRoute";
if(mysqli_query($conn,$sql)){
    echo "Database created successfully";
}else {
    echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);
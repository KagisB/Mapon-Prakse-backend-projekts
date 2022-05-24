<?php
$servername = "localhost";
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
$sql = "CREATE TABLE Users(
   id INT(4) AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(20) NOT NULL,
   password VARCHAR(255) NOT NULL,
   reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
)";
if($conn->query($sql)===TRUE){
    echo "Table Users created successfully";
}
else{
    echo "Error creating table: " . $conn->error;
}
mysqli_close($conn);
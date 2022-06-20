<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "password";
$port = 3306;
//$conn = new mysqli($servername,$username,$password,"",$port);
$conn = new mysqli($servername,$username,$password,"",$port);
if($conn->error){
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "CREATE DATABASE carRoute";
if(mysqli_query($conn,$sql)){

}else {
    //echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);
$conn = new mysqli($servername,$username,$password,"carRoute",$port);
$sql = "CREATE TABLE Users(
   id INT(4) AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(20) NOT NULL,
   password VARCHAR(255) NOT NULL,
   reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
)";
if($conn->query($sql)===TRUE){
    //echo "Table Users created successfully";
}
else{
    //echo "Error creating table: " . $conn->error;
}
mysqli_close($conn);
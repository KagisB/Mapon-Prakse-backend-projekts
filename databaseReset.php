<?php
echo "Start file?";
$servername = "172.17.0.2";
$servername2 = "127.0.0.1";
$username = "admin";
$password = "password";
$port = 3306;
$conn = new mysqli($servername2,$username,$password,"",$port);
echo "Connected to database?";
if($conn->error){
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "DROP DATABASE carRoute";
if(mysqli_query($conn,$sql)){
    echo "Users table deleted successfully";
}else {
    echo "Error dropping tables: " . mysqli_error($conn);
}
mysqli_close($conn);
echo "Closed connection?";

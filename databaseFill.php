<?php
$servername = "localhost";
$username = "admin";
$password = "password";

$dbname = "carRoute";
$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed: " . mysqli_connect_error());
}
$users = ["john"=>"johndoe","admin"=>"admin","normaluser"=>"passw0rd"];//piemērs 3 lietotājiem
foreach($users as $usname => $pass){//katru lietotāju ieliek datubāzē ar hashotu paroli
    $hash=password_hash($pass,PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (name, password) VALUES ($usname,$hash)";
    $conn->query($sql);
}

mysqli_close($conn);
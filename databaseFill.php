<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "password";
$port=3306;
$dbname = "carRoute";
$conn = new mysqli($servername,$username,$password,$dbname,$port);
if($conn->connect_error){
    die("Connection failed: " . mysqli_connect_error());
}

//Šeit varbūt izmantot kādu library, piemēram, phpauth, lai atvieglotu šo procesu
$users = ["john"=>"johndoe","admin"=>"admin","normaluser"=>"passw0rd"];//piemērs 3 lietotājiem
foreach($users as $usname => $pass){//katru lietotāju ieliek datubāzē ar hashotu paroli
    $hash=password_hash($pass,PASSWORD_DEFAULT);
    //$sql = "INSERT INTO Users (name, password) VALUES ($usname,$hash)";
    //echo $sql;
    $sql ="";
    $sql = $conn->prepare('INSERT INTO Users(name,password) VALUES(?,?)');//atgriezt tikai lietotāju, kur sakrīt ar username
    $sql->bind_param('ss', $usname, $hash);
    $sql->execute();
    //$sql = "INSERT INTO Users VALUES ($usname,$hash)";
    //$conn->query($sql);
}

mysqli_close($conn);
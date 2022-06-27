<?php
//$servername = "127.0.0.1";
$servername = "db";
$username = "admin";
$password = "password";
$port=3306;
$dbname = "carRoute";
$conn = new mysqli($servername,$username,$password,$dbname,$port);
if($conn->connect_error){
    //die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM Users";
$result=$conn->query($sql);
if($result->num_rows > 0){
    //exit();
}
else{
    $users = ["johny"=>"johndoe","admin"=>"admin","normaluser"=>"passw0rd"];//piemērs 3 lietotājiem
    foreach($users as $usname => $pass){//katru lietotāju ieliek datubāzē ar hashotu paroli
        $hash=password_hash($pass,PASSWORD_BCRYPT);
        $sql ="";
        $sql = $conn->prepare('INSERT INTO Users(name,password) VALUES(?,?)');//atgriezt tikai lietotāju, kur sakrīt ar username
        $sql->bind_param('ss', $usname, $hash);
        $sql->execute();
    }
}
mysqli_close($conn);
//exit();
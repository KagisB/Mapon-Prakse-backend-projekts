<?php
error_reporting(E_ALL ^ E_NOTICE);
//session_start();
//1)Iet cauri datubāzei/saņem sarakstu ar lietotājiem
//2) Atrod lietotāju sarakstā/meklē ievadīto lietotāju
//3.1)Salīdzina lietotāja paroli ar ievadīto paroli
//3.1.2)Ja sakrīt, aizsūta uz mapRoutes view
//3.1.3)Ja nesakrīt, atmet atpakaļ
//3.2)Ja neatrod lietotāju, atmet atpakaļ

//!!!Pārbaudīt, vai ievadīti ir vārdi, nevis kaut kas cits

///Example taken from and adjusted: https://github.com/ricnish/php-auth-example
///Function checks, if the user is authenticated, if not, reroutes to login page.
function authHTML(){
    if(empty($_SESSION['userlogin'])){
        header('Location: ../views/login.php');
        exit();
    }
}
function isValidUser($name, $pass){
        //iegūst sarakstu ar lietotājiem no datubāzes
    $servername="db";
    $username = "admin";
    $password = "password";
    $dbname = "carRoute";
    $port=3306;
    $conn = new mysqli($servername,$username,$password,$dbname,$port);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    //Atrod no datubāzes lietotāju ar tādu pašu vārdu

    $sql = $conn->prepare('SELECT name,password FROM Users WHERE name = ? LIMIT 1');//atgriezt tikai lietotāju, kur sakrīt ar username
    $sql->bind_param('s', $name);
    $sql->execute();
    $result = $sql->get_result();
    if(!$result->num_rows){
        return false;
    }
    while($row = $result->fetch_assoc()){///Kamēr ir rezultātu rindas(vai vajag, jo vārdam tikai vienam vajadzētu būt
        if($row["name"]==$name){
            if(password_verify($pass,$row["password"])){
                return true;
            }
            else{
                return false;
            }
        }
    }
    $conn->close();
    return false;
}
//error_reporting(E_ALL ^ E_WARNING);
if(isset($_POST['logout'])){
    if($_POST['logout']=="logout"){
        //Right now have to use this, otherwise won't work. Definitely something that needs to be improved later.
        require_once '../../router.php';
        session_start();
        session_destroy();
        $uri = $_SERVER["REQUEST_URI"];
        $router = new Router();
        $router->dispatchRoute($uri);
    }
}

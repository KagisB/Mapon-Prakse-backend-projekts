<?php
session_start();
//1)Iet cauri datubāzei/saņem sarakstu ar lietotājiem
//2) Atrod lietotāju sarakstā/meklē ievadīto lietotāju
//3.1)Salīdzina lietotāja paroli ar ievadīto paroli
//3.1.2)Ja sakrīt, aizsūta uz mapRoutes view
//3.1.3)Ja nesakrīt, atmet atpakaļ
//3.2)Ja neatrod lietotāju, atmet atpakaļ

//!!!Pārbaudīt, vai ievadīti ir vārdi, nevis kaut kas cits
//$name=$_POST["name"];
//$pass=$_POST["password"];
//$name = "john";
//$password = "johndoe";
//$test="asd";
//Kā pārbaudīt, vai name un password ir normāli/nav sql injections?

///Example taken from and adjusted: https://github.com/ricnish/php-auth-example
///Function checks, if the user is authenticated, if not, reroutes to login page.
function authHTML(){
    //echo "authHTML activate";
    if(empty($_SESSION['userlogin'])){
        //echo "redirects to page";
        header('Location: ../views/login.php');
        exit();
    }
    /*elseif($_SESSION['userlogin']!=FALSE){
        header('Location: ../views/mapRoutes.php');
        exit();
    }*/
}
//$name = "johny";
//$pass = "johndoe";
function isValidUser($name, $pass){
    ///Here goes username/password validation through database
    if(str_contains($name,"aaa")){///izdomāt pareizāk
        /*//atgriež uz login lapu ar kļūdu "Nepareizi ievadīts vārds"header("Location:login.php");
        */
        return false;
    }
    else{
        //iegūst sarakstu ar lietotājiem no datubāzes
        $servername = "127.0.0.1";//??
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
            //echo "Ir izvēlēta rinda";
            if($row["name"]==$name){
                //echo "Atrod datubāzē vārdu";
                //Nestrādā salīdzināšana
                //$hash=password_hash($pass,PASSWORD_BCRYPT);
                //echo $hash;
                //echo $row["password"];
                if(password_verify($pass,$row["password"])){
                    //echo "Parole atrasta/sakrīt";
                    return true;
                }
                else{///Te ir jāpārveido, lai turpina meklēt, ja gadījumā ir vairāki vienādi usernames
                    //pārtrauc ciklu un atgriež uz login screen ar kļūdu "Nepareiza parole"
                    //header("location:login.php");
                    //exit;
                    //echo "Parole nesakrīt";
                    return false;
                }
            }
        }
        $conn->close();
    }
}
function logOut(){
    require_once '../../route.php';
    //session_start();
    session_destroy();
    $uri = $_SERVER["REQUEST_URI"];
    $router = new Router();
    $router->dispatchRoute($uri);
    /*header('Location: ../../public/homepage.php');
    exit();*/
}
error_reporting(E_ALL ^ E_WARNING);
if($_POST['logout']=="logout"){
    logOut();
}

//echo isValidUser($name,$pass);

    //PHPAuth login attempt:
    //include("../vendor/phpauth/phpauth/Config.php");
    //include("../vendor/phpauth/phpauth/Auth.php");

/*$servername = "127.0.0.1";//??
$username = "admin";
$password = "password";
$dbname = "carRoute";
$port=3306;*/
//$conn = new mysqli($servername,$username,$password,$dbname,$port);
/*$conn = new PDO("mysql:host=$servername;dbname=carRoute", $username, $password);

    $config = new PHPAuth\Config($conn);
    $auth   = new PHPAuth\Auth($conn, $config);

    $login = $auth->login($name,$password);
    if(!$login['error']){
        setcookie("authID",$login["hash"],$login["expire"],'/');
        header ("location: ../views/mapRoutes.php");
        exit();
    }
    else{
        header ("location: ../views/login.php");
        exit();
    }*/

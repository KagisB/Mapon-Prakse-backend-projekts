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
}
///Authenticates user to api, do i need this? Probably not, since i'm only logging
/// into the mapRoutes page.
/*function authMap(){
    $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
    $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
}*/
//$name = "johny";
//$pass = "johndoe";
function isValidUser($name, $pass){
    //echo "isValidUser activate";
    ///Here goes username/password validation through database
    /// I need to switch password encryption methods so they are the same and
    /// make the same hash for equal passwords
    if(str_contains($name,"aaa")){///izdomāt pareizāk
        /*//atgriež uz login lapu ar kļūdu "Nepareizi ievadīts vārds"header("Location:login.php");
        //    exit;
        ?>
        <form id="login1" action="../views/login.php" method="post">
            <input type="hidden" name="errorCode" value="WUsername">
        </form>
        <script type="text/javascript">
            document.getElementById('login1').submit();
        </script>
        <?php*/
        return false;
    }
    else{
        //echo "Meklē datubāzē lietotāju";
        //iegūst sarakstu ar lietotājiem no datubāzes
        $servername = "127.0.0.1";//??
        $username = "admin";
        $password = "password";
        $dbname = "carRoute";
        $port=3306;
        $conn = new mysqli($servername,$username,$password,$dbname,$port);
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
            //te jāpievieno reroute uz login page, ka database ir unavailable/login ir unavailable pašlaik
        }
        //echo " Savienojums ir izveidots";
        //Atrod no datubāzes lietotāju ar tādu pašu vārdu
        //echo $username;
        $sql = $conn->prepare('SELECT * FROM Users WHERE name = ?');//atgriezt tikai lietotāju, kur sakrīt ar username
        $sql->bind_param('s', $name);
        $sql->execute();
        $result = $sql->get_result();
        if($result->num_rows > 0){
            //echo "Ir vairāk par 0 rezultātiem datubāzē";
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
        }
        $conn->close();
    }
}
function logOut(){
    //session_start();
    session_destroy();
    header('Location: ../views/homepage.php');
    exit();
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

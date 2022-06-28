<?php
//error_reporting(E_ALL ^ E_WARNING);
require '../vendor/autoload.php';
require "../router.php";
//echo $_SERVER['REQUEST_URI'];
//echo "|";
//$_GET['login']="start";
if(isset($_GET['login'])){
    if($_GET['login']=="login"){
        $uri = $_SERVER['REQUEST_URI'];
        //echo $_SERVER['REQUEST_URI'];
        $router = new Router();
        $router->dispatchRoute($uri);
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<h1>Main page without having logged in</h1>
<button id="loginButton">Log in</button>
<form id="loginForm" action="index.php" method="get">
    <input type="hidden" id="login" name="login" value="login">
</form>
<script>
    document.getElementById("loginButton").addEventListener("click",sendLogin,false);
    function sendLogin(){
        document.getElementById("loginForm").submit();
    }
</script>
</html>


<?php
//error_reporting(E_ALL ^ E_WARNING);
require '../vendor/autoload.php';
require "../router.php";
//session_start();
if(isset($_GET['login'])){
    if($_GET['login']=="login"){
        $uri = $_SERVER['REQUEST_URI'];
        $router = new Router();
        $router->dispatchRoute($uri);
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <title>Home</title>
</head>
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


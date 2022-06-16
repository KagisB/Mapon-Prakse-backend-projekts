<!DOCTYPE html>
<html>
<h1>Main page without having logged in</h1>
<button id="loginButton">Log in</button>
<form id="loginForm" action="homepage.php" method="get">
    <input type="hidden" id="login" name="login" value="login">
</form>
<script>
    document.getElementById("loginButton").addEventListener("click",sendLogin,false);
    function sendLogin(){
        document.getElementById("loginForm").submit();
    }
</script>
<?php
error_reporting(E_ALL ^ E_WARNING);
require 'vendor/autoload.php';
require "router.php";
if($_GET['login']=="login"){
    $uri = $_SERVER['REQUEST_URI'];
    $router = new Router();
    $router->dispatchRoute($uri);
}

?>
</html>

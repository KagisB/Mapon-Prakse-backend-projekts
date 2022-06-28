<?php
require '../../router.php';
require '../controllers/LoginController.php';
if(!empty($_POST['name']) && !empty($_POST['password'])){
    if(isValidUser($_POST['name'],$_POST['password'])){
        session_start();
        $_SESSION['userlogin']=$_POST['name'];
        $uri = $_SERVER['REQUEST_URI'];
        $route = new Router();
        $route->dispatchRoute($uri);
    }
    else{
        $_SESSION['userlogin']=FALSE;
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<h1>Sign in</h1>
<form action="login.php" method="post">
    Username:<input type="text" name="name"><br>
    Password:<input type="password" name="password"<br>
    <input type="submit" name="Log in">
</form>
</html>
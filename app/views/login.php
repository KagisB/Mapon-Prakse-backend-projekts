<!DOCTYPE html>
<html>
<h1>Sign in</h1>
<form action="login.php" method="post">
    Username:<input type="text" name="name"><br>
    Password:<input type="password" name="password"<br>
    <input type="submit" name="Log in">
</form>
<?php
    //echo ("Start authentication process");
    require '../controllers/LoginController.php';
    if(!empty($_POST['name']) && !empty($_POST['password'])){
        //echo "Not empty";
        if(isValidUser($_POST['name'],$_POST['password'])){
            echo "";
            $_SESSION['userlogin']=$_POST['name'];
            header('Location: mapRoutes.php');
            exit();
        }
        else{
            $_SESSION['userlogin']=FALSE;
        }
    }
?>
</html>
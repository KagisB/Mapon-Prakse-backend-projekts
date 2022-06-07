<!DOCTYPE html>
<html>
<h1>Main page without having logged in</h1>
<h3><a href="app/views/login.php">Log in</a></h3>
<?php
require __DIR__ . '/vendor/autoload.php';
require 'app/controllers/LoginController.php';
// HTML authentication
authHTML();
?>
</html>

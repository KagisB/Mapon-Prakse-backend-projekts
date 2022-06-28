<?php

//namespace Router;
require_once 'vendor/autoload.php';
/*
 Adds routes with the help of FastRoutes package, to help redirect pages to other pages,
 without needing to do so in every file individually.
*/
class Router{
    private $dispatcher;
    public function __construct(){
            $this->dispatcher = FastRoute\simpleDispatcher(function($r) {
            $r->get('/public/index.php', 'sendIndexToLogin');
            $r->get('/', 'sendIndexToLogin2');
            $r->get('/index.php', 'sendIndexToLogin2');
            $r->addRoute('GET','/app/views/login.php','sendLoginToMap');
            $r->addRoute('GET','/app/controllers/LoginController.php','sendMapToHome');
            $r->addRoute('GET','/router.php','sendHello');
        });
    }
    public function dispatchRoute($uri){
        $httpMethod = 'GET';
        $uri = cleanURI($uri);
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                echo "404 Not Found";
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                echo "405 Method Not Allowed";
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars
                call_user_func($handler,$vars);
                break;
        }
    }
}
function cleanURI($uri){
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    return $uri;
}
//When receiving request from homepage, redirects to login
function sendIndexToLogin(){
    header('Location: ../app/views/login.php');
    exit();
}
function sendIndexToLogin2(){
    header('Location: ../app/views/login.php');
    exit();
}
function sendHello(){
    echo "Hello, world!";
}
//When receiving request from Login, redirects to mapRoutes
function sendLoginToMap(){
    header('Location: mapRoutes.php');
    exit();
}
//When receiving request from mapRoutes, redirects back to homepage
function sendMapToHome(){
    header('Location: ../../');
    exit();
}
<?php

//namespace Router;
require_once 'vendor/autoload.php';

/*
 Vajadzētu routes priekš paša homepage, tad route, kas aizved uz login, un route,
kas aizved uz mapRoutes. Potenciāli arī route, kas aizved uz homepage atpakaļ.
Pārējiem nevajag routes, jo visas datu ieguves notiek ar request palīdzību, tādēļ
netiek novirzīti lietotāji uz citu lapu katru reizi, kad viņi meklē kaut ko rezultātos.
Tādēļ pietiktu tikai ar šiem 3/4 routes?
Vēl protams jāsataisa serverim config faili, lai var palaist šo programmu uz kāda web
servera.
*/
class Router{
    private string $base_dir = "/mapon_prakse_backend_projekts";
    //private FastRoute\RouteCollector $r;
    private $dispatcher;
    //private FastRoute\simpleDispatcher $dispatcher;
    public function __construct(){
            $this->dispatcher = FastRoute\simpleDispatcher(function($r) {
            $r->get($this->base_dir.'/homepage.php', 'sendHomepageToLogin');
            $r->addRoute('GET',$this->base_dir.'/app/views/login.php','sendLoginToMap');
            //$r->addRoute('GET',$this->base_dir.'/app/views/mapRoutes.php','sendMap');
            $r->addRoute('GET',$this->base_dir.'/app/controllers/LoginController.php','sendMapToHome');
            $r->addRoute('GET',$this->base_dir.'/router.php','sendHello');
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
function sendHomepageToLogin(){
    //echo "Hello, homepage!";
    header('Location: /mapon_prakse_backend_projekts/app/views/login.php');
    exit();
}
function sendHello(){
    //echo $_SERVER['HTTP_HOST'];
    echo "Hello, world!";
}
//When receiving request from Login, redirects to mapRoutes
function sendLoginToMap(){
    //echo "Hello, login!";
    header('Location: mapRoutes.php');
    exit();
}
//When receiving request from mapRoutes, redirects back to homepage
function sendMapToHome(){
    //echo "Hello, map!";
    header('Location: ../../homepage.php');
    exit();
}

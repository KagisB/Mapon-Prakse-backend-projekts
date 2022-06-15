<?php

//use JetBrains\PhpStorm\NoReturn;
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
            $r->addRoute('GET',$this->base_dir.'/route.php','sendHello');
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
                //echo $handler;
                //echo "|";
                //echo $vars;
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

 /*$dispatcher = FastRoute\simpleDispatcher(function($r) {
     $base_dir = "/mapon_prakse_backend_projekts"
          $r->get($base_dir.'/homepage.php', 'sendHomepage');
          $r->addRoute('GET',$base_dir.'/app/views/login.php','sendLogin');
            $r->addRoute('GET',$base_dir.'/app/views/mapRoutes.php','sendMap');
            $r->addRoute('GET',$base_dir.'/route.php','sendHello');
            //$r->get('/', 'homepage.php');
            //$r->addRoute('GET','/login','app/views/login.php');
            //$r->addRoute('GET','/map','app/views/mapRoutes.php');
 });*/
// Fetch method and URI from somewhere



/*
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
//echo $httpMethod;
//echo $uri;
// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
function cleanURI($uri){
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    return $uri;
}*//*
//$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], (strlen('/framework')));
//$uri = substr($uri, (strlen('/mapon_prakse_backend_projekts')));
//echo "|";
//echo $uri;
$uri = rawurldecode($uri);
//echo "|";
//$uri = "/mapon_prakse_backend_projekts/map";
//echo $uri;
//Ja nomaina $uri uz / , tad aizved uz homepage, kā domāts. Kā dabūt, lai viņš arī requestojot šo
// izmanto šādu formātu, tas ir, kā dabūt, lai, izsaucot kādu website, to pārbauda caur šo
// failu?
//$uri = $base_dir.'/mapRoutes.php';
//Pārveidot kā funkciju, kuru izsauc konkrētās lapās ar vajadzīgajiem URI un methods,
// un tad šī funkcija izdara pārējo? vai tas vispār der? pašlaik neredzu citu variantu
//function dispatchURI($httpMethod, $uri) use ($dispatcher){
//echo "|";
//echo $routeInfo[0];
//echo $routeInfo[1];
//echo $_SERVER['DOCUMENT_ROOT'];
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
//}
*/

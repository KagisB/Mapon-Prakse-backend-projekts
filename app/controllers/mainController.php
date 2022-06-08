<?php
//pārvaldīt satiksmi starp lapām no šī controller? To vispār var izdarīt?
//Uz šejieni atsūtīt visas lapas, un, atkarībā no iedotās vērtības, ar switch statement nosūtīt uz īsto lapu/controller?
//Pārveidošu šo par galveno controller, kurš saņems norādījumus no mapRoutes.php, un izsauks vajadzīgo
//funkciju/klasi, atkarībā no nodotā action tipa.
error_reporting(E_ALL ^ E_WARNING);
use App\controllers\CarController;
use App\controllers\RouteController;
use App\models\Route;
require_once "../../vendor/autoload.php";
$caction = $_GET["carAction"];
switch($caction){
    case "infoCar":
        $car = new CarController();
        $car->infoCar();
        break;
    case "carList":
        $car = new CarController();
        $car->allCars();
        break;
}
$raction = $_GET["routeAction"];
//Nosūtīt no mapRoutes.php datus: datumu no/līdz, izvēlētās mašīnas, un tad šos datus nosūtīt uz Route.php
if($_GET["from"]!=null){
    $from = new DateTime($_GET["from"]);
}
else{
    $from = new DateTime("now");
    $from->modify("-1 week");
}
if($_GET["till"]!=null){
    $till = new DateTime($_GET["till"]);
}
else{
    $till = new DateTime("now");
}
if($_GET["carId"]!=null){
    $carId= $_GET["carId"];
}
else{
    $carId=0;
}
//$raction ="infoRoutesCarDate";
//$carId=66466;
//$from = new dateTime("2022-05-29T14:23");
//$till =new dateTime("2022-06-08T14:23");
//$carId=66466;
//$from->modify("-3 days");
//$from =;
switch ($raction) {
    case "infoRoute":
        $route = new Route();
        $route->getRoutes();
        break;
    case "infoRouteCar":
        $route = new RouteController();
        echo $route->infoRouteCar($carId);
        break;
    case "infoRoutesDate":
        $route = new RouteController();
        echo $route->infoRouteDates($from,$till);
        break;
    case "infoRoutesCarDate":
        $route = new Route();
        //echo $from.$till.$carId;
        $jsstring = $route->getRoutesCarTime($from,$till,$carId);
        //header('Content-Type: application/json; charset=utf-8');
        echo $jsstring;
        break;
}

/*
 Vajadzētu routes priekš paša homepage, tad route, kas aizved uz login, un route,
kas aizved uz mapRoutes. Potenciāli arī route, kas aizved uz homepage atpakaļ.
Pārējiem nevajag routes, jo visas datu ieguves notiek ar request palīdzību, tādēļ
netiek novirzīti lietotāji uz citu lapu katru reizi, kad viņi meklē kaut ko rezultātos.
Tādēļ pietiktu tikai ar šiem 3/4 routes?
Vēl protams jāsataisa serverim config faili, lai var palaist šo programmu uz kāda web
servera.
 */
/*
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
$r->get('/', sendHomepage);
$r->addRoute('GET','/login',sendLogin);
$r->addRoute('GET','/map',sendMap);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
function sendHomepage(){
    header('Location: ../../homepage.php');
    exit();
}
function sendLogin(){
    header('Location: ../views/login.php');
    exit();
}
function sendMap(){
    header('Location: ../views/mapRoutes.php');
    exit();
}
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars

        break;
}*/
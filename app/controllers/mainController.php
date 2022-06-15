<?php
//pārvaldīt satiksmi starp lapām no šī controller? To vispār var izdarīt?
//Uz šejieni atsūtīt visas lapas, un, atkarībā no iedotās vērtības, ar switch statement nosūtīt uz īsto lapu/controller?
//Pārveidošu šo par galveno controller, kurš saņems norādījumus no mapRoutes.php, un izsauks vajadzīgo
//funkciju/klasi, atkarībā no nodotā action tipa.
error_reporting(E_ALL ^ E_WARNING);
use App\controllers\CarController;
use App\controllers\RouteController;
use App\models\Route;
//use App\models\Route;
require_once "../../vendor/autoload.php";
$caction = $_GET["carAction"];
//$action="infoCar";
//$action="infoManyCars";
//$action="carList";
switch($caction){
    case "infoCar":
        $car = new CarController();
        $car->infoCar();
        break;
    /*case "infoManyCars":
        echo "lol";
        break;*/
    case "carList":
        $car = new CarController();
        $car->allCars();
        break;
}
$raction = $_GET["routeAction"];
//echo $_GET["dateFrom"];
//Nosūtīt no mapRoutes.php datus: datumu no/līdz, izvēlētās mašīnas, un tad šos datus nosūtīt uz Route.php
//$action = "infoAllRoutes";
//$action="infoRoute";
//$raction="infoRoutesCarDate";
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
//echo $from->format(DATE_ATOM);
//echo $till->format(DATE_ATOM);
//echo $carId;
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
        $route->getRoutesCarTime($from,$till,$carId);
        break;
}
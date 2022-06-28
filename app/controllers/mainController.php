<?php
//pārvaldīt satiksmi starp lapām no šī controller? To vispār var izdarīt?
//Uz šejieni atsūtīt visas lapas, un, atkarībā no iedotās vērtības, ar switch statement nosūtīt uz īsto lapu/controller?
//Pārveidošu šo par galveno controller, kurš saņems norādījumus no mapRoutes.php, un izsauks vajadzīgo
//funkciju/klasi, atkarībā no nodotā action tipa.
//error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL ^ E_NOTICE);
use App\controllers\CarController;
use App\controllers\RouteController;
use App\models\Route;
require_once "../../vendor/autoload.php";
if(isset($_GET["carAction"])){
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
}

if(isset($_GET["routeAction"])){
    $raction = $_GET["routeAction"];
}
//Nosūtīt no mapRoutes.php datus: datumu no/līdz, izvēlētās mašīnas, un tad šos datus nosūtīt uz Route.php
if(isset($_GET["from"])){
    if($_GET["from"]!=null){
        $from = new DateTime($_GET["from"]);
    }
    /*else{
        $from = new DateTime("now");
        $from->modify("-1 week");
    }*/
}
else{
    $from = new DateTime("now");
    $from->modify("-1 week");
}
if(isset($_GET["till"])){
    if($_GET["till"]!=null){
        $till = new DateTime($_GET["till"]);
    }
    /*else{
        $till = new DateTime("now");
    }  */
}
else{
    $till = new DateTime("now");
}
if(isset($_GET["carId"])){
    if($_GET["carId"]!=null){
        $carId= $_GET["carId"];
    }
    /*else{
        $carId=0;
    } */
}
else{
    $carId=0;
}
if(isset($raction)){
    switch ($raction) {
        case "infoRoute":
            $route = new RouteController();
            $jsstring = $route->infoRoute();
            echo $jsstring;
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
            $route = new RouteController();
            $jsstring = $route->infoRouteCarDates($from,$till,$carId);
            echo $jsstring;
            break;
        case "getKey":
            $route = new Route();
            echo $route->getKey();
            break;
    }
}

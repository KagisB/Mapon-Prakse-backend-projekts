<?php

//Functions, that collect data from the API, using Route class, and then sends that data to the webpage
namespace App\controllers;
use App\models\Route;
require_once "../../vendor/autoload.php";
///Funkcija saņem sarakstu ar maršrutiem, tad izvēlās pirmo maršrutu sarakstā, lai padotu to mājaslapai parādīt
///Vispirms saņem sarakstu, tad atrod, kur sākās pieturas
/// Tad izveido asociatīvo masīvu, kur ir latitude un longitude koordinātas no API datiem
/// Šos datus ievieto masīvā, un iziet cauri visām pieturām maršrutā
/// Tad šo masīvu enkodē JSON un padod mapRoutes.php, lai tālāk tur apstrādātu to
error_reporting(E_ALL ^ E_WARNING);
class RouteController{
    public function _construct() : void{

    }
    public function infoRoute(): string{
        $route = new Route();
        $object = $route->printRoutes();
        $unit = $object->data->units[0];
        $routeStops = $unit->routes;
        $jobject = json_encode($routeStops);
        return $jobject;
    }
    public function infoRouteCar(int $carId): string{
        $route = new Route();
        $object = $route->printRoutesCar($carId);
        $unit = $object->data->units[0];
        $routeStops = $unit->routes;
        $jobject = json_encode($routeStops);
        return $jobject;
    }
//Vai ir jēga no šīs funkcijas? Kur tikai laiku izvēlās, un tad atlasa visus maršrutus visām mašīnām tajā laikā?
//Vai labāk tomēr būtu šajā funkcijā arī obligāti prasīt mašīnas id, lai var tikai tai konkrētajai mašīnai/mašīnām
//atlasīt maršrutus?
    public function infoRouteDates(datetime $from, datetime $till): string{
        $route = new Route();
        $object = $route->printRoutesTime($from,$till);
        $unit = $object->data->units[0];//Ja vajag šo funkciju, tad šeit vajadzēs nomainīt no [0] uz kaut ko citu
        $routeStops = $unit->routes;
        $jobject = json_encode($routeStops);
        return $jobject;
    }
    public function infoRouteCarDates($from,$till,$carId): string{
        $route = new Route();
        $object = $route->printRoutesCarTime($from,$till,$carId);
        $data=$object->data;
        $jobject = json_encode($data);
        return $jobject;
    }
}

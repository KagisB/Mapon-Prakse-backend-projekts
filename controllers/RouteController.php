<?php
//Funkcijas, kas:
//  Attēlo karti ar polylines un stops
//  Attēlo informāciju par konkrēto maršrutu mašīnai
//  Papildus info automašīnai par maršrutiem
//Switch statement, kur, atkarībā no darbības, izpilda noteiktu funkciju un aizsūta uz noteikto mājaslapu
include "../models/Route.php";
///Funkcija saņem sarakstu ar maršrutiem, tad izvēlās pirmo maršrutu sarakstā, lai padotu to mājaslapai parādīt
///Vispirms saņem sarakstu, tad atrod, kur sākās pieturas
/// Tad izveido asociatīvo masīvu, kur ir latitude un longitude koordinātas no API datiem
/// Šos datus ievieto masīvā, un iziet cauri visām pieturām maršrutā
/// Tad šo masīvu enkodē JSON un padod mapRoutes.php, lai tālāk tur apstrādātu to
error_reporting(E_ALL ^ E_WARNING);
function infoRoute(): void
{
    $route = new Route();
    $object = $route->getRoutes();
    $unit = $object->data->units[0];
    //echo $object->data->units[1]->unit_id;
    $routeStops = $unit->routes;
    $jobject = json_encode($routeStops);
    echo $jobject;
    /*foreach ($routeStops as $routeStop) {
        $lat=$routeStop->start->lat;
        $lng=$routeStop->start->lng;
        $stops[$lat]=$lng;
        //$stops[$routeStop->end->lat]=$routeStop->end->lng;
        //echo nl2br($route->route_id."\n");
        //echo nl2br("End of routes for this unit \n");
        var_dump($stops[$lat]);
    }*/
    //echo json_encode($stops);
    //var_dump($routeStops);
    //var_dump($object);
}
function infoRouteCar(int $carId): void
{
    $route = new Route();
    $object = $route->getRoutesCar($carId);
    $unit = $object->data->units[0];
    //echo $object->data->units[1]->unit_id;
    $routeStops = $unit->routes;
    $jobject = json_encode($routeStops);
    echo $jobject;
}
//Vai ir jēga no šīs funkcijas? Kur tikai laiku izvēlās, un tad atlasa visus maršrutus visām mašīnām tajā laikā?
//Vai labāk tomēr būtu šajā funkcijā arī obligāti prasīt mašīnas id, lai var tikai tai konkrētajai mašīnai/mašīnām
//atlasīt maršrutus?
function infoRouteDates(datetime $from, datetime $till): void
{
    $route = new Route();
    $object = $route->getRoutesTime($from,$till);
    $unit = $object->data->units[0];//Ja vajag šo funkciju, tad šeit vajadzēs nomainīt no [0] uz kaut ko citu
    //echo $object->data->units[1]->unit_id;
    $routeStops = $unit->routes;
    $jobject = json_encode($routeStops);
    echo $jobject;
}
function infoRouteCarDates(datetime $from, datetime $till, int $carId): void
{
    $route = new Route();
    $object = $route->getRoutesCarTime($from,$till,$carId);
    $unit = $object->data->units[0];
    //echo $object->data->units[1]->unit_id;
    $routeStops = $unit->routes;
    $jobject = json_encode($routeStops);
    //echo $routeStops[0]->route_id;
    echo $jobject;
}
$action = $_GET["routeAction"];
//echo $_GET["dateFrom"];
//Nosūtīt no mapRoutes.php datus: datumu no/līdz, izvēlētās mašīnas, un tad šos datus nosūtīt uz Route.php
//$action = "infoAllRoutes";
//$action="infoRoute";
//$action="infoRoutesCarDate";
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
switch ($action) {
    case "infoRoute":
        infoRoute();
        break;
    case "infoRouteCar":
        infoRouteCar($carId);
        break;
    case "infoRoutesDate":
        infoRouteDates($from,$till);
        break;
    case "infoRoutesCarDate":
        //infoRouteCarDates($_GET["from"],$_GET["till"],$_GET["carId"]);
        //echo "Got into switch statement right case";
        infoRouteCarDates($from,$till,$carId);
        break;
}
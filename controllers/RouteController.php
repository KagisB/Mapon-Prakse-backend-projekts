<?php
//Funkcijas, kas:
//  Attēlo karti ar polylines un stops
//  Attēlo informāciju par konkrēto maršrutu mašīnai
//  Papildus info automašīnai par maršrutiem
//Switch statement, kur, atkarībā no darbības, izpilda noteiktu funkciju un aizsūta uz noteikto mājaslapu

function infoAllRoutes(): void
{
    include "../models/Route.php";
    $route = new Route();
    $object = $route->getRoutes();
    $units = $object->data->units;
    //echo $object->data->units[1]->unit_id;
    foreach ($units as $unit) {
        $routes = $unit->routes;
        foreach($routes as $route){
            //echo nl2br($route->route_id."\n");
        }
        //echo nl2br("End of routes for this unit \n");
    }
}
///Funkcija saņem sarakstu ar maršrutiem, tad izvēlās pirmo maršrutu sarakstā, lai padotu to mājaslapai parādīt
///Vispirms saņem sarakstu, tad atrod, kur sākās pieturas
/// Tad izveido asociatīvo masīvu, kur ir latitude un longitude koordinātas no API datiem
/// Šos datus ievieto masīvā, un iziet cauri visām pieturām maršrutā
/// Tad šo masīvu enkodē JSON un padod mapRoutes.php, lai tālāk tur apstrādātu to
function infoRoute(): void
{
    include "../models/Route.php";
    $route = new Route();
    $object = $route->getRoutes();
    $unit = $object->data->units[0];
    //echo $object->data->units[1]->unit_id;
    /*$routeStops = $unit->routes;
    foreach ($routeStops as $routeStop) {
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

//$action = $_GET["routeAction"];
//$action = "infoAllRoutes";
$action="infoRoute";
//$action="infoManyCarssss";
switch ($action) {
    case "infoRoute":
        infoRoute();
        break;
    case "infoAllRoutes":
        infoAllRoutes();
        break;
}
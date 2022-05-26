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
            echo nl2br($route->route_id."\n");
        }
        echo nl2br("End of routes for this unit \n");
    }
}

//$action = $_POST["carAction"];
$action = "infoAllRoutes";
//$action="infoManyCars";
//$action="infoManyCarssss";
switch ($action) {
    case "infoRoute":
        echo "lol";
        break;
    case "infoAllRoutes":
        infoAllRoutes();
        break;
}
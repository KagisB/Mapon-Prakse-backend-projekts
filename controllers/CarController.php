<?php
//Funkcijas, lai izsauktu:
//  Mašīnu sarakstu, ko attēlot lapā
//  Mašīnai parādīt info, šis varbūt iet RouteController
//Vai vajag šo failu? Ja lapā requestos kaut ko, nevajadzētu refreshot page, un tādā gadījumā jādara viss tajā failā
//uz vietas.
include "../models/Car.php";
function infoCar(): void{
    $car = new Car();
    $object = $car->getCar();
    $cars=$object->data->units;
    //echo $object->data->units[1]->unit_id;
    foreach($cars as $car){
        echo $car->unit_id;
    }
    //var_dump($object);
}
function allCars(): void{
    $car = new Car();
    $object = $car->getCar();
    $cars=$object->data->units;
    $jcars = json_encode($cars);
    echo $jcars;
}
$action = $_GET["carAction"];
//$action="infoCar";
//$action="infoManyCars";
//$action="infoManyCarssss";
switch($action){
    case "infoCar":
        infoCar();
        break;
    case "infoManyCars":
        echo "lol";
        break;
    case "carList":
        allCars();
        break;
}


<?php
//Funkcijas, lai izsauktu:
//  Mašīnu sarakstu, ko attēlot lapā
//  Mašīnai parādīt info, šis varbūt iet RouteController
//Vai vajag šo failu? Ja lapā requestos kaut ko, nevajadzētu refreshot page, un tādā gadījumā jādara viss tajā failā
//uz vietas.
function infoCar(): void{
    include "../models/Car.php";
    $car = new Car();
    $object = $car->getCar();
    $cars=$object->data->units;
    //echo $object->data->units[1]->unit_id;
    foreach($cars as $car){
        echo $car->unit_id;
    }
    //var_dump($object);
}
//$action = $_POST["carAction"];
$action="infoCar";
//$action="infoManyCars";
//$action="infoManyCarssss";
switch($action){
    case "infoCar":
        infoCar();
        break;
    case "infoManyCars":
        echo "lol";
        break;
    case "AllCars":
        echo "please";
        break;
}


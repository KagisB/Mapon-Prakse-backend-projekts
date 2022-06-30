<?php
//Funkcijas, lai izsauktu:
//  Mašīnu sarakstu, ko attēlot lapā
//  Mašīnai parādīt info, šis varbūt iet RouteController
//Vai vajag šo failu? Ja lapā requestos kaut ko, nevajadzētu refreshot page, un tādā gadījumā jādara viss tajā failā
//uz vietas.
namespace App\controllers;
use App\models\Car;
require_once "../../vendor/autoload.php";
class CarController{
    public function _construct(): void{

    }
    /*public function infoCar(): void{
        $car = new Car();
        $object = $car->getCar();
        $cars=$object->data->units;
        foreach($cars as $car){
            echo $car->unit_id;
        }
    }*/
    public function allCars(): void{
        $car = new Car();
        $object = $car->getCar();
        $cars=$object->data->units;
        $jcars = json_encode($cars);
        echo $jcars;
    }
}
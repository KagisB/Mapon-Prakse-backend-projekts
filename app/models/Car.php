<?php

namespace App\models;
class Car
{
    //public int $id;
    public string $base_url = "https://mapon.com/api/v1/unit/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa";
    public function _construct(): void{

    }

    public function getCar(): object{
        //https://mapon.com/api/v1/unit/list.json
        $jobject = file_get_contents($this->base_url);
        $object = json_decode($jobject);
        //$object = json_decode($jobject,true);
        return $object;
    }
}

/*$car = new Car(1);
$object = $car->getCar();
//var_dump($object);*/
<?php

namespace App\models;
class Car
{
    public string $base_url = "https://mapon.com/api/v1/unit/list.json?key=";
    private const key ="5333a9720180356462a0d9615a38f6dfff4581aa";
    public function _construct(): void{

    }

    public function getCar(): object{
        //https://mapon.com/api/v1/unit/list.json
        $url = $this->base_url .Car::key;
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
}
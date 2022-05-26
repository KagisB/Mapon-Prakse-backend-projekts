<?php
class Car{
    public $id;
    public function _construct(int $n): void{
        $id=$n;
    }
    public function getCar(): object{
        //https://mapon.com/api/v1/unit/list.json
        $url="https://mapon.com/api/v1/unit/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa";
        $jobject = file_get_contents($url);
        //$ch = curl_init($url);
        //curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        ///curl_setopt($ch, CURLOPT_HEADER, 0);
        //$jobject = curl_exec($ch);
        //if(is_null($jobject)) echo "Task failed";
        //curl_close($ch);
        $object = json_decode($jobject);
        //$object = json_decode($jobject,true);
        return $object;
    }
    public function infoOnCar(): void{

    }
}
$car = new Car(1);
$object=$car->getCar();
var_dump($object);
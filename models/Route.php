<?php
class Route{
    public $id;
    public function _construct(int $n): void{
        $id=$n;
    }
    //Funkcija, kas paņem pēdējās nedēļas datus par maršrutiem, atkarībā no tā, kad aktivizē šo funkciju.
    public function getRoutes(): object{
        //https://mapon.com/api/v1/unit/list.json
        $date = new DateTime("now");
        $date->modify("-1 week");
        $time = $date->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=".$time;
        $date2 = new DateTime("now");
        $time = $date2->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url=$url."&till=".$time."&include[]=polyline";
        //$url=$url."&till=".$time;
        //$url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=&till=&include[]=decoded_route";
        //echo $url;
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
    //Funckija, kura izmanto iedotus laikus. Varbūt vēl jāpievieno mašīnu/unit id, lai var atlasīt konkrētu mašīnu maršrutus
    //Bet to varbūt kā vēl atsevišķu funkciju
    public function getRoutesTime(dateTime $from, dateTime $till): object{
        //https://mapon.com/api/v1/unit/list.json
        $date = $from;
        $time = $date->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=".$time;
        $date2 = $till;
        $time = $date2->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url=$url."&till=".$time."&include[]=polyline";
        //$url=$url."&till=".$time;
        //$url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=&till=&include[]=decoded_route";
        //echo $url;
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
    public function getRoutesCar(int $carId): object{
        //https://mapon.com/api/v1/unit/list.json
        $date = new DateTime("now");
        $date->modify("-1 week");
        $time = $date->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=".$time;
        $date2 = new DateTime("now");
        $time = $date2->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url=$url."&till=".$time."&unit_id=".$carId."&include[]=polyline";
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
    public function getRoutesCarTime(dateTime $from, dateTime $till,int $carId): object{
        //https://mapon.com/api/v1/unit/list.json
        $date = $from;
        $time = $date->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=".$time;
        $date2 = $till;
        $time = $date2->format(DATE_ATOM);
        $time=str_replace("+00:00","Z",$time);
        $url=$url."&till=".$time."&unit_id=".$carId."&include[]=polyline";
        //echo $url;
        $jobject = file_get_contents($url);
        //echo $jobject;
        $object = json_decode($jobject);
        //echo $object;
        return $object;
    }
}
/*$from = new DateTime("2022-05-18T13:14");
$till = new DateTime("2022-05-30T12:14");
$carId= 66466;
$route = new Route();
$object = $route->getRoutesCarTime($from,$till,$carId);*/
//var_dump($object);
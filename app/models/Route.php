<?php

namespace App\models;
use DateTime;

class Route
{
    public string $base_url ="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=";

    public function _construct(): void
    {
    }

    //Funkcija, kas paņem pēdējās nedēļas datus par maršrutiem, atkarībā no tā, kad aktivizē šo funkciju.
    public function getRoutes(): object
    {
        //https://mapon.com/api/v1/unit/list.json
        $date = new DateTime("now");
        $date->modify("-1 week");
        $time = $date->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $this->base_url . $time;
        $date2 = new DateTime("now");
        $time = $date2->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $url . "&till=" . $time . "&include[]=polyline";

        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        /*$unit = $object->data->units[0];
        //echo $object->data->units[1]->unit_id;
        $routeStops = $unit->routes;
        $jsobject = json_encode($routeStops);
        echo $jsobject;*/
        return $object;
    }
    //Funckija, kura izmanto iedotus laikus. Varbūt vēl jāpievieno mašīnu/unit id, lai var atlasīt konkrētu mašīnu maršrutus
    //Bet to varbūt kā vēl atsevišķu funkciju
    public function getRoutesTime(dateTime $from, dateTime $till): object
    {
        //https://mapon.com/api/v1/unit/list.json
        $date = $from;
        $time = $date->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $this->base_url . $time;
        $date2 = $till;
        $time = $date2->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $url . "&till=" . $time . "&include[]=polyline";
        //$url=$url."&till=".$time;
        //$url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=&till=&include[]=decoded_route";
        //echo $url;
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }

    public function getRoutesCar(int $carId): object
    {
        //https://mapon.com/api/v1/unit/list.json
        $date = new DateTime("now");
        $date->modify("-1 week");
        $time = $date->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $this->base_url . $time;
        $date2 = new DateTime("now");
        $time = $date2->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $url . "&till=" . $time . "&unit_id=" . $carId . "&include[]=polyline";
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }

    //public function getRoutesCarTime($from, $till, $carId): void
    public function getRoutesCarTime($from, $till, $carId): object
    {
        //https://mapon.com/api/v1/unit/list.json
        $date = $from;
        $time = $date->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        $url = $this->base_url. $time;
        $date2 = $till;
        $time = $date2->format(DATE_ATOM);
        $time = str_replace("+00:00", "Z", $time);
        //$unitIds = http_build_query(array('unit_id' => $carId));
        //$url=$url."&till=".$time."&unit_id=".$carIds."&include[]=polyline";
        $url = $url . "&till=" . $time . "&";
        $it = 0;
        //echo $carId;
        //var_dump($carId);
        $carIds = explode(',', $carId);
        foreach ($carIds as $car) {
            //echo $car;
            $url = "{$url}unit_id[{$it}]={$car}&";
            $it++;
        }
        $url = $url . "include[]=polyline";
        //echo $url;
        $jobject = file_get_contents($url);
        //echo $jobject;
         //echo $jobject;
        //return $jobject;
        $object = json_decode($jobject);
        //$data=$object->data;
        //$jsobject = json_encode($data);
        //return $jsobject;
        //return $jsobject;
        return $object;
    }
}
/*$from = new DateTime("2022-05-29T11:21");
$till = new DateTime("2022-06-09T11:21");
$carId= 66466;
$route = new Route();
$object = $route->getRoutesCarTime($from,$till,$carId);
echo $object;*/
//var_dump($object);
<?php

namespace App\models;
use DateTime;
define('APIReady','Y-m-d\TH:i:s\Z');
class Route
{
    public string $base_url ="https://mapon.com/api/v1/route/list.json?key=";
    private const key="5333a9720180356462a0d9615a38f6dfff4581aa";
    public function _construct(): void{

    }
    public function getKey(): string{
        return Route::key;
    }
    //Funkcija, kas paņem pēdējās nedēļas datus par maršrutiem, atkarībā no tā, kad aktivizē šo funkciju.
    public function printRoutes(): object{
        //https://mapon.com/api/v1/unit/list.json
        $date = new DateTime("now");
        $date->modify("-1 week");
        $time = $date->format(APIReady);
        $url = $this->base_url .Route::key."&from=".$time;
        $date2 = new DateTime("now");
        $time = $date2->format(APIReady);
        $url = $url . "&till=" . $time . "&include[]=polyline";

        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
    //Funckija, kura izmanto iedotus laikus. Varbūt vēl jāpievieno mašīnu/unit id, lai var atlasīt konkrētu mašīnu maršrutus
    //Bet to varbūt kā vēl atsevišķu funkciju
    ////https://mapon.com/api/v1/unit/list.json
    public function printRoutesTime(dateTime $from, dateTime $till): object{
        $date = $from;
        $time = $date->format(APIReady);
        $url = $this->base_url .Route::key."&from=". $time;
        $date2 = $till;
        $time = $date2->format(APIReady);
        $url = $url . "&till=" . $time . "&include[]=polyline";
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }

    public function printRoutesCar(int $carId): object{
        $date = new DateTime("now");
        $date->modify("-1 week");
        $time = $date->format(APIReady);
        $url = $this->base_url .Route::key."&from=". $time;
        $date2 = new DateTime("now");
        $time = $date2->format(APIReady);
        $url = $url . "&till=" . $time . "&unit_id=" . $carId . "&include[]=polyline";
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }

    public function printRoutesCarTime($from, $till, $carId): object{
        $date = $from;
        $time = $date->format(APIReady);
        $url = $this->base_url.Route::key."&from=". $time;
        $date2 = $till;
        $time = $date2->format(APIReady);
        $url = $url . "&till=" . $time . "&";
        $it = 0;
        $carIds = explode(',', $carId);
        foreach ($carIds as $car) {
            $url = "{$url}unit_id[{$it}]={$car}&";
            $it++;
        }
        $url = $url . "include[]=polyline";
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
}

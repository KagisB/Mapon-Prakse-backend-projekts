<?php
class Route{
    public $id;
    public function _construct(int $n): void{
        $id=$n;
    }
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
        //$url="https://mapon.com/api/v1/route/list.json?key=5333a9720180356462a0d9615a38f6dfff4581aa&from=&till=&include[]=decoded_route";
        //echo $url;
        $jobject = file_get_contents($url);
        $object = json_decode($jobject);
        return $object;
    }
}
$route = new Route(1);
$object=$route->getRoutes();
//var_dump($object);
<!DOCTYPE html>
<html>
<h1>Main page having logged in</h1>
<h3>Map</h3>
<?php
//google maps api key :AIzaSyDoJiyrbE9CRIuyb_9KysJpcGAKPdBmo1w
//Varbūt te paņemt json failu, un tad viņu pārmest šajā lapā jau?
?>
<form id="routeSelect" action="../controllers/RouteController.php" method="post">
    <label for="cars">Select a car</label>
    <select id="cars" name="cars" multiple>
        <option value="test1">Test 1</option>
        <option value="test2">Test 2</option>
        <option value="test3">Test 3</option>
    </select>
    <label for="dateFrom">Choose start date</label>
    <input type="date" id="dateFrom" name="dateFrom">
    <label for="dateTill">Choose end date</label>
    <input type="date" id="dateTill" name="dateTill" max="2022-05-27">
</form>
<label for="press_me">Press me</label>
<input type="button" id="press_me">
<label for="reset">Reset</label>
<input type="button" id="reset">
<label for="filter">Filter data</label>
<input type="button" id="filter">
<!---
Te vajadzētu gan jau js funkciju, kas uz izmaiņām sūta datus uz php failu, bet varbūt arī likt lietotājam to nospiest
-->


<div id="map" style="width:100%;height:750px;"></div>
<script>
    let map;
    let poly;
    document.getElementById("press_me").addEventListener("click",initMaps,false);
    document.getElementById("reset").addEventListener("click",initMap,false);
    //Nākamais event listener nosūtīs datus uz routeController, lai var iegūt precīzus datus no API. Tam gan vajag vēl pārmainīt pašu routeController
    // un route.php. Pagaidām temp alert, lai pārbaudītu, vai strādā šis listener.
    document.getElementById("filter").addEventListener("click",function (){alert("Filter");},false);
    function initMaps(){
                /*
                Kad saņem kaut ko no servera-
                Pārveido atsūtīto json objektu, lai var iet cauri,
                Katru objekta koordināti attēlot kā pieturu google maps
                */
                //alert("Tiek funkcijā");
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    //alert("Tiek reqest funkcijā");
                    if (this.readyState == 4 && this.status == 200) {
                        //alert("Tiek reqest funkcijā iekšā");
                        //console.log(xmlhttp.responseText);
                        //console.log(JSON.parse(xmlhttp.responseText));
                        let object = JSON.parse(xmlhttp.responseText);
                        //let object=xmlhttp.responseText;
                        //console.log(object.length);
                        //let route=JSON.parse(object);
                        //console.log();
                        //console.log(object);
                        //let object = xmlhttp.responseText;
                        //alert(object);
                        let position = {lat: object[0].start.lat, lng: object[0].start.lng};
                        map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 8,
                            center: position,
                        });
                        let marker = new google.maps.Marker({
                            position: position,
                            map: map,
                        });
                        //);
                        //Šis pagaidām nestrādā, jāizdomā, kā citādāk iet cauri atsūtītajam objektam
                        //console.log(object[0]);
                        //console.log(object[1]);
                        object.forEach((route)=>{
                            let stops = route;
                            //console.log(stops);
                            //console.log(stops.start);
                            //console.log(stops.start.lat);
                            //console.log(stops.end);
                            let positionAdditional = { lat: stops.start.lat, lng: stops.start.lng};
                            marker = new google.maps.Marker({
                                position: positionAdditional,
                                map: map,
                            });
                            //Ieraudzīju, ka dažiem stops nav beigu(laikam vēl ir in progress brauciens?)
                            //Tādēļ pagaidām ieliku pārbaudi, vai ir route end, ja nav, tad neliek end marker
                            if(stops.hasOwnProperty('end')){
                                //console.log("ir end");
                                positionAdditional = { lat: stops.end.lat, lng: stops.end.lng};
                                marker = new google.maps.Marker({
                                    position: positionAdditional,
                                    map: map,
                                });
                                stops
                            }
                            //console.log(stops.type);
                            //Nevaru pārbaudīt pašlaik, jo ir problēmas ar random encoded polyline, kura met
                            //unrecognizable simbolus, kas parādās tikai parsējot cauri ar json.parse funkciju,
                            //citādi nerādās šie simboli, bet tādēļ uzreiz visa funkcija nestrādā
                            //Bet, teorētiski, ja route tips ir route, nevis stop, tad vajadzētu decodot doto polyline path
                            // un tālāk apstrādāt to.
                            if(stops.type=="route"){
                                let path = google.maps.geometry.encoding.decodePath(stops.polyline);
                                console.log(path);
                                let drivingPath = new google.maps.Polyline({
                                    path: path,
                                    geodesic:true,
                                    strokeColor: "#4FDA12",
                                    strokeOpacity: 1.0,
                                    strokeWeight: 2,
                                });
                            }
                        });
                    }
                }
        xmlhttp.open("GET", "../controllers/RouteController.php?routeAction=infoRoute", true);
        xmlhttp.send();
        //alert("Tiek funkcijas beigās");
    }
    // Initialize and add the map
    //Šis ir ņemts no oficālā documentation google maps API, kā piemērs, kurš strādā.
    function initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.031 };
        // The map, centered at Uluru
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
    window.initMap = initMap;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoJiyrbE9CRIuyb_9KysJpcGAKPdBmo1w&libraries=geometry&callback=initMap"></script>
</html>

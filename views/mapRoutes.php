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
<!---
Te vajadzētu gan jau js funkciju, kas uz izmaiņām sūta datus uz php failu, bet varbūt arī likt lietotājam to nospiest
-->


<div id="map" style="width:100%;height:750px;"></div>
<script>
    let map;
    let poly;
    document.getElementById("press_me").addEventListener("click",initMaps,false);
    document.getElementById("reset").addEventListener("click",initMap,false);
    /*document.addEventListener('readystatechange', event => {
        // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
        if (event.target.readyState === "complete") {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                let object = JSON.parse(xmlhttp.responseText);
                let position ={ lat: object[0].start.lat, lng: object[0].start.lng};
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 4,
                    center: position,
                });
                object.forEach((route)=>{
                    let positionAdditional = { lat: object.start.lat, lng: object.start.lng};
                    let marker = new google.maps.Marker({
                        position: positionAdditional,
                        map: map,
                    }));
                }
            }
            xmlhttp.open("GET", "../controllers/RouteController.php?routeAction=infoRoute", true);
            xmlhttp.send();
        }
    });*/

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
                        let object = JSON.parse(xmlhttp.responseText);
                        //let object = xmlhttp.responseText;
                        let position = {lat: object[0].start.lat, lng: object[0].start.lng};
                        map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 8,
                            center: position,
                        });
                        let marker = new google.maps.Marker({
                            position: position,
                            map: map,
                        });
                        //Šis pagaidām nestrādā, jāizdomā, kā citādāk iet cauri atsūtītajam objektam
                        /*object.forEach((route)=>{
                            let positionAdditional = { lat: object.start.lat, lng: object.start.lng};
                            let marker = new google.maps.Marker({
                                position: positionAdditional,
                                map: map,
                            });
                        });*/
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoJiyrbE9CRIuyb_9KysJpcGAKPdBmo1w&callback=initMap"></script>
</html>

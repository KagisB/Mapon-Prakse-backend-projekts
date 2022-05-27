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
<!---
Te vajadzētu gan jau js funkciju, kas uz izmaiņām sūta datus uz php failu, bet varbūt arī likt lietotājam to nospiest
-->


<div id="map" style="width:100%;height:750px;"></div>
<script>
    /*function initMap(){
        for(let i=0; i< routes.length;i++){
            let stop = {};
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                <!--document.getElementById("txtHint").innerHTML = this.responseText;-->
                <!--
                Kad saņem kaut ko no servera-
                Pārveido atsūtīto json objektu, lai var iet cauri,
                Katru objekta koordināti attēlot kā pieturu google maps
                -->
                let stops = this.responseText;
                let position ={ lat: Object.keys(stops)[0], lng: stops[Object.keys(stops)[0]]};
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 4,
                    center: position,
                });
                for(let key in stops){
                    let positionAdditional ={ lat: key, lng: stops[key]};
                    let marker = new google.maps.Marker({
                        position: positionAdditional,
                        map: map,
                    });
                }
            }
        };
        xmlhttp.open("GET", "../controllers/RouteController.php?routeAction=infoRoute", true);
        xmlhttp.send();
    }*/
    // Initialize and add the map
    function initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.031 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
    }
    window.initMap = initMap;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoJiyrbE9CRIuyb_9KysJpcGAKPdBmo1w&callback=initMap"></script>

</html>

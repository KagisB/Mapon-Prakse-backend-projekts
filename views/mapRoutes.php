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
    <select id="cars" name="cars" multiple><!--- Šeit tiek liktas iespējamās opcijas kā pieejamas mašīnas no api-->

    </select>
    <label for="dateFrom">Choose start date</label>
    <input type="datetime-local" id="dateFrom" name="dateFrom">
    <label for="dateTill">Choose end date</label>
    <input type="datetime-local" id="dateTill" name="dateTill" max="">
</form>
<label for="press_me">Press me</label>
<input type="button" id="press_me">
<label for="reset">Reset</label>
<input type="button" id="reset">
<label for="filter">Filter data</label>
<input type="button" id="filter">
<label for="test">Test polyline</label>
<input type="button" id="test">
<div id="Route_info"></div>
<!---
Te vajadzētu gan jau js funkciju, kas uz izmaiņām sūta datus uz php failu, bet varbūt arī likt lietotājam to nospiest
-->


<div id="map" style="width:100%;height:750px;"></div>
<script>
    let map;
    let poly;
    window.onload = function() {
        pageLoad();
    };
    document.getElementById("press_me").addEventListener("click",initMaps,false);
    document.getElementById("reset").addEventListener("click",initMap,false);
    //Nākamais event listener nosūtīs datus uz routeController, lai var iegūt precīzus datus no API. Tam gan vajag vēl pārmainīt pašu routeController
    // un route.php. Pagaidām temp alert, lai pārbaudītu, vai strādā šis listener.
    document.getElementById("filter").addEventListener("click",filter,false);
    //document.getElementById("test").addEventListener("click",getSelectValues(),false);
    //Šī funkcija uzliek mašīnu sarakstu pie izvēles opcijām, kā arī uzliek pašreizējo laiku kā max value
    //dateTill izvēlei
    function pageLoad(){
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let object = JSON.parse(xmlhttp.responseText);
                //console.log(object);
                let select = document.getElementById('cars');
                select.innerHTML="";
                for(let car of object){
                    //console.log(car);
                    let opt = document.createElement('option');
                    opt.value=car["unit_id"];//vērtību piešķir unit id, lai var vieglāk atrast īstos routes
                    if(select.innerHTML==""){
                        opt.selected = true;
                    }
                    opt.innerHTML =car["number"];//Nosaukumu sarakstā liek mašīnas numuru, var kaut ko citu arī likt
                    select.appendChild(opt);
                }
            }
        }
        xmlhttp.open("GET", "../controllers/CarController.php?carAction=carList", true);
        xmlhttp.send();
        let currentDate = new Date() ;
        let d=currentDate.getDate();
        let m=currentDate.getMonth()+1;
        let y=currentDate.getFullYear();
        let h=currentDate.getHours();
        let min=currentDate.getMinutes();
        let sec=currentDate.getSeconds();
        if(d<10){
            d= '0'+d;
        }
        if(m<10){
            m = '0'+m;
        }
        if(min<10){
            min = '0'+min;
        }
        if(h<10){
            h = '0'+h;
        }
        if(sec<10){
            sec = '0'+sec;
        }
        console.log(y+" "+m+" "+d+" "+h+" "+min);
        let today=y+'-'+m+'-'+d+'T'+h+':'+min+':'+sec;
        console.log(today);
        //document.getElementById("dateTill").setAttribute("max",today);
        document.getElementById("dateTill").max=today;
    }
    //Funkcija, lai atlasītu select vērtības no saraksta, ja gadījumā ir vairākas vērtības
    /*function getSelectValues(select) {
        let result = [];
        let options = select && select.options;
        let opt;

        for (let i=0, iLen=options.length; i<iLen; i++) {
            opt = options[i];
            if (opt.selected) {
                result.push(opt.value || opt.text);
            }
        }
        //return result;
        console.log(result);
    }*/
    function filter(){
        let from, till, carId;
        if(document.getElementById('dateFrom').value == ""){
            alert("Choose a start date");
        }
        else{
            //console.log(document.getElementById('dateFrom').value);
            from = document.getElementById('dateFrom').value;
        }
        if(document.getElementById('dateTill').value == ""){
            alert("Choose a end date");
        }
        else{
            //console.log(document.getElementById('dateTill').value);
            till = document.getElementById('dateTill').value;
        }
        let selectedCars = document.getElementById('cars');
        //let carIds = getSelectValues(selectedCars);
        //šeit pašlaik automātiski izvēlās pirmo mašīnu sarakstā, bet gan jau jāpārveido atsevišķi, lai checo, vai
        //vispār ir izvēlēts kaut kas, ja nav, tad izsauc citu funkciju, kurā nevajag mašīnas id
        //if(carIds[0] == null){
        //    alert("Choose a car");
        //}
        //else{
            carId = selectedCars.options[selectedCars.selectedIndex].value;
        //}
        console.log(from + "," + till + "," + carId);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let object = JSON.parse(xmlhttp.responseText);
                //console.log(object);
                //console.log(xmlhttp.responseText);
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
                    }
                    if(stops.type=="route"){
                        console.log("Ir route");
                        let path = google.maps.geometry.encoding.decodePath(stops.polyline);
                        //console.log(path);
                        let lineSymbol = {
                            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
                        };
                        let drivingPath = new google.maps.Polyline({
                            path: path,
                            geodesic:true,
                            strokeColor: "#4FDA12",
                            strokeOpacity: 1.0,
                            strokeWeight: 2,
                            icons: [{
                                icon: lineSymbol,
                                offset: '100%'
                            }],
                            map: map,
                        });
                    }
                });
            }
        }
        console.log("../controllers/RouteController.php?routeAction=infoRouteCarDates&from="+from+"&till="+till+"&carId="+carId)
        xmlhttp.open("GET", "../controllers/RouteController.php?routeAction=infoRoutesCarDate&from="+from+"&till="+till+"&carId="+carId, true);
        xmlhttp.send();
    }
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
                            }
                            //console.log(stops.type);
                            //Nevaru pārbaudīt pašlaik, jo ir problēmas ar random encoded polyline, kura met
                            //unrecognizable simbolus, kas parādās tikai parsējot cauri ar json.parse funkciju,
                            //citādi nerādās šie simboli, bet tādēļ uzreiz visa funkcija nestrādā
                            //Bet, teorētiski, ja route tips ir route, nevis stop, tad vajadzētu decodot doto polyline path
                            // un tālāk apstrādāt to.
                            if(stops.type=="route"){
                                console.log("Ir route");
                                let path = google.maps.geometry.encoding.decodePath(stops.polyline);
                                //console.log(path);
                                let drivingPath = new google.maps.Polyline({
                                    path: path,
                                    geodesic:true,
                                    strokeColor: "#4FDA12",
                                    strokeOpacity: 1.0,
                                    strokeWeight: 2,
                                    map: map,
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
    //Testa funkcija, lai saprastu, kā strādā polylines, un vai problēma ir ar pašu kodu, vai ar ievaddatiem
    function testpoly(){
        let path = google.maps.geometry.encoding.decodePath(polyline);
        let drivingPath = new google.maps.Polyline({
            path: path,
            geodesic:true,
            strokeColor: "#4FDA12",
            strokeOpacity: 1.0,
            strokeWeight: 2,
            map : map,
        });
    }
    window.initMap = initMap;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoJiyrbE9CRIuyb_9KysJpcGAKPdBmo1w&libraries=geometry&callback=initMap"></script>
</html>

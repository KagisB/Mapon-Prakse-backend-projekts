<?php
//Button, kuru nospiežot, aktivizējās funkcija, kura nosūta action=logout uz LoginController, tad, tur
//ja action ir tukšs, seto kaut ko random, bet citādi, ja ir logout, tad log outojas.
require '../controllers/LoginController.php';
//require_once "../../vendor/autoload.php";
// HTML authentication
session_start();
authHTML();
?>
<!DOCTYPE html>
<html lang="lv">
<head title="Maršrutu attēlošana">
    <meta charset="UTF-8">
</head>
<h1>Main page having logged in</h1>
<button id="logoutButton">Log out</button>
<form id="logoutForm" action="../controllers/LoginController.php" method="post">
    <input type="hidden" id="logout" name="logout" value="logout">
</form>
<h3>Map</h3>
<form id="routeSelect" action="../controllers/RouteController.php" method="post">
    <label for="cars">Select a car</label>
    <select id="cars" name="cars" multiple><!--- Šeit tiek liktas iespējamās opcijas kā pieejamas mašīnas no api-->

    </select>
    <label for="dateFrom">Choose start date</label>
    <input type="datetime-local" id="dateFrom" name="dateFrom">
    <label for="dateTill">Choose end date</label>
    <input type="datetime-local" id="dateTill" name="dateTill" min="" max="">
</form>

<label for="filter">Filter data</label>
<input type="button" id="filter">

<div id="Route_info"></div>

<div id="map" style="width:100%;height:600px;"></div>
<script>

    let map;
    let poly;
    window.onload = function() {
        pageLoad();
    };

    document.getElementById("dateFrom").addEventListener("input",changeMaxMinDate,false);
    document.getElementById("logoutButton").addEventListener("click",sendLogOut,false);
    //Nākamais event listener nosūtīs datus uz routeController, lai var iegūt precīzus datus no API.
    document.getElementById("filter").addEventListener("click",Filter,false);
    function sendLogOut(){
        document.getElementById("logoutForm").submit();
    }

    //Šī funkcija uzliek mašīnu sarakstu pie izvēles opcijām, kā arī uzliek pašreizējo laiku kā max value
    //dateTill izvēlei
    function pageLoad(){
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                let object = JSON.parse(xmlhttp.responseText);

                let select = document.getElementById('cars');
                select.innerHTML="";
                for(let car of object){

                    let opt = document.createElement('option');
                    opt.value=car["unit_id"];//vērtību piešķir unit id, lai var vieglāk atrast īstos routes
                    opt.id=car["number"];
                    if(select.innerHTML==""){
                        opt.selected = true;
                    }
                    opt.innerHTML =car["number"];//Nosaukumu sarakstā liek mašīnas numuru, var kaut ko citu arī likt
                    select.appendChild(opt);
                }
            }
        }
        xmlhttp.open("GET", "../controllers/mainController.php?carAction=carList", true);
        xmlhttp.send();

        let currentDate = new Date() ;
        let today = returnDateString(currentDate);
        document.getElementById("dateTill").max=today;
    }
    function changeMaxMinDate(){
        /*
        Paņem min date, pieliek mēnesi klāt, ja tas ir senāk par šodienu, noliek max uz
        to datumu. Arī pie reizes uzliek min vērtību, kas ir vienāda ar from datumu.
         */

        let minDate = new Date(document.getElementById("dateFrom").value);
        let today = returnDateString(minDate);
        document.getElementById("dateTill").min=today;
        let newDate = minDate;
        newDate.setMonth(newDate.getMonth()+1);
        let currentDate = new Date();

        if(newDate<currentDate){
            today=returnDateString(newDate);
            document.getElementById("dateTill").max=today;
            document.getElementById("dateTill").value=today;
        }
        else{
            today=returnDateString(currentDate);
            document.getElementById("dateTill").max=today;
        }
    }
    //Funkcija atgriež string no iedotā datuma(vajadzēja priekš dažām pārbaudēm, uzrakstīju kā atseivšķu funkciju)
    function returnDateString(currentDate){
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
        //let today=y+'-'+m+'-'+d+'T'+h+':'+min+':'+sec;
        let today=y+'-'+m+'-'+d+'T'+h+':'+min;
        return today;
    }
    //Funkcija, lai atlasītu select vērtības no saraksta, ja gadījumā ir vairākas vērtības
    function getSelectValues(select) {
        let selected = [];
        for(let option of select){
            if(option.selected){
                selected.push(option.value);
            }
        }
        return selected;
    }
    //Function, that gets the names of the selected cars, to be able to display, which car the current info box
    //is for
    function getSelectId(select) {
        let selected = [];
        for(let option of select){
            if(option.selected){
                selected.push(option.id);
            }
        }
        return selected;
    }
    //Validates user input, so a request for data can be made without error
    function validateData(){
        let from, till;//,carId;
        if(document.getElementById('dateFrom').value == ""){
            alert("Choose a start date");
            return false;
        }
        else{
            from = document.getElementById('dateFrom').value;
        }
        if(document.getElementById('dateTill').value == ""){
            alert("Choose a end date");
            return false;
        }
        else{
            let compareDate = new Date(from);
            let newDate = new Date(compareDate.setMonth(compareDate.getMonth()+1));
            let currentDate=new Date();
            //If its more than a month between FROM date and today, sets max value of TILL date to 1 month
            //after chosen FROM date, to make it work with Mapon API, where max period of a request is 1 month
            if(newDate<currentDate){
                let today = returnDateString(newDate);
                document.getElementById("dateTill").max=today;
                document.getElementById("dateTill").min=from;
            }
            else{
                let currentDate = new Date() ;
                let today = returnDateString(currentDate);
                document.getElementById("dateTill").max=today;
                document.getElementById("dateTill").min=from;
            }
            till = document.getElementById('dateTill').value;
            let compareDate2 = new Date(till);
            compareDate.setMonth(compareDate.getMonth()-1);
            if(compareDate2.getTime()<compareDate.getTime()){
                alert("Till date is earlier than from date!");
                return false;
            }
        }
        return true;
    }
    //Function changes the JSON file sent from API to be able to be used by other functions to display
    //data on the google maps map
    function changeJson(object){
        if (object == null) {
            alert("An error was made in data choice. Make sure the start and end dates are logical!");
        }
        //let data = object.data;
        //return data;
        return object.data;
    }
    function randomColor(){
        //return "#"+Math.floor(Math.random()*16777215).toString(16);
        let color = "#";
        for (let i = 0; i < 3; i++)
            color += ("0" + Math.floor(((1 + Math.random()) * Math.pow(16, 2)) / 2).toString(16)).slice(-2);
        return color;
    }
    //Displays markers and polylines on the map from given data object
    function displayOnMap(unit, j,i, color){
    //function displayOnMap(unit, j,i){
        document.getElementById("Route_info").innerHTML = "";
        let stops = unit.routes[j];

        let positionAdditional = {lat: stops.start.lat, lng: stops.start.lng};

        let marker = new google.maps.Marker({
            position: positionAdditional,
            map: map,
        });
        let carId = getSelectId(document.getElementById('cars').options);
        let infoContent ="<p>Car number: " + carId[i] + "</p>" +
            "<p>Start time: " + stops.start.time + "</p>" +
            "<p>Start address: " + stops.start.address + "</p>";
        //Ieraudzīju, ka dažiem stops nav beigu(laikam vēl ir in progress brauciens?)
        //Tādēļ pagaidām ieliku pārbaudi, vai ir route end, ja nav, tad neliek end marker
        if (stops.hasOwnProperty('end')) {
            infoContent = infoContent +
                "<p>Stop time: " + stops.end.time + "</p>" +
                "<p>Stop address: " + stops.end.address + "</p>";
            if(stops.hasOwnProperty('distance')){
                infoContent = infoContent +
                    "<p>Distance: " + stops.distance/1000 + " km</p>";
            }
            marker.addListener("click", () => {
                document.getElementById("Route_info").innerHTML = infoContent;
            });
            positionAdditional = {lat: stops.end.lat, lng: stops.end.lng};
            marker = new google.maps.Marker({
                position: positionAdditional,
                map: map,
            });
            marker.addListener("click", () => {
                document.getElementById("Route_info").innerHTML = infoContent;
            });
        } else {
            marker.addListener("click", () => {
                document.getElementById("Route_info").innerHTML = infoContent;
            });
        }
        //Today found out that routes also have a possibility to not have an end, throwing
        //an undefined value to polyline. So added another check, if the route has an end.
        if (stops.type == "route" && stops.hasOwnProperty('end')) {
            let path = google.maps.geometry.encoding.decodePath(stops.polyline);
            let lineSymbol = {
                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
            };
            let drivingPath = new google.maps.Polyline({
                path: path,
                geodesic: true,
                //strokeColor: "#4FDA12",
                strokeColor: color,
                strokeOpacity: 1.0,
                strokeWeight: 2,
                icons: [{
                    icon: lineSymbol,
                    offset: '100%'
                }],
                map: map,
            });

        }
        //});
    }
    //Positions the map on the first position of the first unit selected, and additionally places
    // a marker there.
    function displayStartOnMap(object, carId){
        if(!object){
            alert("Error in the data request. Switch dates, or try again.");
        }
        let position = {lat: object.units[0].routes[0].start.lat, lng: object.units[0].routes[0].start.lng};
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 8,
            center: position,
        });
        if(object.units[0].unit_id==carId){
            let marker = new google.maps.Marker({
                position: position,
                map: map,
            });
        }
    }
    function displayInitStartOnMap(object){
        let position = {lat: object[0].start.lat, lng: object[0].start.lng};

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 8,
            center: position,
        });
        let marker = new google.maps.Marker({
            position: position,
            map: map,
        });
    }
    //Test function to see, if a different filter implementation works better
    //Update : it works better in the sense that it doesn't throw errors for unrecognized symbols in JSON response
    function Filter(){
        if(!validateData()){
            alert ("Data wasn't correct");
            return;
        }
        else{
            let from = document.getElementById('dateFrom').value,
                till = document.getElementById('dateTill').value,
                carId=getSelectValues(document.getElementById('cars').options);
            loadJSON(from,till,carId);
        }
    }
    //prepares the url needed to request data from Mapon API
    function prepareURL(key,from,till,carId){
        from = from+":00Z&till=";
        till = till+":00Z&";
        let url = "https://mapon.com/api/v1/route/list.json?key="+key+"&from="+from+till;
        for(let i = 0;i<carId.length;i++){
            url = url+"unit_id["+i+"]="+carId[i]+"&";
        }
        url = url+"include[]=polyline";
        return url;
    }

    ///Function uses given data and generates a response from Mapon API, which it then displays on a map
    async function loadJSON(from, till, carId){
       if(!validateData()){
           alert ("Data wasn't correct");
           return;
       }
       else {
           let response = await fetch("../controllers/mainController.php?routeAction=getKey");
           let key = await response.text();
           let response2 = await fetch(prepareURL(key,from,till,carId));
           let object = await response2.json();
           let data = changeJson(object);
           displayStartOnMap(data,carId[0]);
           for(let i =0; i<data.units.length;i++){
               let unit = data.units[i];
               let color = randomColor();
               for(let j=0;j<unit.routes.length;j++){
                   displayOnMap(unit,j,i,color);
                   //displayOnMap(unit,j,i);
               }
           }
       }
    }

    //function initMaps(){
        function initMap(){
                /*
                Take info about first car's first route, to create a map, that is centered approximately
                in the right area of the world.
                */
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {

                        let object = JSON.parse(xmlhttp.responseText);
                        displayInitStartOnMap(object);

                        //Ir vispār vajadzība ko vairāk likt? vai sākumā varbūt arī pietiek, ja
                        //tiek uzlikts tikai sākuma marker pirmajā position, un viss, nekādus routes
                        //pa taisno uzreiz nerādīt?

                        object.forEach((route)=>{
                            let stops = route;
                            let positionAdditional = { lat: stops.start.lat, lng: stops.start.lng};
                            marker = new google.maps.Marker({
                                position: positionAdditional,
                                map: map,
                            });
                            let carId = getSelectId(document.getElementById('cars').options);
                            let infoContent ="<p>Car number: " + carId[0] + "</p>" +
                                "<p>Start time: " + stops.start.time + "</p>" +
                                "<p>Start address: " + stops.start.address + "</p>";
                            //Ieraudzīju, ka dažiem stops nav beigu(laikam vēl ir in progress brauciens?)
                            //Tādēļ pagaidām ieliku pārbaudi, vai ir route end, ja nav, tad neliek end marker

                            if(stops.hasOwnProperty('end')){
                                infoContent = infoContent +
                                    "<p>Stop time: " + stops.end.time + "</p>" +
                                    "<p>Stop address: " + stops.end.address + "</p>";
                                if(stops.hasOwnProperty('distance')){
                                    infoContent = infoContent +
                                        "<p>Distance: " + stops.distance/1000 + " km</p>";
                                }
                                marker.addListener("click", () => {
                                    document.getElementById("Route_info").innerHTML = infoContent;
                                });
                                positionAdditional = { lat: stops.end.lat, lng: stops.end.lng};
                                marker = new google.maps.Marker({
                                    position: positionAdditional,
                                    map: map,
                                });
                                marker.addListener("click", () => {
                                    document.getElementById("Route_info").innerHTML = infoContent;
                                });
                            }
                            else {
                                marker.addListener("click", () => {
                                    document.getElementById("Route_info").innerHTML = infoContent;
                                });
                            }
                            //Ja ir route, kuram ir beigas, tad var attēlot maršrutu ar polyline

                            if(stops.type=="route" && stops.hasOwnProperty('end')){
                                let path = google.maps.geometry.encoding.decodePath(stops.polyline);
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
        xmlhttp.open("GET", "../controllers/mainController.php?routeAction=infoRoute", true);
        xmlhttp.send();
    }

    window.initMap = initMap;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoJiyrbE9CRIuyb_9KysJpcGAKPdBmo1w&libraries=geometry&callback=initMap"></script>
</html>

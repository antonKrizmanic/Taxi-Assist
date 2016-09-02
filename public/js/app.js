var map;
var marker;
/*Omogucava autocomplite i sakriva polje sa cijenama
 * iscrtava kartu i pokusava locirati korisnika*/
$( document ).ready(function() {
    $('#odabir').hide();

    map = new google.maps.Map(document.getElementById('map'), {
        mapTypeControl: false,
        center: {lat: 45.81, lng: 16},
        zoom: 13
    });
    getLocation();
    enableAutocomplete();

});
function getLocation(){
    if (typeof navigator.geolocation == "undefined") {
        $("#error").text("Your browser doesn't support the Geolocation API");
        return;
    }
    else{
        navigator.geolocation.getCurrentPosition(function(position) {
            var location = { lat: position.coords.latitude, lng: position.coords.longitude };
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                    "location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
                },
                function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK){
                        $("#pocetna").val(results[0].formatted_address);
                        addMarker(location,map);
                        map.setCenter(location);
                    }
                    else{
                        $("#error").append("Unable to retrieve your address<br />");
                    }
                });
        });
    }
}
function enableAutocomplete(){
    var origin_place_id = null;
    var destination_place_id = null;
    var travel_mode = 'DRIVING';
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    directionsDisplay.setMap(map);

    var origin_input = document.getElementById('pocetna');
    var destination_input = document.getElementById('odredisna');
    //var modes = document.getElementById('mode-selector');



    var origin_autocomplete = new google.maps.places.Autocomplete(origin_input);
    origin_autocomplete.bindTo('bounds', map);
    var destination_autocomplete =
        new google.maps.places.Autocomplete(destination_input);
    destination_autocomplete.bindTo('bounds', map);

    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.


    function expandViewportToFitPlace(map, place) {
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
    }

    origin_autocomplete.addListener('place_changed', function() {
        var place = origin_autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        expandViewportToFitPlace(map, place);

        // If the place has a geometry, store its place ID and route if we have
        // the other place ID
        origin_place_id = place.place_id;
        route(origin_place_id, destination_place_id, travel_mode,
            directionsService, directionsDisplay);
        getDistance(origin_input.value,destination_input.value);
    });

    destination_autocomplete.addListener('place_changed', function() {
        var place = destination_autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        expandViewportToFitPlace(map, place);

        // If the place has a geometry, store its place ID and route if we have
        // the other place ID
        destination_place_id = place.place_id;
        route(origin_place_id, destination_place_id, travel_mode,
            directionsService, directionsDisplay);
        getDistance(origin_input.value,destination_input.value);
    });

    function route(origin_place_id, destination_place_id, travel_mode,
                   directionsService, directionsDisplay) {
        if (!origin_place_id || !destination_place_id) {
            return;
        }
        directionsService.route({
            origin: {'placeId': origin_place_id},
            destination: {'placeId': destination_place_id},
            travelMode: travel_mode
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
}

function getDistance(origin_input,destination_input) {

    if(pocetna != "" && odredisna !=""){
        var service = new google.maps.DistanceMatrixService;
        service.getDistanceMatrix({
            origins: [origin_input],
            destinations: [destination_input],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, function (response, status) {
            if (status !== google.maps.DistanceMatrixStatus.OK) {
                alert('Error was:');
            }
            else {
                if (marker != null) {
                    deleteMarkers();
                }
                var originList = response.originAddresses;
                var destinationList = response.destinationAddresses;
                var output = document.getElementById('output');
                output.innerHTML = '';
                $("#udaljenost").css("display", "inline");
                for (var i = 0; i < originList.length; i++) {
                    var results = response.rows[i].elements;
                    for (var j = 0; j < results.length; j++) {
                        output.innerHTML += results[j].distance.text;
                        distance = results[j].distance.text;
                        distanceLeng = distance.length - 3;
                        distance = distance.substring(0, distanceLeng);
                        document.cookie = "distance=" + distance;
                    }
                }
            }
        });
    }
}
/*Dodavanje markera*/
function addMarker(location, map) {
    marker = new google.maps.Marker({
        label:'A',
        position: location,
        map: map
    });
}
// Brisanje markera.
function deleteMarkers() {
    marker.setMap(null);
    marker = null;
}
function ConfirmDelete()
{
    var x = confirm("Jeste li sigurni da želite obrisati ovu stavku?");
    if (x)
        return true;
    else
        return false;
}

@extends('layouts.app')

@section('content')

        <div class="row padding">
            <div class="col-md-6">
                {{ Form::open(array('url'=>'order')) }}
                <div class="form-group">
                    {{ Form::label('startAddress','Pocetna adresa') }}
                    {{ Form::text('startAddress',null,array('class'=>'form-control geocomplete','id'=>'pocetna','placeholder'=>'Pocetna adresa')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('endAddress','Zavrsna adresa') }}
                    {{ Form::text('endAddress',null,array('class'=>'form-control geocomplete','id'=>'odredisna','placeholder'=>'Odredisna adresa')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('description','Napomena') }}
                    {{ Form::textarea('description',null,array('class'=>'form-control')) }}
                </div>
                <div class="form-group">
                    <label for="udaljenost" id="udaljenost">Udaljenost:</label>
                    <p id="output"></p>
                </div>
                <div id="cijene">
                    <div id="cjene">

                    </div>
                    <div class="form-group">
                        {{ Form::label('company_id','Odaberite taxi sluzbu koju zelite naruciti:') }}
                        {{ Form::select('company_id', $taxi,null,array('class'=>'form-control')) }}
                    </div>
                    <div class="form-group">
                        @if(Auth::guest())
                            <a href="#" class="btn btn-primary disabled">Naruci</a>
                        @else
                            {{ Form::submit('Naruci',array('class'=>'btn btn-primary','onclick'=>'getAlert();')) }}
                        @endif
                    </div>
                </div>
                <div class="form-gropu saznaj-cijenu">
                    <a href="javascript:void(0)" onclick="getPrice();" class="btn btn-primary">Saznaj cijene</a>
                </div>
                {{ Form::close() }}
            </div>
        </div>

@endsection

@section('content-fluid')
    <div id="map"></div>
@endsection

@section('footer')
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB2IlrXHus1WDRwmSIbwDKY3ByC9TBtcQ4&signed_in=true&v=3.exp&libraries=places&sensor=true" ></script>
    <script type="text/javascript" src="{!! asset('js/jquery.geocomplete.js') !!}"></script>

    <script type="text/javascript">
        var map;
        var marker;
        var distance;
        /*Omogucava autocomplite i sakriva polje sa cijenama
        * iscrtava kartu i pokusava locirati korisnika*/
        $( document ).ready(function() {
            $('#cijene').hide();
            $(".geocomplete").geocomplete();
            var origin_place_id = null;
            var destination_place_id = null;
            var travel_mode = google.maps.TravelMode.DRIVING;
            var map = new google.maps.Map(document.getElementById('map'), {
                mapTypeControl: false,
                center: {lat: 45.81, lng: 16},
                zoom: 13
            });
            // If the browser supports the Geolocation API
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
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);

            var origin_input = document.getElementById('pocetna');
            var destination_input = document.getElementById('odredisna');

            var origin_autocomplete = new google.maps.places.Autocomplete(origin_input);
            origin_autocomplete.bindTo('bounds', map);
            var destination_autocomplete = new google.maps.places.Autocomplete(destination_input);
            destination_autocomplete.bindTo('bounds', map);



            origin_autocomplete.addListener('place_changed', function() {
                var place = origin_autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                expandViewportToFitPlace(map, place);
                origin_place_id = place.place_id;
                route(origin_place_id, destination_place_id, travel_mode,
                        directionsService, directionsDisplay);
            });

            destination_autocomplete.addListener('place_changed', function() {
                var place = destination_autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                expandViewportToFitPlace(map, place);
                destination_place_id = place.place_id;
                route(origin_place_id, destination_place_id, travel_mode,
                        directionsService, directionsDisplay);
            });
        });
        function expandViewportToFitPlace(map, place) {
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
        }
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
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

        /*Na promjenu pocetne ili zavrsne, imaju klasu geocomplete, izracunava udaljenost i poziva funkciju za iscrtavanje puta*/
        $(".geocomplete").change(function(){

            var pocetna=$("#pocetna").val();
            var odredisna=$("#odredisna").val();

            var service = new google.maps.DistanceMatrixService;
            service.getDistanceMatrix({
                origins: [pocetna],
                destinations: [odredisna],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, function(response, status) {
                if (status !== google.maps.DistanceMatrixStatus.OK) {
                    alert('Error was:');
                }
                else {
                    if(marker !=null){
                        deleteMarkers();
                    }
                    var originList = response.originAddresses;
                    var destinationList = response.destinationAddresses;
                    var output = document.getElementById('output');
                    output.innerHTML = '';
                    $("#udaljenost").css("display","inline");
                    for (var i = 0; i < originList.length; i++) {
                        var results = response.rows[i].elements;
                        for (var j = 0; j < results.length; j++) {
                            output.innerHTML += results[j].distance.text;
                            distance = results[j].distance.value;
                            //output.innerHTML+= " "+ results[j].duration.text;
                        }
                    }
                }
            });
        });
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

        /*Dohvaca cijene sa servera*/
        function getPrice() {
            distance = distance / 1000;
            distance = distance.toFixed(2);
            $.ajax({
                type: 'GET',
                url: "{{ url('order/getPrice') }}/" + distance,
                success: function (data) {
                    var cijene = data;
                    document.getElementById("cjene").innerHTML = "<p><b>Cijena</b></p>";
                    for (i = 0; i < cijene.length; i++) {
                        document.getElementById("cjene").innerHTML += "<p>" + cijene[i].name + " " + cijene[i].price + " kn</p>";
                    }
                    $('#cijene').show();
                    $('.saznaj-cijenu').hide();
                }
            });
        }

        function getAlert() {
            var distanceLeng = $("#output").text().length - 3;
            var distance = $("#output").text();
            var dist = distance.substring(0, distanceLeng);
            document.cookie = "distance=" + dist;
        }

    </script>
@endsection

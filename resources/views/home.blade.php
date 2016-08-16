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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2IlrXHus1WDRwmSIbwDKY3ByC9TBtcQ4&signed_in=true&v=3.exp&libraries=places&sensor=true" ></script>
    <script type="text/javascript" src="{!! secure_asset('js/app.js') !!}"></script>
    <script type="text/javascript">
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
    </script>

@endsection

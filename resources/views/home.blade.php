@extends('layouts.app')

@section('content')

        <div class="row padding">
            <div class="col-md-6">
                {{ Form::open(array('url'=>'order')) }}
                <div class="form-group">
                    {{ Form::label('startAddress','Početna adresa') }}
                    {{ Form::text('startAddress',null,array('class'=>'form-control geocomplete','id'=>'pocetna','placeholder'=>'Početna adresa')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('endAddress','Odredišna adresa') }}
                    {{ Form::text('endAddress',null,array('class'=>'form-control geocomplete','id'=>'odredisna','placeholder'=>'Završna adresa')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('description','Napomena') }}
                    {{ Form::textarea('description',null,array('class'=>'form-control')) }}
                </div>
                <div class="form-group">
                    <label for="udaljenost" id="udaljenost">Udaljenost:</label>
                    <p id="output"></p>
                </div>
                <div id="odabir">
                    <div id="cijene">

                    </div>
                    <div class="form-group">
                        {{ Form::label('company_id','Odaberite taxi službu koju želite naručiti:') }}
                        {{ Form::select('company_id', $taxi,null,array('class'=>'form-control')) }}
                    </div>
                    <div class="form-group">
                        @if(Auth::guest())
                            <a href="#" class="btn btn-primary disabled">Naruci</a>
                        @else
                            {{ Form::submit('Naruči',array('class'=>'btn btn-primary')) }}
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
    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
    <script type="text/javascript">
        function getPrice() {
            $.ajax({
                type: 'GET',
                url: "{{ route('getPrice') }}",
                success: function (cijene) {
                    $("#cijene").html('<p><b>Cijene:</b></p>');
                    for (i = 0; i < cijene.length; i++) {
                        $("#cijene").append("<p>" + cijene[i].name + " " + cijene[i].price + " kn</p>");
                    }
                    $('#odabir').show();
                    $('.saznaj-cijenu').hide();
                }
            });
        }
    </script>

@endsection

@extends('layouts.app')

@section('content')

        <h2>Uređivanje taxi službe: {{ $taxi->name }}</h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                {!! Form::model($taxi,array('method'=>'PATCH','url'=>'taxi/'.$taxi->id)) !!}
                @include('taxi._createOrEdit',['submitButton'=>'Spremi izmjene'])
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('errors.list')
            </div>

        </div>




@endsection
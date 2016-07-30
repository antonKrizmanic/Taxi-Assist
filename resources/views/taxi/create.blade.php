@extends('layouts.app')

@section('content')


        <h2>Dodavanje taxi sluzbe</h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                {!! Form::open(array('url'=>'taxi')) !!}
                    @include('taxi._createOrEdit',['submitButton'=>'Dodaj'])
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            @include('errors.list')
        </div>



@endsection
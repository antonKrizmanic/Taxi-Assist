@extends('layouts.app')

@section('content')

        <h2>Uredivanje taxi sluzbe: {{ $user->name }}</h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                {!! Form::model($user,array('method'=>'PATCH','url'=>'user/'.$user->id)) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Ime') !!}
                    {!! Form::text('name',null,array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'E-mail') !!}
                    {!! Form::email('email',null,array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">

                </div>
                    {!! Form::submit("Spremi",array('class'=>'btn btn-primary')) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('errors.list')
            </div>

        </div>




@endsection
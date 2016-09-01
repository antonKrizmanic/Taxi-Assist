@extends('layouts.app')

@section('content')


        <h2>Taxi službe</h2>
        <hr>
        <a href="{{ url('taxi/create') }}" class="btn btn-primary">Dodaj</a>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>Rb</th>
                    <th>Naziv taxi službe</th>
                    <th>Cijena starta</th>
                    <th>Kilometri uključeni u start</th>
                    <th>Cijena po km</th>
                    <th>Cijena čekanja /h</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
            {{--*/ $index = 1 /*--}}
            @foreach($taxis as $taxi)
                <tr>
                    <td>{{  $index }}</td>
                    <td> {{ $taxi->name }} </td>
                    <td> {{ $taxi->startPrice }} kn </td>
                    <td> {{ $taxi->freeKm }} km </td>
                    <td> {{ $taxi->kmPrice }} kn </td>
                    <td> {{ $taxi->waitingPrice }} kn </td>
                    {{ Form::open(['method'=>'DELETE','route'=>['taxi.destroy',$taxi->id],'onsubmit' => 'return ConfirmDelete()']) }}
                        <td><a href="{{ url('taxi/'.$taxi->id.'/edit') }}" class="btn btn-default">Uredi</a>
                            {{ Form::submit('Obriši',['class'=>'btn btn-danger']) }}                        </td>
                    {{ Form::close() }}
                </tr>
                {{--*/ $index ++ /*--}}
            @endforeach
            </tbody>
        </table>




@endsection
@extends('layouts.app')

@section('content')

    <h2>Narudzbe</h2>
    <hr>
    <a href="{{ url('order/create') }}" class="btn btn-primary">Dodaj</a>
    {{--*/ $index = 1 /*--}}
    <table class="table">
        <thead>
        <tr>
            <th>Rb</th>
            <th>Korisnik</th>
            <th>Taxi sluzba</th>
            <th>Pocetna adresa</th>
            <th>Zavrsna adresa</th>
            <th>Datum i vrijeme</th>
            <th>Akcija</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $index }}</td>
                <td>{{ $order->user }}</td>
                <td>{{ $order->taxi }}</td>
                <td>{{ $order->startAddress }}</td>
                <td>{{ $order->endAddress }}</td>
                <td>{{ $order->created_at }}</td>
                {{ Form::open(['method'=>'DELETE','route'=>['order.destroy',$order->id]]) }}
                <td>{{ Form::submit('Delete',['class'=>'btn btn-danger']) }}</td>
                {{ Form::close() }}
            </tr>
            {{--*/ $index++ /*--}}
        @endforeach
        </tbody>
    </table>


@endsection
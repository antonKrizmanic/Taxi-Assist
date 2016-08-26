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
            <th>Taxi služba</th>
            <th>Početna adresa</th>
            <th>Završna adresa</th>
            <th>Udaljenost</th>
            <th>Cijena</th>
            <th>Datum i vrijeme</th>
            <th>Akcija</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td><a href="{{ url('order/'.$order->id) }}">{{ $index }}</td>
                <td>{{ $order->user }}</td>
                <td>{{ $order->taxi }}</td>
                <td>{{ $order->startAddress }}</td>
                <td>{{ $order->endAddress }}</td>
                <td>{{ $order->distance }} km</td>
                <td>{{ $order->price }} kn</td>
                <td>{{ $order->created_at }}</td>
                {{ Form::open(['method'=>'DELETE','route'=>['order.destroy',$order->id],'onsubmit'=>'return ConfirmDelete() ']) }}
                <td>{{ Form::submit('Obriši',['class'=>'btn btn-danger']) }}</td>
                {{ Form::close() }}
            </tr>
            {{--*/ $index++ /*--}}
        @endforeach
        </tbody>
    </table>


@endsection
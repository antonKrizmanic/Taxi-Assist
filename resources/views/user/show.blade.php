@extends('layouts.app')

@section('content')
    <h2>Narudzbe korisnika: {{ $user->name }}</h2>

    <table class="table table-responsive table-striped">
        <thead>
            <tr>
                <th>Rb</th>
                <th>Taxi sluzba</th>
                <th>Pocetna adresa</th>
                <th>Zavrsna adresa</th>
                <th>Udaljenost</th>
                <th>Cijena</th>
            </tr>
        </thead>
        <tbody>
            {{--*/ $index = 1 /*--}}
            @foreach($orders as $order)
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $order->taxi->name }}</td>
                    <th>{{ $order->startAddress }}</th>
                    <th>{{ $order->endAddress }}</th>
                    <th>{{ $order->distance }}</th>
                    <th>{{ $order->price }}</th>
                </tr>
                {{--*/ $index ++ /*--}}
            @endforeach
        </tbody>
    </table>

@endsection
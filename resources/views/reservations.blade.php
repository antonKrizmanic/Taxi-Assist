@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Moje rezervacije</h2>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Pocetna adresa</th>
                <th>Odredisna adresa</th>
                <th>Udaljenost</th>
                <th>Cijena</th>
                <th>Taxi prijevoznik</th>
                <th>Datum</th>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->startAddress }}</td>
                        <td>{{ $order->endAddress }}</td>
                        <td>{{ $order->distance }} km</td>
                        <td>{{ $order->price }} kn</td>
                        <td>{{ $order->taxiCompany}}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>




@endsection
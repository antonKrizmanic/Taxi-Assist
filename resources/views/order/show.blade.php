@extends('layouts.app')

@section('content')
    <h2>Detalji o narudžbi</h2>

    <h4>Ime korisnika:</h4>
    <p>{{ $order->user}}</p>

    <h4>Taxi služba:</h4>
    <p>{{ $order->taxi }}</p>

    <h4>Početna adresa:</h4>
    <p>{{ $order->startAddress }}</p>

    <h4>Završna adresa:</h4>
    <p>{{ $order->endAddress }}</p>

    <h4>Udaljenost:</h4>
    <p>{{ $order->distance}} km</p>

    <h4>Cijena:</h4>
    <p>{{ $order->price}} kn</p>

    <h4>Datum i vrijeme:</h4>
    <p>{{ $order->created_at}}</p>

@endsection
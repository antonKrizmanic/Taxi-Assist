@extends('layouts.app')

@section('content')


        <h2>Registrirani korisnici</h2>
        <hr>
        <a href="{{ url('user/create') }}" class="btn btn-primary">Dodaj</a>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Rb</th>
                    <th>Ime</th>
                    <th>E-mail</th>
                    <th>Telefon</th>
                    <th>Registriran</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
            {{--*/ $index = 1 /*--}}
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ url('user/'.$user->id) }}">{{ $index }}</a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at }}</td>
                        {{ Form::open(['method'=>'DELETE','route'=>['user.destroy',$user->id],'onsubmit'=>'return ConfirmDelete()']) }}
                        <td><a href="{{ url('user/'.$user->id.'/edit') }}" class="btn btn-default">Uredi</a>
                            {{ Form::submit('Obriši',['class'=>'btn btn-danger']) }}</td>
                        {{ Form::close() }}
                    </tr>
                    {{--*/ $index ++ /*--}}
                @endforeach
            </tbody>
        </table>
        <script>

        </script>



@endsection
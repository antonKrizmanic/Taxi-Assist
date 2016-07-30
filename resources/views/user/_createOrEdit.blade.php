<div class="form-group">
    {!! Form::label('name', 'Ime') !!}
    {!! Form::text('name',null,array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('email', 'E-mail') !!}
    {!! Form::email('email',null,array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password',array('class'=>'form-control')) !!}
</div>
<div class="form-group">

</div>
{!! Form::submit($submitButton,array('class'=>'btn btn-primary')) !!}
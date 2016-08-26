<div class="form-group">
    {!! Form::label('name', 'Naziv') !!}
    {!! Form::text('name',null,array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('startPrice', 'Start') !!}
    {!! Form::number('startPrice',null,array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('freeKm', 'Kilometri uključeni u start:') !!}
    {!! Form::number('freeKm',0,array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('kmPrice', 'Cijena po kilometru:') !!}
    {!! Form::number('kmPrice',null,array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('waitingPrice', 'Cijena čekanja:') !!}
    {!! Form::number('waitingPrice',null,array('class'=>'form-control')) !!}
</div>
<div class="form-group">

</div>
{!! Form::submit($submitButton,array('class'=>'btn btn-primary')) !!}
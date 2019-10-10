@extends('layouts.admin')
{!!Html::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
@section('pagina')
Personal
@stop
@section('contenido')	
	@if(Session::has('message'))
	<?php $message=Session::get('message') ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get('message')}}
		</div>
	@endif
	{!!Form::open(['route'=>'personal', 'method'=>'GET'])!!}
	<div class="col-md-12">
	<div class="col-md-4">
		{!!Form::text('expediente',null,['class'=>'form-control','placeholder'=>'Ingresa el número de empleado'])!!}
	</div>
	<div class="col-md-4">
		{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del empleado'])!!}
	</div>
	<div class="col-md-4">
		{!!Form::submit('Buscar',['class'=>'btn btn-primary'])!!}
	</div>
	<div style="margin-top:10px;" class="col-md-4">
		{{ HTML::linkRoute('personal.create', 'Añadir nuevo', array(), array('class'=>'btn btn-success')) }}
		</div>
	</div>
	{!!Form::close()!!}
	
	<table class="table table-hover table-striped">
	<thead>
		<th>No. Emp.</th>
		<th>Nombre</th>
		<th>Turno</th>
	</thead>
	@foreach($personal as $personals)
	<tbody>
		<td>{{$personals->expediente}}</td>
		<td>{{$personals->nombre}}</td>
		<td>{{$personals->jornada}}</td>
		<td>
		<div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-option-horizontal"></span> 
            </button>
            <ul class="dropdown-menu">
				<li>
					{!!link_to_route('checadas.show', $title = 'Checadas', $parameters = $personals->id, $attributes = ['class'=>'glyphicon glyphicon-ok']);!!}	
				</li>
				<li role="separator" class="divider" ></li>
				<li>
					{!!link_to_route('personal.edit', $title = 'Modificar', $parameters = $personals->id, $attributes = ['class'=>'glyphicon glyphicon-pencil']);!!}
				</li>
				<li style="display: none;">
					{!!link_to_route('horarios.show', $title = 'Horario', $parameters = $personals->id, $attributes = ['class'=>'glyphicon glyphicon-calendar']);!!}
				</li>
				<li style="display: none;">
					<a href="/reportes/reporteQuincenal/{{ $personals->id }}" class="glyphicon glyphicon-download-alt" title="Generar reporte quincenal">Generar reporte </a>
				</li>
			</ul>
		</div>
	</tbody>
	@endforeach	
	</table>			
	{!!$personal->render()!!}
@endsection
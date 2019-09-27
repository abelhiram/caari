<?php use App\Http\Controllers\checadasController;
if(!isset($_GET['fechaInicio'])){
	$fechainicio = date("Y-m-d");
	$horasPendientes=null;
	$horasExtras=null;
} else{
	$fechainicio = $_GET['fechaInicio'];
	$horasPendientes;
	$horasExtras;
}

if(!isset($_GET['fechaFinal'])){
	$fechaFinal = date("Y-m-d");
} else{
	$fechaFinal = $_GET['fechaFinal'];
}
if(!isset($_GET['id'])){
	$id = date("1");
} else{
	$id = $_GET['id'];
}
?>
@extends('layouts.admin')
{!!Html::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
@section('pagina')
@foreach($personal as $personal)
	Expediente:
	{{$personal->expediente}}
	Nombre:
	{{$personal->nombre}}
	
@endforeach
@stop
@section('contenido')	
	@if(Session::has('message'))
	<?php $message=Session::get('message') ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get('message')}}
		</div>
	@endif
	
	<div class="col-md-8">
		{!!Form::open(['route'=>'checadas', 'method'=>'GET','class' => ''])!!}
		
		<div class="col-md-6">
			Fecha de inicio
			{!!Form::date('fechaInicio', \Carbon\Carbon::now()->format('Y-m-d'),['class' => 'form-control'])!!}
			Fecha final
			{!!Form::date('fechaFinal', \Carbon\Carbon::now()->format('Y-m-d'),['class' => 'form-control'])!!}
		</div>
	
		<div class="col-md-3">
			{!!Form::submit('Buscar',['class'=>'btn btn-primary btn-block','style'=>'margin-top:20px'])!!}
		</div>
		<div class="col-md-12">
			{!!link_to_route('checadas.crear', $title = 'Registrar checada', $parameters = $personal->id, $attributes = ['class'=>'btn btn-success','style'=>'margin-top:10px;']);!!}		
			{!!link_to_route('horarios.show', $title = 'Horario', $parameters = $personal->id, $attributes = ['class'=>'btn btn-primary','style'=>'margin-top:10px;margin-left:10px']);!!}
			{!!link_to_route('personal', $title = 'Regresar', $parameters = null, $attributes = ['class'=>'btn btn-warning','style'=>'margin-top:10px;margin-left:10px']);!!}
		</div>
	</div>
	<h4>{{$fechainicio}}</h4><h4>{{$fechaFinal}}</h4>
	<h4 style="">{{$horasPendientes}}</h4>
	<h4>{{$horasExtras}}</h4>
	<div style="display:none;">
			{!!Form::text('id', $personal->id ,['class' => 'form-control'])!!}
			{!!Form::close()!!}
			</div>
		<table class="table">
		<thead>
			<th>Hora de entrada</th>
			<th>Entrada</th>
			<th>Hora de salida</th>
			<th>Salida</th>
			<th>salida permiso</th>
			<th>salida permiso</th>
			<th>comentario</th>
			<th>fecha</th>
		</thead>
		@foreach($checada as $checadas)
		<tbody>
			<td>{{$checadas->hora}}</td>
			@if($checadas->checada==0)
			<td>Con bono</td>
			@endif
			@if($checadas->checada==1)
			<td>Asistencia</td>
			@endif
			@if($checadas->checada==2)
			<td>Retardo</td>
			@endif
			@if($checadas->checada==3)
			<td>Inasistencia</td>
			@endif
			@if($checadas->checada==4)
			<td>Incapacidad</td>
			@endif
			@if($checadas->checada==5)
			<td>Omision de checada</td>
			@endif
			@if($checadas->checada==6)
			<td>Canje de tiempo extra</td>
			@endif
			@if($checadas->checada==7)
			<td>Día económico</td>
			@endif
			@if($checadas->checada==8)
			<td>Comisión</td>
			@endif
			@if($checadas->checada==9)
			<td>Salida</td>
			@endif
			@if($checadas->checada==10)
			<td>Salida anticipada</td>
			@endif	
			@if($checadas->checada==11)
			<td>Permiso por horas inicio</td>
			@endif						
			@if($checadas->checada==11)
			<td>Permiso por horas fin</td>
			@endif	
			<td>{{$checadas->hora_salida}}</td>
			@if($checadas->checada_salida==1)
			<td>Salida normal</td>
			@endif
			@if($checadas->checada_salida==2)
			<td>Salida anticipada</td>
			@endif
			<td>{{$checadas->entradaHoras}}</td>
			<td>{{$checadas->salidaHoras}}</td>
			<td>{{$checadas->comentario}}</td>
			<td>{{$checadas->fecha}}</td>
			<td>
				{!!link_to_route('checadas.edit', $title = 'Editar', $parameters = $checadas->id, $attributes = ['class'=>'btn btn-success']);!!}
			</td>
		</tbody>
		@endforeach	
		</table>
		{!!$checada->render()!!}
	
	@endsection
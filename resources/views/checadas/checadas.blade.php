
<?php use App\Http\Controllers\checadasController;
if(!isset($_GET['fechaInicio'])){
	$fechainicio = date("Y-m-d");
	$horasPendientes=null;
	$horasExtra=null;
} else{
	$fechainicio = $_GET['fechaInicio'];
	$horasPendientes;
	$horasExtra;
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
	No. de Empleado:
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
			{!!link_to_route('horarios.show', $title = 'Horario', $parameters = $personal->id, $attributes = ['class'=>'btn btn-primary','style'=>'margin-top:10px;margin-left:10px;display:none;']);!!}
			{!!link_to_route('personal', $title = 'Regresar', $parameters = null, $attributes = ['class'=>'btn btn-warning','style'=>'margin-top:10px;margin-left:10px']);!!}
		</div>
	</div>
	<h4>{{$fechainicio}}</h4><h4>{{$fechaFinal}}</h4>
	<h4 style="">{{$horasPendientes}}</h4>
	<h4 style="">{{$horasExtra}}</h4>
	<div style="display:none;">
			{!!Form::text('id', $personal->id ,['class' => 'form-control'])!!}
			{!!Form::close()!!}
			</div>

		
    
							
	<div class="col-md-12"><br>
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Entradas/salidas</a></li>
              <li><a href="#tab_2" data-toggle="tab">Horas extra</a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
			  <table class="table">
					<thead>
						<th>Hora de entrada</th>
						<th>Hora de salida</th>
						<th>Permiso Inicio</th>
						<th>Permiso Fin</th>
						<th>Comentario</th>
						<th>Fecha</th>
						<th>Falta</th>
					</thead>
					@foreach($checada as $checadas)
					<tbody>
						<td>{{$checadas->hora}}</td>
						<td>{{$checadas->hora_salida}}</td>
						<td>{{$checadas->entradaHoras}}</td>
						<td>{{$checadas->salidaHoras}}</td>
						<td>{{$checadas->comentario}}</td>
						<td>{{$checadas->fecha}}</td>
						@if($checadas->hora_salida==null)
						<td><label class="glyphicon glyphicon-ok"></label></td>
						@else
						<td></td>
						@endif
						<td>
							{!!link_to_route('checadas.edit', $title = 'Modificar', $parameters = $checadas->id, $attributes = ['class'=>'btn btn-default']);!!}
						</td>
					</tbody>
					@endforeach	
				</table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
			  <table class="table">
					<thead>
						<th>Inicio</th>
						<th>Término</th>
						<th>Fecha</th>
					</thead>
					@foreach($extras as $extras)
					<tbody>
						<td>{{$extras->hora_entrada}}</td>
						<td>{{$extras->hora_salida}}</td>
						<td>{{$extras->fecha}}</td>
					</tbody>
					@endforeach
				</table>
              </div>
			  
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

	@endsection
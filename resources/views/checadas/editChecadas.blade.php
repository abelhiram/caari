@extends('layouts.admin')
{!!Html::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
@section('contenido')	
@section('pagina')
@foreach($personal as $personal)
	Expediente: {{$personal->expediente}}
	Nombre: {{$personal->nombre}}
@endforeach
@stop
@section('contenido')	
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                	<div class="card-body">
                        <div class="form-group row" style="margin-top:15px;">
                            
                            <div class="col-md-6">
							{!!Form::model($mdlChecadas,['route'=>['checadas.update',$mdlChecadas->id],'method'=>'PUT', 'class'=>'','style'=>'display:none;'])!!}
								{!!Form::text('expediente',null,['id'=>'expediente','class'=>'form-control','placeholder'=>'ingresa el expediente'])!!}
                            </div>
						</div>
						<div class="form-group row">

                            <div class="col-md-6">
							{!!Form::text('id_tblPersonal',$personal->id,['style'=>'display:none;','placeholder'=>'expediente o id'])!!}
                            </div>
                        </div>
						<div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Hora de entrada</label>
                            <div class="col-md-6">
							{!! Form::time('hora',null, ['class' => 'form-control']) !!} 
                            </div>
						</div>
						<div class="form-group row" style="display: none;">
                            <label for="checada" class="col-md-4 col-form-label text-md-right">Checada de entrada</label>
                            <div class="col-md-6">
								{!!Form::select('checada',['0'=>'Entrada con bono','1'=>'Asistencia','2'=>'Retardo','3'=>'Inasistencia','4'=>'Incapacidad','5'=>'Omisión de checada','6'=>'Canje de tiempo extra','7'=>'Día económico','8'=>'Comisión','9'=>'Salida','10'=>'Salida anticipada','11'=>'Permiso por horas inicio','12'=>'Permiso por horas fin'],null, ['class' => 'form-control'])!!}
                            </div>
						</div>
						<div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Hora de salida</label>
                            <div class="col-md-6">
							{!! Form::time('hora_salida',null, ['class' => 'form-control']) !!} 
                            </div>
						</div>
						<hr width="400px">
						<div class="form-group row" style="display: none;">
                            <label for="checada" class="col-md-4 col-form-label text-md-right">Checada de salida</label>
                            <div class="col-md-6">
								{!!Form::select('checada_salida',['1'=>'Salida normal','2'=>'Salida anticipada'],null, ['class' => 'form-control'])!!}
                            </div>
						</div>
						<div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Permiso desde</label>
                            <div class="col-md-6">
							{!! Form::time('entradaHoras',null, ['class' => 'form-control']) !!} 
                            </div>
						</div>
						<div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Permiso hasta</label>
                            <div class="col-md-6">
							{!! Form::time('salidaHoras',null, ['class' => 'form-control']) !!} 
                            </div>
						</div>
						<hr width="400px">
						<div class="form-group row">
                            <label for="comentario" class="col-md-4 col-form-label text-md-right">Comentario</label>
                            <div class="col-md-6">
								{!!Form::textarea('comentario', null,['size' => '10x2','class'=>'form-control','placeholder'=>'Comentario'])!!}
                            </div>
						</div>
						<div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha</label>
                            <div class="col-md-6">
								{!!Form::date('fecha', NULL,['class'=>'form-control',''])!!}
                            </div>
						</div>
						<div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
							{!!Form::submit('Guardar cambios',['class'=>'btn btn-primary'])!!}
							{!!link_to_route('checadas.show', $title = 'Cancelar', $parameters = $personal->id, $attributes = ['class'=>'btn btn-warning']);!!}
							{!!Form::close()!!}
							{!!Form::close()!!}	
                            </div>
						</div>
							{!!Form::open(['route'=>['checadas.destroy',$mdlChecadas->id],'method'=>'DELETE'])!!}
							{!!Form::submit('Eliminar',['class'=>'btn btn-danger pull-right','style'=>'margin-top:-49px;margin-right:130px;'])!!}
							{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
	
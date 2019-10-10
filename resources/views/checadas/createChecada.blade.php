@extends('layouts.admin')
{!!Html::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
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
							{!!Form::open(['route'=>'checadas.store', 'method'=>'POST', 'style'=>'display:none;'])!!}
								{!!Form::text('expediente',null,['id'=>'expediente','class'=>'form-control','placeholder'=>'ingresa el expediente'])!!}
                            </div>
						</div>
						<div class="form-group row">
						Inasistencia: <input type="checkbox" id="myCheck"  onclick="myFunction()">
                            <div class="col-md-6">
							{!!Form::text('id_tblPersonal',$personal->id,['style'=>'display:none;','placeholder'=>'expediente o id'])!!}
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Hora</label>
                            <div class="col-md-6">
							{!! Form::time('hora',\Carbon\Carbon::now()->toTimeString(), ['id' => 'hora','class' => 'form-control']) !!} 
                            </div>
						</div>
						<div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha</label>
                            <div class="col-md-6">
								{!!Form::date('fecha', \Carbon\Carbon::now(),['class'=>'form-control'])!!}
                            </div>
						</div>
						<div class="form-group row" id="area" style="display:none;">
                            <label for="comentario" class="col-md-4 col-form-label text-md-right">Comentario</label>
                            <div class="col-md-6">
								{!!Form::textarea('comentario', null,['id'=>'com','style'=>'','size' => '10x2','class'=>'form-control','placeholder'=>'Comentario'])!!}
                            </div>
						</div>
						<div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">
								{!!Form::submit('Registrar checada',['class'=>'btn btn-primary'])!!}
								{!!link_to_route('checadas.show', $title = 'Cancelar', $parameters = $personal->id, $attributes = ['class'=>'btn btn-warning']);!!}
								{!!Form::close()!!}
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function myFunction() {
			var checkBox = document.getElementById("myCheck");
			var text = document.getElementById("area");
			var com = document.getElementById("com");
			var hora = document.getElementById("hora");
			if (checkBox.checked == true){
				text.style.display = "";
				com.value= "INASISTENCIA";
				hora.value =""
			} else {
				text.style.display = "none";
				com.value = "";
			}
		}
	</script>
@endsection
	
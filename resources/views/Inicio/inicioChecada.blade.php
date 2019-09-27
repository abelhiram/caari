{!!Html::style('https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css')!!}
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UES Virtual - Checador</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script type="text/javascript">
        	function startTime() {
			    var today = new Date();
			    var hr = today.getHours();
			    var min = today.getMinutes();
			    var sec = today.getSeconds();
			    ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
			    hr = (hr == 0) ? 12 : hr;
			    hr = (hr > 12) ? hr - 12 : hr;
			    //Add a zero in front of numbers<10
			    hr = checkTime(hr);
			    min = checkTime(min);
			    sec = checkTime(sec);
			    document.getElementById("hora").innerHTML = hr + " : " + min + " : " + sec + " " + ap;
			    var time = setTimeout(function(){ startTime() }, 500);
			}
			function checkTime(i) {
			    if (i < 10) {
			        i = "0" + i;
			    }
			    return i;
			}
        </script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 60px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                width: 600px;
            }

            .m-b-md {
                margin-bottom: 15px;
            }
        </style>
    </head>

    <body onload="startTime()">
        <div class="flex-center position-ref full-height">
                <div class="top-right links">              
                    <a href="{{ url('personal') }}">Home</a>
                    <a href="{{ url('login') }}">Login</a>
                    <a href="{{ url('/permiso') }}">Permiso</a>
                
                </div>

            
            
            <div class="content">
                <div class="mb-5">
                    <img src="img/logo_virtual.png " alt="UES Virtual" class="img-fluid">
                </div>
                <div class="title m-b-md">
                	{!!Form::open(['route'=>'checadas.store', 'method'=>'POST', 'class'=>''])!!}
                	<label id="hora"></label>

					{!!Form::text('id_tblPersonal',null,['class'=>'form-control','placeholder'=>'expediente o id'])!!}

					<!--\Carbon\Carbon::now()->toTimeString()-->
					
					<hr>
					{!!Form::submit('Check-in',['class'=>'btn btn-primary btn-block'])!!}
                    
					
					{!!Form::close()!!}
					
	                <div class="links">
	                	@if(Session::has('message'))
				          <?php $message=Session::get('message') ?>
				          <div role="alert">
				          	<h5>{{Session::get('message')}}</h5>
				          
				          </div>
				        @endif 
	                    <!--<a href="{{ url('reportes') }}"> Reportes </a>-->
	                </div>
                </div>
            </div>    
        </div>
    </body>
</html>


	
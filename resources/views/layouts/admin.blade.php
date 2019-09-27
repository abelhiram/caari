
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>UES Virtual - {{ucfirst(Route::currentRouteName())}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{ url('css/bootstrap3-7.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('css/iconions.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ url('css/ues.css') }}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>U</b>ES</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>UES Virtual</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <!-- Sidebar izquierda mostrar-ocultar-->
      
    <!-- Navegación del header -->
    <nav class="navbar navbar-static-top">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown messages-menu">
            <a class="active-tab" href="{{ url('personal') }}">Personal</a>
          </li>     
          <li class="dropdown messages-menu">
            <a class="active-tab" href="{{ url('reportes') }}">Reportes</a>
          </li>  
          <li class="dropdown messages-menu">
            <a class="active-tab" href="{{ url('reportesBono') }}">Reportes bono</a>
          </li>       
          <!-- Menú de usuario -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ url('img/ues.jpg ') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Imagen -->
              <li class="user-header">
                <img src="{{ url('img/ues.jpg ') }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}
                  
                </p>
              </li>
               
             
              <!-- Opciones de administracióin y deslogueo-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('register') }}" class="btn btn-default btn-flat">Registrar admin</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Cerrar sesión') }}

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control del sidebar de la derecha -->
        </ul>
      </div>
    </nav>
              <!-- Fin del header -->
  </header>

  <!-- =============================================== -->

  <!-- Sidebarr izquierda principal -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
              <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="http://assets.stickpng.com/thumbs/585e4beacb11b227491c3399.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="glyphicon glyphicon-off"></i> Online</a>
        </div>
      </div>
      
        <li class="header">Contenido de la página</li>
        <li class="treeview active">
          <a href="#">
            <i class="glyphicon glyphicon-home"></i> <span>Inicio</span>
            <span class="pull-right-container">
              <i class="glyphicon glyphicon-chevron-down"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="dropdown messages-menu">
	          <a class="active-tab" href="{{ url('personal') }}">Personal</a>
	        </li>     
	        <li class="dropdown messages-menu">
	          <a class="active-tab" href="{{ url('reportes') }}">Reportes</a>
	        </li>  
	        <li class="dropdown messages-menu">
	          <a class="active-tab" href="{{ url('reportesBono') }}">Reportes bono</a>
	        </li>       
	        <li class="dropdown messages-menu">
	          <a class="active-tab" href="{{ url('register') }}">Registrar admin</a>
	        </li>
          </ul>
        </li>   
      </ul>
    </section>
    <!-- /.sidebar izquierda -->
  </aside>
  <!-- =============================================== -->
  <!-- Contenido de la página -->
  <div class="content-wrapper">
  <section class="content-header">
    <h1>
    @yield('pagina')
    </h1>
    <ol class="breadcrumb">
      <li>Ues virtual</li>
      <li class="active">{{ucfirst(Route::currentRouteName())}}</li>
    </ol>
  </section>
    <section class="content">
      <div class="box">
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  @section('contenido') 
                @show
                  @yield('otrocontenido') 
                </div>
              </div>
            </div> 
          </div> 
        </section> 
      </div>  
    </section> 
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> Alpha
    </div>
    <strong>UES Virtual &copy; 2019 <a href="{{ url('/') }}">Unidad académica --</a>.</strong> 
  </footer>

</div>
<!-- ./wrapper -->
	  <!-- jQuery 3 -->
	<script src="{{ url('js/jquery.min.js') }}"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{ url('js/bootstrap.min.js') }}"></script>
	<!-- FastClick -->
	<script src="{{ url('js/fastclick.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ url('js/adminlte.min.js') }}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ url('js/demo.js') }}"></script>
	<!-- SlimScroll -->
	<script src="{{ url('js/jquery.slimscroll.min.js') }}"></script>

  </body>
</html>
<?php

namespace App\Http\Controllers;
use App\mdlChecadas;
use App\mdlPersonal;
use App\mdlHorarios;
use App\mdlHoras;
use Session;
use Redirect;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class checadasController extends Controller
{

    public function entradas($personal,$hoy)
     {
        $entradas = mdlChecadas::where([
            ['id_tblPersonal', '=', $personal],
            ['hora', '!=', null],
            ['fecha', '=', $hoy],
        ])->orWhere([
            ['id_tblPersonal', '=', $personal],
            ['checada', '=', 1],
            ['fecha', '=', $hoy],
        ])->orWhere([
            ['id_tblPersonal', '=', $personal],
            ['checada', '=', 0],
            ['fecha', '=', $hoy],
        ])->orWhere([
            ['id_tblPersonal', '=', $personal],
            ['checada', '=', 2],
            ['fecha', '=', $hoy],
        ])->orWhere([
            ['id_tblPersonal', '=', $personal],
            ['checada', '=', 3],
            ['fecha', '=', $hoy],
        ])->orWhere([
            ['id_tblPersonal', '=', $personal],
            ['checada', '=', 5],
            ['fecha', '=', $hoy],
        ])->get();

        return $entradas;
     }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    public function horasExtras(Request $request)
    {
    	$personal = mdlPersonal::where('expediente', '=', $request['id'])->get(); 
        if($personal->count()==0){
            return "NO EXISTE ESE USUARIO";     
        }

        $nombre = $personal[0]->nombre;
        $fecha = date("Y-m-d");
        $hora = date('H:i:s');

        return $this->registroExtras($nombre,$personal[0]->id,$hora,$fecha); 
    }

    public function registroExtras($nombre,$personal,$hora,$fecha)
    {
    	$ext = mdlHoras::where([
            ['id_tblPersonal', '=', $personal],
            ['hora_entrada', '!=', null],
            ['fecha', '=', $fecha],
        ])->get();

        if($ext->count()==0){
        	$mdlExt = new mdlHoras();
	        $mdlExt->id_tblPersonal = $personal;
	        $mdlExt->hora_entrada = $hora;
	        $mdlExt->fecha = $fecha;
	        $mdlExt->save();

            //return 'Inicio de horas extra: '.$fecha.' '.$hora; 
            return 'Inicio de horas extra';
        }else{
        	$ext[0]->hora_salida = $hora;
            $ext[0]->save();
            //return 'Término de horas extra: '.$fecha.' '.$hora; 
        	return 'Término de horas extra'; 
        }
    }


    public function checar(Request $request)
    {
        $personal = mdlPersonal::where('expediente', '=', $request['id'])->get(); 
        if($personal->count()==0){
            return "NO EXISTE ESE USUARIO";     
        }

        $nombre = $personal[0]->nombre;
        $fecha = date("Y-m-d");
        $hora = date('H:i:s');

        return $this->registroUnHorario($nombre,$personal[0]->id,$hora,$fecha); 
    }

    public function registroUnHorario($nombre,$personal,$hora,$fecha){

        $registros = mdlChecadas::where([
            ['id_tblPersonal', '=', $personal],
            ['fecha', '=', $fecha],
        ])->count();
        $ayer = new Carbon('Yesterday');
        $registroAyer = mdlChecadas::where([
            ['id_tblPersonal', '=', $personal],
            ['fecha', '=', $ayer],
        ])->get();
        

        if($registros==0)
        {
            if($registroAyer->count()>0)
            {
                $masdeve = new Carbon($registroAyer[0]->hora);
                if($registroAyer[0]->hora_salida==null)
                {
                    if($masdeve->hour>=20)
                    {
                        $entrada = $this->entradas($personal,$ayer);
                        if($entrada[0]->entradaHoras != null && $entrada[0]->salidaHoras == null)
                        {
                            return 'Permiso por horas no atendido: registre su regreso';
                        }elseif($entrada[0]->entradaHoras != null && $entrada[0]->salidaHoras != null)
                        {
                            return $this->registrarSalida($entrada,$hora,$nombre,$var=1);
                        }elseif($entrada[0]->entradaHoras == null && $entrada[0]->salidaHoras == null)
                        {
                            return $this->registrarSalida($entrada,$hora,$nombre,$var=0);
                        }else
                        {
                            return 'error raro tipo 1';
                        } 
                    }else
                    {
                        return $this->primeraEntrada($nombre,$personal,$hora,$fecha);
                    }
                }else
                {
                    return $this->primeraEntrada($nombre,$personal,$hora,$fecha);
                } 
            }else
            {
                return $this->primeraEntrada($nombre,$personal,$hora,$fecha);
            }
            return $this->primeraEntrada($nombre,$personal,$hora,$fecha);         
        }else 
        {
            $entrada = $this->entradas($personal,$fecha);
            if($entrada[0]->entradaHoras != null && $entrada[0]->salidaHoras == null)
            {
                return 'Permiso por horas no atendido: registre su regreso';
            }elseif($entrada[0]->entradaHoras != null && $entrada[0]->salidaHoras != null)
            {
                return $this->registrarSalida($entrada,$hora,$nombre,$var=1);
            }elseif($entrada[0]->entradaHoras == null && $entrada[0]->salidaHoras == null)
            {
                return $this->registrarSalida($entrada,$hora,$nombre,$var=0);
            }else
            {
                return 'error raro';
            } 
        }
    }

    public function primeraEntrada($nombre,$personal,$hora,$fecha){
        $mdlChecadas = new mdlChecadas();
        $mdlChecadas->id_tblPersonal = $personal;
        $mdlChecadas->hora = $hora;
        $mdlChecadas->comentario = '';
        $mdlChecadas->fecha = $fecha;
        $mdlChecadas->save();
                
        //return 'Inicio de jornada.'.$fecha.' '.$hora; 
        return 'Entrada';
    }

    public function permiso(Request $request)
    {
        $personal = mdlPersonal::where('expediente', '=', $request['id'])->get(); 
        if($personal->count()==0)
        {
            return "NO EXISTE ESE USUARIO";     
        }

        $nombre = $personal[0]->nombre;
        $fecha = date("Y-m-d");
        $hora = date('H:i:s');

        $entrada = $this->entradas($personal[0]->id,$fecha);

        return $this->permisoPorHoras($entrada,$nombre,$personal[0]->id,$hora,$fecha); 
    }

    public function permisoPorHoras($entrada,$nombre,$personal,$hora,$fecha)
    {
        $entrada_count = $entrada->count();
        
        
        if($entrada_count>0)
        {
            if($entrada[0]->entradaHoras==null)
            {
                $entrada[0]->entradaHoras = $hora;
                $entrada[0]->save();
                return ' Comienzo de permiso por horas'; 
            }else{
                if($entrada[0]->salidaHoras==null)
                {
                    $entrada[0]->salidaHoras = $hora;
                    $entrada[0]->save();

                    $h1 = new \Carbon\Carbon($entrada[0]->entradaHoras);
                    $h2 = new \Carbon\Carbon($hora);
                    $diff=$h1->diffInMinutes($h2);  
                    $horasWork=$h1->diffInHours($h2);  

                    return 'tiempo a compensar '.$diff.' Minutos - (Total en horas : '.$horasWork.')';
                }
                else{
                    $h1 = new \Carbon\Carbon($entrada[0]->entradaHoras);
                    $h2 = new \Carbon\Carbon($entrada[0]->salidaHoras);
                    $diff=$h1->diffInMinutes($h2);  
                    $horasWork=$h1->diffInHours($h2);
                    return 'Ya hay registro de un permiso por horas. tiempo a compensar '.$diff.' Minutos - (Total en horas : '.$horasWork.')';
                }
            } 
        }else{
            return 'No hay registros de entrada';
        }
    }

    public function crear($id)
    {    
        $personal = mdlPersonal::where('id', '=', $id)->take(1)->get(); 
        if($personal->count()==0){
            Session::flash('message','Usuario inexistente');
            return Redirect::to('/personal');
        }
        $horario = mdlHorarios::where('id_tblPersonal', '=', $id)->get(); 
        $checada = mdlChecadas::where('id_tblPersonal', '=', $id)->get(); 
        return view('checadas.createChecada',compact('horario','personal','checada'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mdlChecadas = new mdlChecadas();
        
        $mdlChecadas->id_tblPersonal = $request->input('id_tblPersonal');
        $mdlChecadas->hora = $request->input('hora');  
        $mdlChecadas->fecha = $request->input('fecha'); 
        $mdlChecadas->comentario = $request->input('comentario'); 
        $mdlChecadas->save();
        Session::flash('message','Checada creada correctamente');
        //return 
        return Redirect::to('/checadas/'.$request['id_tblPersonal']);

    }

    

    public function registrarSalida($entrada,$hora,$nombre,$var){
        
        $entrada_count = $entrada->count();
        /*$h1 = new \Carbon\Carbon($entrada[0]->entradaHoras);
        $h2 = new \Carbon\Carbon($entrada[0]->salidaHoras);
        $diff=$h1->diffInMinutes($h2);  
        $horasWork=$h1->diffInHours($h2);  */

        $h1 = new \Carbon\Carbon($entrada[0]->hora);
        $h2 = new \Carbon\Carbon($hora);
        $tolerancia=$h1->diffInMinutes($h2);  

        if($entrada_count>0)
        {   
            if($tolerancia<30)
                {
                    return 'Entrada ya registrada'; 
                }else
                {    
                    $entrada[0]->hora_salida = $hora;
                    $entrada[0]->save();

                    if($var==1){
                        //return 'Término de jornada. Su entrada fue a las '.$entrada[0]->hora.' el día '.$entrada[0]->fecha.' (Tiempo pendiente hoy: '.$diff.': minutos) (Total en horas: '.$horasWork.')'; 
                        return 'Salida';
                    }else{
                        //return 'Término de jornada. Su entrada fue a las '.$entrada[0]->hora.' el día '.$entrada[0]->fecha; 
                        return 'Salida';
                    }
                }
            
        }else{
            return 'No hay registros de entrada';
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personal = mdlPersonal::where('id', '=', $id)->take(1)->get(); 
        if($personal->count()==0){
            Session::flash('message','Usuario inexistente');
            return Redirect::to('/personal');
        }
        $horario = mdlHorarios::where('id_tblPersonal', '=', $id)->get(); 
        $checada = mdlChecadas::where('id_tblPersonal', '=', $id)->paginate(50);
        $extras = mdlHoras::where('id_tblPersonal', '=', $id)->paginate(50);  
        return view('checadas/checadas',compact('horario','personal','checada','extras'));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mdlChecadas = mdlChecadas::find($id);
        if($mdlChecadas==null){
            return Redirect::to('/personal');
        }
        $personal = mdlPersonal::where('id', '=', $mdlChecadas->id_tblPersonal)->take(1)->get(); 
        return view('checadas.editChecadas',['mdlChecadas'=>$mdlChecadas],compact('personal'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mdlChecadas = mdlChecadas::find($id);
        $mdlChecadas->fill($request->all());
        $mdlChecadas->save();

        Session::flash('message','Editado correctamente');

        return Redirect::to('/checadas/'.$request['id_tblPersonal']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $horario = mdlHorarios::find($id);
        $checada = mdlChecadas::find($id);
        mdlChecadas::destroy($id);
        Session::flash('message','Eliminado correctamente');
        return Redirect::to('/checadas/'.$checada->id_tblPersonal);
    }

    public function index(Request $request)
    {
        $fechaInicio=$request->get('fechaInicio'); 
        $fechaFinal=$request->get('fechaFinal'); 
        $id=$request->get('id');

        $personal = mdlPersonal::where('id', '=', $id)->take(1)->get(); 
        if($personal->count()==0){
            Session::flash('message','Usuario inexistente');
            return Redirect::to('/personal');
        }
        $minPendientes=0;
        $horasPendientes=0;
        $hPend=0;
        $minExtra=0;
        $horasExtra=0;
        $horExt=0;

        $checada = mdlChecadas::where('id_tblPersonal', '=', $id)
        ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
        ->get();

        $extras = mdlHoras::where('id_tblPersonal', '=', $id)
        ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
        ->get();

        

        foreach($checada as $checadas){
            $h1 = new \Carbon\Carbon($checadas->entradaHoras);
            $h2 = new \Carbon\Carbon($checadas->salidaHoras);
            $diff=$h1->diffInMinutes($h2);  
            $minPendientes = $minPendientes+$diff;
            $hPend=$h1->diffInHours($h2);
        }
        
        foreach($extras as $extra){
            $h3 = new \Carbon\Carbon($extra->hora_entrada);
            $h4 = new \Carbon\Carbon($extra->hora_salida);
            $diff2=$h3->diffInMinutes($h4);  
            $minExtra = $minExtra+$diff2;
            $horExt=$h3->diffInHours($h4);
        }


        $horasPendientes = $minPendientes-($hPend*60);
        
        $horasPendientes = ' Salida por horas: '.$hPend.': horas y '.$horasPendientes.': minutos';

        $horasExtra = $minExtra-($horExt*60);
        
        $horasExtra = ' Horas extra: '.$horExt.': horas y '.$horasExtra.': minutos';

        $horario = mdlHorarios::where('id_tblPersonal', '=', $id)->get(); 

        return view('checadas/checadas',compact('horario','personal','checada','extras','horasPendientes','horasExtra'));
    }

    
    public function faltas(Request $request)
    {

        $personales = mdlPersonal::all(); 
        

        $dia=date("N");
        $hoy = $request['fecha'];
        
        foreach($personales as $personal){
            $horarios = mdlHorarios::where([
                ['id_tblPersonal', '=', $personal->id],
                ['dia', '=', $dia],
            ])->get();
    
            $horarios_count = count($horarios);
            echo "<div class='border-style: solid;'>";
            echo "<h3> Horarios: ".$horarios_count."</h3>";

            if($horarios_count>0){

                $inasistencias_omisiones = mdlChecadas::where([
                    ['id_tblPersonal', '=', $personal->id],
                    ['checada', '=', 3],
                    ['fecha', '=', $hoy],
                ])->orWhere([
                    ['id_tblPersonal', '=', $personal->id],
                    ['checada', '=', 5],
                    ['fecha', '=', $hoy],
                ])->count();
                echo $inasistencias_omisiones."-".$personal->name."<br>";
                if($inasistencias_omisiones==0){
                    $entradas = mdlChecadas::where([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 0],
                        ['fecha', '=', $hoy],
                    ])->orWhere([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 1],
                        ['fecha', '=', $hoy],
                    ])->count();
                    $salidas = mdlChecadas::where([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 9],
                        ['fecha', '=', $hoy],
                    ])->count();
                    echo "<br>".$personal->id." ";
    
                    $faltas_yaregistradas = mdlChecadas::where([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 8],
                        ['fecha', '=', $hoy],
                    ])->orWhere([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 7],
                        ['fecha', '=', $hoy],
                    ])->orWhere([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 3],
                        ['fecha', '=', $hoy],
                    ])->orWhere([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 4],
                        ['fecha', '=', $hoy],
                    ])->orWhere([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 5],
                        ['fecha', '=', $hoy],
                    ])->orWhere([
                        ['id_tblPersonal', '=', $personal->id],
                        ['checada', '=', 6],
                        ['fecha', '=', $hoy],
                    ])->count();
                    //8,7,3,4,5,6
                    echo $faltas_yaregistradas."-";
                    if($faltas_yaregistradas==0){
                      //  echo "kale"; 
                        if($horarios_count==$entradas && $salidas>=$horarios_count){
                            echo "Horario completo";
                           
                        } else if($horarios_count==$entradas && $salidas<$horarios_count){
                            echo "Omisión de checada";
                            $mdlChecadas = new mdlChecadas();
                            $mdlChecadas->id_tblPersonal = $personal->id;
                            $mdlChecadas->checada = 5;
                            $mdlChecadas->comentario = 'Registro automatico';
                            $mdlChecadas->fecha = $hoy; 
                            $mdlChecadas->save();
                            echo $mdlChecadas;
                            
        
                        } else {
                            $mdlChecadas = new mdlChecadas();
                            $mdlChecadas->id_tblPersonal = $personal->id;
                            $mdlChecadas->checada = 3;
                            $mdlChecadas->comentario = 'Registro automatico';
                            $mdlChecadas->fecha = $hoy; 
                            $mdlChecadas->save();
                            echo $mdlChecadas;
                            echo "Inasistencia";
                        }
                    }
                    
    
                    
                    
                }
                echo "</div><hr width='100%'/>";
            }
            
        }
        
        return 0;
        
        
    }

    
}

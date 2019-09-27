<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\mdlChecadas;
use App\User;
use Carbon\Carbon;
use Redirect;
//use Excel;

class ExcelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {         
       \Excel::create('LaravelExcel', function($excel){
           $excel->sheet('Checadas', function($sheet){
               $checadas = mdlChecadas::all();
               $sheet->fromArray($checadas);
           });
       })->download('xlsx');
    }

    public function getReporteMaestro($idMaestro)
    {
        if($idMaestro != null && User::where('id', '=', $idMaestro)->exists() &&  mdlChecadas::where('id_tblPersonal', '=', $idMaestro)->exists()){
           //Get nombre de empleado y fecha actual
           $nombreMaestro = (string)User::select('name')->where('id', '=', $idMaestro)->take(1)->get();
           $fechaActual = Carbon::now()->format('d-m-y');
           \Excel::create('Reporte_De_Asistencia_' . str_replace(' ','',$nombreMaestro) . '_' . $fechaActual, function($excel) use($idMaestro, $nombreMaestro, $fechaActual){
               $excel->sheet('Checadas', function($sheet) use($idMaestro){
                   $checadas = mdlChecadas::select('id_tblPersonal', 'hora', 'hora_salida', 'checada', 'comentario', 'fecha')->where('id_tblPersonal', '=', $idMaestro)->get();                
                   $sheet->fromArray($checadas);
               });
           })->download('xlsx');
        }
        else {
            //redirect
        }
    }

    public function getReporteMaestroFechas($idMaestro, $fechaInicial, $fechaFinal)
    {
        if($idMaestro != null && User::where('id', '=', $idMaestro)->exists() &&  mdlChecadas::where('id_tblPersonal', '=', $idMaestro)->exists()){
           //Get nombre de empleado y fecha actual
           $nombreMaestro = (string)User::select('name')->where('id', '=', $idMaestro)->take(1)->get();
           $fechaActual = Carbon::now()->format('d-m-y');

           \Excel::create('Reporte_De_Asistencia_' . str_replace(' ','', $nombreMaestro) . '_' . $fechaActual, function($excel) use($idMaestro, $nombreMaestro, $fechaActual, $fechaInicial, $fechaFinal){
               $excel->sheet('Checadas', function($sheet) use($idMaestro, $fechaInicial, $fechaFinal){
                   $between = [$fechaInicial, $fechaFinal];
                   $checadas = mdlChecadas::where('id_tblPersonal', '=', $idMaestro)->whereBetween('fecha', array($fechaInicial, $fechaFinal))->get();                
                   $sheet->fromArray($checadas);
               });
           })->download('xlsx');
        }
        else {
            //redirect
        }
    }

   public function getReporteQuincenal($idMaestro)
   {
       if($idMaestro != null && User::where('id', '=', $idMaestro)->exists() &&  mdlChecadas::where('id_tblPersonal', '=', $idMaestro)->exists()){
           //Get nombre de empleado y fecha actual
           $nombreMaestro = (string)User::select('name')->where('id', '=', $idMaestro)->take(1)->get();
           $fechaActual = Carbon::now()->format('d-m-y');
           $fechaQuincenal = Carbon::now()->subDays(16); //fecha 16 dias antes de la fecha actual.
           \Excel::create('Reporte_De_Asistencia_' . str_replace(' ','',$nombreMaestro) . '_' . $fechaActual, function($excel) use($idMaestro, $nombreMaestro, $fechaActual, $fechaQuincenal){
               $excel->sheet('Checadas', function($sheet) use($idMaestro, $fechaActual, $fechaQuincenal){
                   $checadas = mdlChecadas::where('id_tblPersonal', '=', $idMaestro)->whereBetween('fecha', array($fechaQuincenal, $fechaActual))->get();                
                   $sheet->fromArray($checadas);
               });
           })->download('xlsx');
       }
       else {
           //redirect
       }
   }
}

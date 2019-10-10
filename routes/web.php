<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Inicio/inicioChecada');
});
Route::get('/permiso', function () {
    return view('Inicio/permisoChecada');
});

/*Route::get('/login', function () {
    return view('Inicio/login');
})->name('login');

/**
 * Excel routes
 * Generan reportes de excel con las checadas de cada maestro
 */
//Route::get('excel', 'ExcelController@index');
Route::get('reportes/{id}', 'ExcelController@getReporteMaestro');
Route::get('reportes/{id}/{fechaInicial}/{fechaFinal}/', 'ExcelController@getReporteMaestroFechas');
Route::get('reportes/reporteQuincenal/{id}/', 'ExcelController@getReporteQuincenal');
Route::get('permiso/id/{id}/', 'checadasController@permiso');
Route::get('checar/id/{id}/', 'checadasController@checar');
Route::get('extras/id/{id}/', 'checadasController@horasExtras');
//Route::resource('reportes','reportesController');
Route::resource('personal','personalController');
Route::resource('permiso','permisoController');
Route::resource('checadas','checadasController');
Route::resource('horarios','horariosController');
Route::resource('checkin','checkinController');
//Route::resource('reportesBono','reportesBono');

//Route::post('auth','Auth\LoginController@login')->name('auth');
Route::get('/reportesBono/','reportesBono@index')->name('reportesBono');
Route::get('/reportes/','reportesController@index')->name('reportes');

Route::get('/personal/','personalController@index')->name('personal');
Route::get('/checadas/','checadasController@index')->name('checadas');
Route::get('/horarios/','horariosController@index')->name('horarios');
Route::get('/checkin/','checkinController@store')->name('checkin');
//Route::get('/checadas/f1/{fechaInicio}/f2/{fechaFinal}','checadasController@index')->name('checadas');
Route::get('/horario/{id}','horariosController@crear')->name('horarios.crear');
Route::get('/checadas/crear/{id}','checadasController@crear')->name('checadas.crear');
Route::get('/crearchecada/{id_tblPersonal}/hora/{hora}','checadasController@crearchecada');
Route::get('/crearchecada2/{id_tblPersonal}/hora/{hora}','checadasController2@crearchecada');
Route::get('/horatest/','checadasController@index')->name('horatest');
Route::get('/faltas/{id_tblPersonal}/fecha/{fecha}','checadasController@faltas');
//Route::match(['get', 'post'], 'horarios', 'horariosController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
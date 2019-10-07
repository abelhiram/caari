<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mdlHoras extends Model
{
    protected $table = 'tblHoras'; 
    protected $fillable = ['id_tblPersonal','hora_entrada','hora_salida','fecha'];  

}

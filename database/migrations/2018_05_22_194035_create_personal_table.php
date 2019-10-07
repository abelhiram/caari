<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblPersonal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('expediente');
            $table->string('nombre',120);
            $table->string('email')->nullable();
            $table->enum('nombramiento',['determinado','indeterminado'])->nullable();
            $table->enum('jornada',['Matutino','Vespertino','Nocturno','Administrativo','Indefinido'])->nullable();
            $table->binary('huella')->nullable();
            $table->string('foto')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblPersonal');
    }
}

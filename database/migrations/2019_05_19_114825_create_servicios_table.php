<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion')->default(NULL);
            $table->double('precio', 8, 2);
            $table->double('descuento', 8, 2)->default(0)->comment('Descuento por producto');
            $table->double('precio-oferta', 8, 2)->default(NULL);
            $table->integer('estado')->default(1)->comment('activo 1 - activo 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}

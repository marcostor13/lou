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
            $table->string('precio');
            $table->string('descuento')->default(0)->comment('Descuento por producto');
            $table->string('precio-oferta')->default(NULL);
            $table->integer('estado')->default(1)->comment('activo 1 - activo 0');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(NULL);
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

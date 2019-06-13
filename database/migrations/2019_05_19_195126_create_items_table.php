<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('servicio_id')->unsigned()->default(NULL);
            $table->float('precio');
            $table->integer('cantidad')->default(1); 
            $table->integer('descuento')->default(0); 
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
        Schema::dropIfExists('items');
    }
}

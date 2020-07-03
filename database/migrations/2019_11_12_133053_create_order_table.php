<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full'); 
            $table->string('address')->nullable(); 
            $table->string('email'); 
            $table->string('phone'); 
            $table->decimal('total',18);
            $table->tinyInteger('state')->unsigned(); // state tinyInt,  no sign
            $table->timestamps(); // create 2 columns: created_at, update_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('max_people');
            $table->string('shape');
            $table->string('floor');
            $table->double('price');
            $table->double('special_price');
            $table->unsignedBigInteger('shop_id');
            $table->double('deposit')->nullable();
            $table->string('description')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('tables');
    }
}

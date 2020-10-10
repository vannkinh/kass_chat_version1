<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('discount')->nullable();
            $table->double('subtotal');
            $table->double('total');
            $table->string('paymentMethod');
            $table->string('status');
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}

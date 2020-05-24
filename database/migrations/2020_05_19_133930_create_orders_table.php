<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->bigInteger('transaction_id');
            $table->string('via',16);
            $table->string('channel',16);
            $table->string('total');
            $table->text('paymentNo');
            $table->timestamp('expired');
            $table->string('status');
            $table->string('asal');
            $table->tinyInteger('qty');
            $table->timestamp('tanggal_berangkat')->nullable();
            $table->timestamp('tanggal_pulang')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->text('testimoni')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

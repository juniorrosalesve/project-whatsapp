<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticketId');
            $table->foreign('ticketId')->references('id')->on('tickets');
            $table->string('customer')->nullable();
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('time')->nullable();
            $table->double('price_delivery')->nullable();
            $table->double('price_order')->nullable();
            $table->longText('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

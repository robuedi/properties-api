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
        Schema::create('property_address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('property_id')->unsigned()->unique();
            $table->bigInteger('city_id')->unsigned();
            $table->string('address_line');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_address');
    }
};

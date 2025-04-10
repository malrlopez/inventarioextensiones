<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('switches')) {
            Schema::create('switches', function (Blueprint $table) {
                $table->id();
                $table->string('marca');
                $table->string('modelo')->nullable();
                $table->string('referencia')->nullable();
                $table->integer('total_puertos')->default(0);
                $table->integer('puertos_disponibles')->default(0);
                $table->string('ubicacion')->nullable();
                $table->text('observaciones')->nullable();
                $table->unsignedBigInteger('rack_id')->nullable();
                $table->foreign('rack_id')->references('id')->on('racks')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('switches');
    }
};
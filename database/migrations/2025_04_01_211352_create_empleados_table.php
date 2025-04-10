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
        if (!Schema::hasTable('empleados')) {
            Schema::create('empleados', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('apellido');
                $table->string('email')->nullable()->unique();
                $table->string('telefono')->nullable();
                $table->unsignedBigInteger('cargo_id')->nullable();
                $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('set null');
                $table->unsignedBigInteger('sede_id')->nullable();
                $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('set null');
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
        Schema::dropIfExists('empleados');
    }
};
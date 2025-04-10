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
        if (!Schema::hasTable('racks')) {
            Schema::create('racks', function (Blueprint $table) {
                $table->id();
                $table->string('marca')->nullable();
                $table->string('modelo')->nullable();
                $table->string('ubicacion');
                $table->string('estado')->default('Activo');
                $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('racks');
    }
};
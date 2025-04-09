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
        if (!Schema::hasTable('softphones')) {
            Schema::create('softphones', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('version')->nullable();
                $table->string('fabricante')->nullable();
                $table->string('licencia')->nullable();
                $table->text('configuracion')->nullable();
                $table->string('estado')->default('Activo');
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
        Schema::dropIfExists('softphones');
    }
};
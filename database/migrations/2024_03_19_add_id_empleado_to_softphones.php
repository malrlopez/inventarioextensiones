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
        Schema::table('softphones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->foreign('id_empleado')->references('id')->on('empleados')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('softphones', function (Blueprint $table) {
            $table->dropForeign(['id_empleado']);
            $table->dropColumn('id_empleado');
        });
    }
};

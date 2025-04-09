<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToHistorialTable extends Migration
{
    public function up()
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
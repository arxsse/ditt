<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipocalleToPersonaTable extends Migration
{
    public function up()
    {
        Schema::table('persona', function (Blueprint $table) {
            $table->string('tipocalle', 120)->nullable();
        });
    }

    public function down()
    {
        Schema::table('persona', function (Blueprint $table) {
            $table->dropColumn('tipocalle');
        });
    }
}
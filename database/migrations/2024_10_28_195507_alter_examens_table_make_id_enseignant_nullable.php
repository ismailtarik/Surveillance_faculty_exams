<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_enseignant')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_enseignant')->nullable(false)->change(); // Make it not nullable again
        });
    }
    
};

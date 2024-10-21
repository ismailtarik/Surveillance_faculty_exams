<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->index('cin'); // Add an index to 'cin'
            $table->index('code_etudiant'); // Add an index to 'code_etudiant'
            $table->index('id_session'); // Add an index to 'id_session'
        });

        Schema::table('filieres', function (Blueprint $table) {
            $table->index('code_etape'); // Add an index to 'code_etape'
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->index('code_elp'); // Add an index to 'code_elp'
            $table->index(['code_etape', 'id_session']); // Composite index on code_etape and id_session
        });

        Schema::table('inscriptions', function (Blueprint $table) {
            $table->index('id_etudiant'); // Add an index to 'id_etudiant'
            $table->index('id_module'); // Add an index to 'id_module'
            $table->index('id_session'); // Add an index to 'id_session'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropIndex(['cin']);
            $table->dropIndex(['code_etudiant']);
            $table->dropIndex(['id_session']);
        });

        Schema::table('filieres', function (Blueprint $table) {
            $table->dropIndex(['code_etape']);
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->dropIndex(['code_elp']);
            $table->dropIndex(['code_etape', 'id_session']); // Drop the composite index
        });

        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropIndex(['id_etudiant']);
            $table->dropIndex(['id_module']);
            $table->dropIndex(['id_session']);
        });
    }
};

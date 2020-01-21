<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTouristExperiencesTableAddLiaisons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tourist_experiences', function (Blueprint $table) {
            $table->unsignedBigInteger('liaison_id')->index('liaison_id_index')->nullable();
            $table->foreign('liaison_id')
                ->references('id')
                ->on('liaisons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tourist_experiences', function (Blueprint $table) {
            $table->dropColumn('liaison_id');
        });
    }
}

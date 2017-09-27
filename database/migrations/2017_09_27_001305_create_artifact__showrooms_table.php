<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtifactShowroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifact__showrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artifact_id')->unsigned();
            $table->integer('showroom_id')->unsigned();
            $table->timestamps();

            $table->string('createdBy');
            $table->string('updatedBy');
            $table->softDeletes();
            $table->string('deletedBy');

            $table->foreign('artifact_id')->references('id')->on('artifacts');
            $table->foreign('showroom_id')->references('id')->on('showrooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artifact__showrooms');
    }
}

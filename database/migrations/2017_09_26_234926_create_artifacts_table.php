<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtifactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('marker_path');
            $table->integer('type_id')->unsigned();
            $table->integer('showroom_id')->unsigned()->nullable();
            $table->longText('description');
            $table->string('video_url');
            $table->string('image_path');
            $table->string('target_id');
            $table->timestamps();
            $table->string('createdBy');
            $table->string('updatedBy');
            $table->softDeletes();
            $table->string('deletedBy');
            $table->foreign('type_id')->references('id')->on('types');
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
        Schema::dropIfExists('artifacts');
    }
}

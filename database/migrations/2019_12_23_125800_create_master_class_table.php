<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_class', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo_master');
            $table->string('title_master');
            $table->string('title_gallery_master');
            $table->string('title_req_master');
            $table->text('description_master');
            $table->text('info_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_class');
    }
}

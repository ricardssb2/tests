<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRootCausesTable extends Migration
{
    public function up()
    {
        Schema::create('root_causes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('author_name')->nullable();

            $table->string('author_email')->nullable();

            $table->longText('root_cause_text');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('root_causes');
    }
}

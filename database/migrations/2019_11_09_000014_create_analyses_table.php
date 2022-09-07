<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysesTable extends Migration
{
    public function up()
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('author_name')->nullable();

            $table->string('author_email')->nullable();

            $table->longText('analyse_text');

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
        Schema::dropIfExists('analyses');
    }
}

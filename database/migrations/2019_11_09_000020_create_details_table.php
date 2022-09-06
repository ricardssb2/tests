<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');

            $table->string('author_name')->nullable();

            $table->string('author_email')->nullable();

            $table->longText('resolution_text');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}

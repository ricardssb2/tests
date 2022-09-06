<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResolutionsTable extends Migration
{
    public function up()
    {
        Schema::create('resolutions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('author_name')->nullable();

            $table->string('author_email')->nullable();

            $table->longText('resolution_text');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}

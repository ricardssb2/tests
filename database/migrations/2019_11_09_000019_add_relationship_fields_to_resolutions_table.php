<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToResolutionsTable extends Migration
{
    public function up()
    {
        Schema::table('resolutions', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id')->nullable();

            $table->foreign('ticket_id', 'ticket_fk_583785')->references('id')->on('tickets');

            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id', 'user_fk_583786')->references('id')->on('users');
        });
    }
}

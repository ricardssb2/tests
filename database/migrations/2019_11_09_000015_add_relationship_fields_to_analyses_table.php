<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAnalysesTable extends Migration
{
    public function up()
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id')->nullable();

            $table->foreign('ticket_id', 'ticket_fk_583778')->references('id')->on('tickets');

            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id', 'user_fk_583782')->references('id')->on('users');
        });
    }
}

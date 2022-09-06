<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id')->nullable();

            $table->foreign('ticket_id', 'ticket_fk_583787')->references('id')->on('tickets');

            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id', 'user_fk_583788')->references('id')->on('users');
        });
    }
}

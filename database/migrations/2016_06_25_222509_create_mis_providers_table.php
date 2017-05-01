<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMisProvidersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('mis_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('template');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('mis_providers');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->uuid('wonde_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug');
            $table->text('description');
            $table->enum('provider', ['yes', 'no']);
            $table->float('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staff');
    }
}

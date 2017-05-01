<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_address', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->enum('address_type',['home','work']);
            $table->integer('house_number')->nullable();
            $table->string('apartment');
            $table->string('street');
            $table->string('district');
            $table->string('town');
            $table->string('county');
            $table->string('country');
            $table->string('postcode');
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
        Schema::drop('students_address');
    }
}

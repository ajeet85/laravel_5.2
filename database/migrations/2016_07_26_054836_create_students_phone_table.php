<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsPhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_phone', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('phone')->unsigned()->nullable();
            $table->integer('primary')->unsigned()->nullable();
            $table->integer('home')->unsigned()->nullable();
            $table->integer('work')->unsigned()->nullable();
            $table->integer('mobile')->unsigned()->nullable();
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
        Schema::drop('students_phone');
    }
}

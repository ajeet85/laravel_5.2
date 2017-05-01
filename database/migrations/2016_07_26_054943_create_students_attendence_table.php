<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsAttendenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_attendence', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('authorised_absences')->unsigned()->nullable();
            $table->integer('unauthorized_absences')->unsigned()->nullable();
            $table->integer('unexplained_absences')->unsigned()->nullable();
            $table->integer('late_before_registration')->unsigned()->nullable();
            $table->integer('late_after_registration')->unsigned()->nullable();
            $table->integer('possible_marks')->unsigned()->nullable();
            $table->integer('attendance_not_required')->unsigned()->nullable();
            $table->integer('present')->unsigned()->nullable();
            $table->integer('approved_education_activity')->unsigned()->nullable();
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
        Schema::drop('students_attendence');
    }
}

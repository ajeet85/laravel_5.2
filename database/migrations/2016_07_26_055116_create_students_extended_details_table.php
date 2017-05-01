<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsExtendedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_extended_details', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('next_of_kin');
            $table->string('religion');
            $table->string('ethnicity');
            $table->string('dietary_needs');
            $table->string('sen_status');
            $table->string('first_language');
            $table->string('in_lea_care');
            $table->string('free_school_meals_6');
            $table->string('english_as_additional_language');
            $table->string('premium_pupil_indicator');
            $table->string('premium_pupil_notes');
            $table->string('service_children_indicator');
            $table->string('enrolment_status');
            $table->string('gifted_and_talented_status');
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
        Schema::drop('students_extended_details');
    }
}

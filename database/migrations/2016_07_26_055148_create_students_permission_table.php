<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->smallInteger('photograph_student')->nullable();
            $table->smallInteger('internet_access')->nullable();
            $table->smallInteger('sex_education')->nullable();
            $table->smallInteger('school_visit')->nullable();
            $table->smallInteger('data_exchange')->nullable();
            $table->smallInteger('copyright_permission')->nullable();
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
        Schema::drop('students_permission');
    }
}

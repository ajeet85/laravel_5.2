<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionsStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_students', function (Blueprint $table) {

            $table->integer('provision_id')->unsigned();
            $table->foreign('provision_id')->references('id')->on('provisions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onUpdate('cascade');
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
        Schema::drop('provision_students');
    }
}

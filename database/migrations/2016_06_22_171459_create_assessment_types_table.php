<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('assessment_type_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('assessment_type')->unsigned();
            $table->foreign('assessment_type')->references('id')->on('assessment_types')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->string('public_grade')->nullable();
            $table->integer('internal_grade')->nullable();
            $table->text('band')->nullable();
            $table->text('kpi')->nullable();
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
        Schema::drop('assessment_type_grades');
        Schema::drop('assessment_types');
    }
}

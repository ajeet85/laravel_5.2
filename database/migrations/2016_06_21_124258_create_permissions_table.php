<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('permissable_actions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('actionable_element')->unsigned();
            $table->foreign('actionable_element')->references('id')->on('permissable_elements')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('actionable_context')->unsigned();
            $table->foreign('actionable_context')->references('id')->on('permissable_context')
                    ->onDelete('cascade')
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
        Schema::drop('permissions');
    }
}

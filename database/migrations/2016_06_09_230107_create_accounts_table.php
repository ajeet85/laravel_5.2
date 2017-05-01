<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->text('status');
            $table->text('name');
            $table->text('slug');
            $table->date('trial_start_date');
            $table->date('trial_end_date');
            $table->integer('days_left')->default(30);
            $table->integer('renewed')->default(0);
            $table->date('renewal_date')->nullable();

            $table->integer('package_id')->unsigned()->nullable();
            $table->foreign('package_id')->references('id')->on('packages')
                    ->onUpdate('cascade');

            $table->integer('manager_id')->unsigned()->nullable();
            $table->foreign('manager_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });

        Schema::create('users_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('user_types')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });

        Schema::create('account_actions', function (Blueprint $table) {
            $table->increments('id');
            // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('account_id');
            $table->text('action');
            $table->text('status');
            $table->uuid('code');
            $table->string('event', 100)->nullable();
            $table->date('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_accounts');
        Schema::drop('account_actions');
        Schema::drop('accounts');
    }
}

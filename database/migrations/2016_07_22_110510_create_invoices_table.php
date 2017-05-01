<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('purchase_order');
            $table->uuid('invoice_number');
            $table->float('net_total');
            $table->float('vat');
            $table->float('gross_total');
            $table->date('due_date');
            $table->integer('paid');
            $table->text('file_location');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->default(1);
            $table->text('description');
            $table->string('discount_code')->nullable();
            $table->float('unit_price');
            $table->float('vat')->default(20);
            $table->float('net_total');
            $table->float('gross_total');
            $table->integer('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices')
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
        Schema::drop('invoice_items');
        Schema::drop('invoices');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('landlord_id')->comment('user_id');
            $table->unsignedBigInteger('tenant_id')->comment('user_id');
            $table->string('invoice_no');
            $table->string('title');
            $table->text('description');
            $table->double('price','8','2');
            $table->string('type','1');
            $table->string('email_address');
            $table->string('status');
            $table->boolean('paid');
            $table->timestamp('due_date');
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
        Schema::dropIfExists('invoices');
    }
}

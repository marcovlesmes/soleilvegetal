<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedInteger('additional_value');
            $table->unsignedInteger('attempts');
            $table->string('authorization_code', 12);
            $table->string('bank_id');
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_country', 2);
            $table->float('commision_pol');
            $table->string('commision_pol_currency', 3);
            $table->string('currency', 3);
            $table->string('cus', 64);
            $table->unsignedBigInteger('customer_number');
            $table->timestamp('date');
            $table->string('description');
            $table->string('email_buyer');
            $table->string('error_code_bank');
            $table->string('error_message_bank');
            $table->float('exchange_rate');
            $table->unsignedSmallInteger('installments_number');
            $table->string('ip', 39);
            $table->string('nickname_buyer', 150);
            $table->string('nickname_seller', 150);
            $table->string('merchant_id', 12);
            $table->string('office_phone', 20);
            $table->string('payment_method', 50);
            $table->string('payment_method_id', 2);
            $table->string('payment_method_name', 50);
            $table->string('payment_method_type', 2);
            $table->string('payment_request_state', 32);
            $table->string('pse_bank');
            $table->string('pseReference1');
            $table->string('pseReference2');
            $table->string('pseReference3');
            $table->string('phone', 20);
            $table->float('risk');
            $table->string('response_code_pol');
            $table->string('response_message_pol');
            $table->string('reference_sale');
            $table->string('reference_pol');
            $table->string('shipping_address', 50);
            $table->string('shipping_city', 50);
            $table->string('shipping_country', 2);
            $table->string('sign');
            $table->string('state_pol', 32);
            $table->float('tax');
            $table->boolean('test');
            $table->string('transaction_bank_id');
            $table->dateTime('transaction_date');
            $table->string('transaction_id', 36);
            $table->unsignedBigInteger('value');
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
        Schema::dropIfExists('transactions');
    }
}

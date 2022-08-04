<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique();
            $table->json('products');
            $table->json('address');
            $table->double('delivery_fee', 8, 2)->nullable();
            $table->double('amount', 12, 2);
            $table->char('user_uuid', 36);
            $table->char('order_status_uuid', 36);
            $table->char('payment_uuid', 36);

            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreign('order_status_uuid')->references('uuid')->on('order_statuses');
            $table->foreign('payment_uuid')->references('uuid')->on('payments');

//            $table->foreignId('user_id')->constrained();
//            $table->foreignId('order_status_id')->nullable()->constrained();
//            $table->foreignId('payment_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};

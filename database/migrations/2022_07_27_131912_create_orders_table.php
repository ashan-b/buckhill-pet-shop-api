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
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('order_status_id')->nullable()->constrained();
            $table->foreignId('payment_id')->nullable()->constrained();
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

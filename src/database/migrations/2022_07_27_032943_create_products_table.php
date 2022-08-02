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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->char('uuid', 36)->unique();
            $table->char('category_uuid', 36);
            $table->double('price', 12, 2);
            $table->text('description');
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_uuid')->references('uuid')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

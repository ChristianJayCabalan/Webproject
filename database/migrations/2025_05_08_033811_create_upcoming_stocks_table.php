<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpcomingStocksTable extends Migration
{
    public function up()
    {
        Schema::create('upcoming_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); // foreign key to categories
            $table->string('product_name');            // product name, required
            $table->integer('incoming_quantity');      // incoming quantity
            $table->dateTime('expected_arrival');      // expected arrival datetime
            $table->string('image')->nullable();        // nullable image path
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('upcoming_stocks');
    }
}




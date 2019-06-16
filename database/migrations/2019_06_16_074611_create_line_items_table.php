<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity')
                ->comment('How many products were ordered');
            $table->float('price')
                ->comment('The price the product had when ordered');
            $table->float('total')
                ->comment('The total for this line item');
            $table->bigInteger('order_id')
                ->unsigned()
                ->nullable()
                ->comment('ID referencing the order the line item is related to');
            $table->bigInteger('product_id')
                ->unsigned()
                ->nullable()
                ->comment('ID referencing the product that was ordered');
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_items');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')
                ->comment('Universal Unique Identifier');
            $table->enum('status', [
                'PENDING',
                'RECEIVED',
                'DISPATCHED',
                'DELIVERED',
            ])
                ->comment('The order\'s current status');
            $table->float('total_products')
                ->comment('The amount of products that were ordered');
            $table->float('total')
                ->comment('The order\'s total amount');
            $table->bigInteger('user_id')
                ->unsigned()
                ->comment('ID referencing the user who placed the order');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('orders');
    }
}

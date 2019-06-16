<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')
                ->comment('The product\'s name');
            $table->string('slug')
                ->unique()
                ->comment('URL friendly product name');
            $table->string('uuid')
                ->unique()
                ->comment('Universal Unique Identifier');
            $table->string('sku')
                ->comment('Product\'s SKU');
            $table->text('description')
                ->comment('Product\'s description');
            $table->float('price')
                ->comment('Product\'s current price');
            $table->boolean('is_available')
                ->default(0)
                ->comment('Determine wheter product is available on the store');
            $table->integer('stock')
                ->default(0)
                ->comment('Current product\'s stock');
            $table->bigInteger('user_id')
                ->unsigned()
                ->nullable()
                ->comment('ID referencing the user that created the product');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('products');
    }
}

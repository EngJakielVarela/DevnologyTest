<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create a table products
        Schema::create('tbl_products', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_ext')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('category')->nullable();
            $table->integer('price');
            $table->string('image');
            $table->integer('status')->default(1); // 0: pending, 1: active, 2: canceled
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
        //eliminar a tabela products
        Schema::drop('tbl_products');
    }
}

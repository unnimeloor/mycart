<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('brand')) {
            Schema::create('brand', function (Blueprint $table) {
                $table->id('id_brand');
                $table->string('brand_name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('processor_type')) {
            Schema::create('processor_type', function (Blueprint $table) {
                $table->id('id_processor_type');
                $table->string('processor_type');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product')) {
            Schema::create('product', function (Blueprint $table) {
                $table->id('id_product');
                $table->string('name');
                $table->string('image')->nullable();
                $table->float('price', 8, 2);
                $table->integer('id_brand');
                $table->integer('id_processor_type');
                $table->float('screen_size', 4, 2);
                $table->boolean('is_touch_screen')->default(0);
                $table->boolean('out_of_stock')->default(0);
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brand');
        Schema::drop('processor_type');
        Schema::drop('product');
    }
}

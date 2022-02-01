<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('contact_id')->unsigned()->nullable(false);
            $table->bigInteger('product_type_offered_id')->unsigned()->nullable(false);
            $table->string('product_type_offered')->nullable(false);
            $table->decimal('sale_net_amount', 15, 2)->nullable(false);
            $table->decimal('sale_gross_amount', 15, 2)->nullable(false);
            $table->decimal('sale_tax_rate', 15, 2)->nullable(false);
            $table->decimal('sale_product_total_cost', 15, 2)->nullable(false);

            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade');

            $table->index('product_type_offered_id');
            $table->index('product_type_offered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}

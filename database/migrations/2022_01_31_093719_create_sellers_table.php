<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('uuid', 50)->unique()->nullable(false);
            $table->string('firstname')->nullable(false);
            $table->string('lastname')->nullable(false);
            $table->date('date_joined')->nullable(false);
            $table->string('country', 50)->nullable(false);

            $table->index('country');
            $table->index(['lastname', 'firstname']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}

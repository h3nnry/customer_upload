<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('seller_id')->unsigned()->nullable(false);
            $table->string('fullname')->nullable(false);
            $table->string('region')->nullable(false);
            $table->string('contact_type', 50)->nullable(false);
            $table->date('date')->nullable(false);

            $table->foreign('seller_id')
                ->references('id')->on('sellers')
                ->onDelete('cascade');

            $table->index('region');
            $table->index('contact_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}

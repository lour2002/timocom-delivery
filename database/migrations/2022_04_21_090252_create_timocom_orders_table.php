<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimocomOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained();
            $table->string('offer_id')->nullable();
            $table->date('date_collection')->nullable();
            $table->string('name', 150)->nullable();
            $table->string('company', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 150)->nullable();
            $table->integer('company_id')->nullable();
            $table->double('freight_length')->nullable();
            $table->double('freight_weight')->nullable();
            $table->text('freight_description')->nullable();
            $table->string('payment_due', 150)->nullable();
            $table->double('price')->nullable();
            $table->tinyInteger('equipment_exchange')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->text('vehicle_description')->nullable();
            $table->text('remarks')->nullable();
            $table->tinyInteger('loading_places')->nullable();
            $table->tinyInteger('unloading_places')->nullable();
            $table->smallInteger('distance')->nullable();
            $table->text('from')->nullable();
            $table->text('to')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

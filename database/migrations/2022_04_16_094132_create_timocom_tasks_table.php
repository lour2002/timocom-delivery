<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimocomTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('user_key');
            $table->string('name')->default('Task');
            $table->char('status_job', 1)->default('1');
            $table->tinyInteger('num');
            $table->tinyInteger('version_task')->default(0);
            $table->string('fromSelectOpt',100)->default('app:cnt:searchForm:fromSelectOpt3')->nullable();
            $table->string('as_country',100)->nullable();
            $table->string('as_zip', 10)->nullable();
            $table->char('as_radius',5)->nullable();
            $table->char('car_city',50)->nullable();
            $table->string('car_position_coordinates',50)->nullable();
            $table->string('toSelectOpt',100)->default('app:cnt:searchForm:toSelectOpt2')->nullable();
            $table->text('toSelectOptArray')->nullable();
            $table->string('freightSelectOpt',100)->default('app:cnt:searchForm:freightSelectOpt2')->nullable();
            $table->string('length_min',50)->nullable();
            $table->string('length_max',50)->nullable();
            $table->string('weight_min',50)->nullable();
            $table->string('weight_max',50)->nullable();
            $table->string('dateSelectOpt',100)->default('app:cnt:searchForm:dateSelectOpt2')->nullable();
            $table->string('individual_days',50)->nullable();
            $table->double('car_price_empty', 8, 2)->default(0)->nullable();
            $table->double('car_price', 8, 2)->nullable();
            $table->double('car_price_extra_points', 8, 2)->nullable();
            $table->text('car_price_special_price')->nullable();
            $table->tinyInteger('exchange_equipment')->default(0)->nullable();
            $table->double('minimal_price_order',8,2)->nullable();
            $table->integer('percent_stop_value')->nullable();
            $table->text('cross_border')->nullable();
            $table->text('tags')->nullable();
            $table->text('email_template')->nullable();

            $table->index(['user_id','user_key','status_job','num']);

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
        Schema::dropIfExists('tasks');
    }
}

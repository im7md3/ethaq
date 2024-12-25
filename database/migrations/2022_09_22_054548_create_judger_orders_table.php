<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judger_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders','id')->cascadeOnDelete();
            $table->foreignId('judger_id')->constrained('users','id')->cascadeOnDelete();
            $table->string('type')->nullable();
            $table->integer('period')->nullable();
            $table->string('client_decision')->nullable()->default('pending');
            $table->text('client_refused_msg')->nullable();
            $table->string('judger_decision')->nullable()->default('pending');
            $table->text('judger_refused_msg')->nullable();
            $table->text('rejected')->nullable();
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
        Schema::dropIfExists('jugder_orders');
    }
};

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
        Schema::create('suspended_balances', function (Blueprint $table) {
            $table->id();
            $table->morphs('order');
            $table->foreignId('invoice_id')->constrained('invoices','id')->cascadeOnDelete();
            $table->foreignId('from')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('to')->constrained('users','id')->cascadeOnDelete();
            $table->double('amount')->nullable()->default(0);
            $table->string('status')->nullable()->default('no');
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
        Schema::dropIfExists('suspended_balances');
    }
};

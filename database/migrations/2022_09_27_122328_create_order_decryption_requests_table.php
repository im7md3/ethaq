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
        Schema::create('order_decryption_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('vendor_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders','id')->cascadeOnDelete();
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
        Schema::dropIfExists('order_decryption_requests');
    }
};

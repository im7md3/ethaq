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
        Schema::create('consulting_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('consulting_id')->constrained('consultings','id')->cascadeOnDelete();
            $table->double('amount');
            $table->string('status')->nullable()->default('pending');
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
        Schema::dropIfExists('consulting_offers');
    }
};

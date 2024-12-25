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
        Schema::create('consulting_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulting_id')->constrained('consultings','id')->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('users','id')->cascadeOnDelete();
            $table->integer('value');
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
        Schema::dropIfExists('counseling_evaluations');
    }
};

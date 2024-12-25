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
        Schema::create('consulting_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulting_id')->constrained('consultings','id')->cascadeOnDelete();
            $table->foreignId('from')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('to')->constrained('users','id')->cascadeOnDelete();
            $table->text('msg')->nullable();
            $table->timestamp('seen_at')->nullable();
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
        Schema::dropIfExists('consulting_messages');
    }
};

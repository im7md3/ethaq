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
        Schema::create('special_service_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('special_services','id')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->text('content')->nullable();
            $table->timestamp('seen')->nullable();
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
        Schema::dropIfExists('special_service_messages');
    }
};

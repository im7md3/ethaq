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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->morphs('order');
            $table->foreignId('from_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('to_id')->constrained('users','id')->cascadeOnDelete();
            $table->string('for_type')->nullable();
            $table->double('amount')->nullable()->default(0);
            $table->double('tax')->nullable()->default(0);
            $table->double('admin_ratio')->nullable()->default(0);
            $table->double('total')->nullable()->default(0);
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
        Schema::dropIfExists('invoices');
    }
};

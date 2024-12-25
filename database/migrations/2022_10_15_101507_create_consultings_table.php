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
        Schema::create('consultings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->cascadeOnDelete();
            $table->string('other_department')->nullable();
            $table->integer('offer_id')->nullable();
            $table->text('details')->nullable();
            $table->string('status')->nullable();
            $table->double('amount')->nullable();
            $table->integer('min')->nullable();
            $table->integer('sec')->nullable();
            $table->boolean('private')->nullable()->default(0);
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
        Schema::dropIfExists('consultings');
    }
};

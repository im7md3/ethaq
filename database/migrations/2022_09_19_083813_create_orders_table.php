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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->foreignId('first_judger_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->foreignId('second_judger_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->nullOnDelete();
            $table->foreignId('main_department_id')->nullable()->constrained('departments','id')->nullOnDelete();
            $table->string('other_department')->nullable();
            $table->foreignId('offer_id')->nullable();
            $table->foreignId('negotiation_id')->nullable();
            $table->boolean('vendor_contract')->nullable();
            $table->text('contract')->nullable();
            $table->foreignId('objection_id')->nullable();
            $table->string('title')->nullable();
            $table->text('details');
            $table->string('status')->nullable()->default('pending');
            $table->text('refused_delivery_msg')->nullable();
            $table->text('refused_msg')->nullable();
            $table->boolean('encrypted')->nullable();
            $table->string('hash_code')->nullable();
            $table->boolean('money_back')->nullable()->default(false);
            $table->boolean('without_judgers')->nullable()->default(false);
            $table->integer('judger_period')->nullable();
            $table->timestamp('delivery_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
};

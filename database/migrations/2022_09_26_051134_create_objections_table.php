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
        Schema::create('objections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders','id')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users','id')->cascadeOnDelete();
            $table->text('content');
            $table->integer('time')->nullable();
            $table->text('note_time')->nullable();
            $table->text('client_decision')->nullable();
            $table->text('client_refused_msg')->nullable();
            $table->text('vendor_decision')->nullable();
            $table->text('vendor_refused_msg')->nullable();
            $table->foreignId('judger_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->text('judger_judgment')->nullable();
            $table->timestamp('judger_judgment_time')->nullable();
            $table->boolean('client_objection')->nullable()->default(false);
            $table->text('client_objection_reason')->nullable();
            $table->boolean('vendor_objection')->nullable()->default(false);
            $table->text('vendor_objection_reason')->nullable();
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
        Schema::dropIfExists('objections');
    }
};

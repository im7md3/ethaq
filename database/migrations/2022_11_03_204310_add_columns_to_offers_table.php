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
        Schema::table('offers', function (Blueprint $table) {
            $table->text('works')->nullable();
            $table->text('documents')->nullable();
            $table->json('execution_method')->nullable();
            $table->string('other_execution_method')->nullable();
            $table->string('duration')->nullable();
            $table->string('decision_place')->nullable();
            $table->string('committee')->nullable();
            $table->string('management')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('works');
            $table->dropColumn('documents');
            $table->dropColumn('execution_method');
            $table->dropColumn('other_execution_method');
            $table->dropColumn('duration');
            $table->dropColumn('decision_place');
            $table->dropColumn('committee');
            $table->dropColumn('management');
        });
    }
};

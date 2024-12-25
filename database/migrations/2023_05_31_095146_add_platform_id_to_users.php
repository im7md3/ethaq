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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('platform_id')->nullable()->constrained('platforms','id')->nullOnDelete();
            $table->string('another_platform')->nullable();
            $table->foreignId('affiliated_id')->nullable()->constrained('users','id')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('another_platform');
            $table->dropConstrainedForeignId('platform_id');
            $table->dropConstrainedForeignId('affiliated_id');
        });
    }
};

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['admin','client','vendor','judger','advisor'])->nullable();
            $table->enum('membership',['individual','company'])->default('individual')->nullable();
            $table->string('name')->nullable();
            $table->enum('gender',['male','female'])->nullable();
            $table->string('id_number')->unique()->nullable();
            $table->date('id_end')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('phone_verify_at')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('photo')->nullable();
            $table->string('city_name')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('occupation_id')->nullable();
            $table->foreignId('qualification_id')->nullable();
            $table->foreignId('specialty_id')->nullable();
            $table->string('password')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_number')->nullable();
            $table->string('contract')->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->string('notes')->nullable();
            $table->double('current_balance')->nullable();
            $table->double('suspended_balance')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('bank_account')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('free_consulting')->nullable()->default(0);
            $table->double('consulting_price')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

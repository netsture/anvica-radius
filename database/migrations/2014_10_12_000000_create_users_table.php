<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('identity_id')->nullable(); // User who created the record
            $table->string('username')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->date('dob')->nullable();
            $table->string('mobile')->nullable();
            $table->string('home')->nullable();
            $table->string('work')->nullable();
            $table->string('ext')->nullable();
            $table->string('fax')->nullable();
            $table->string('role')->nullable();
            $table->enum('preferred_contact_method', ['email', 'mobile', 'work_phone', 'home_phone', 'text_message'])->default('email');
            $table->string('profile_photo')->nullable();
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password_hint')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('created_by')->nullable(); // User who created the record
            $table->unsignedBigInteger('updated_by')->nullable(); // User who last updated the record
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

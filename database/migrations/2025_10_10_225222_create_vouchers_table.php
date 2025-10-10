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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('identity')->nullable()->index();
            $table->unsignedBigInteger('srvid')->nullable()->index();
            $table->string('series')->nullable();
            $table->string('voucher_code')->unique();
            $table->integer('valid_days')->default(0); // days
            $table->date('expiry_date')->nullable();
            $table->date('used_date')->nullable();
            $table->enum('status', ['active', 'used', 'expired', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};

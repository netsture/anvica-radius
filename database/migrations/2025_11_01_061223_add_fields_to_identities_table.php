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
        Schema::table('identities', function (Blueprint $table) {

            if (!Schema::hasColumn('identities', 'country')) {
                $table->string('country', 100)->nullable();
            }

            if (!Schema::hasColumn('identities', 'state')) {
                $table->string('state', 100)->nullable();
            }

            if (!Schema::hasColumn('identities', 'city')) {
                $table->string('city', 100)->nullable();
            }

            if (!Schema::hasColumn('identities', 'zone')) {
                $table->string('zone', 100)->nullable();
            }

            if (!Schema::hasColumn('identities', 'area')) {
                $table->string('area', 100)->nullable();
            }

            if (!Schema::hasColumn('identities', 'society')) {
                $table->enum('society', ['super premium', 'premium'])->default('premium')->nullable();
            }

            if (!Schema::hasColumn('identities', 'otp_sms')) {
                $table->boolean('otp_sms')->default(false);
            }

            if (!Schema::hasColumn('identities', 'otp_whatsapp')) {
                $table->boolean('otp_whatsapp')->default(false);
            }

            if (!Schema::hasColumn('identities', 'otp_email')) {
                $table->boolean('otp_email')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            $table->dropColumn([
                'country',
                'state',
                'city',
                'zone',
                'area',
                'society',
                'otp_sms',
                'otp_whatsapp',
                'otp_email'
            ]);
        });
    }
};

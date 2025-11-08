<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ad_impressions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('advertisement_id')->constrained('advertisements')->cascadeOnDelete();

            // If you have an identities table, store the FK or external ref here
            $table->unsignedBigInteger('identity_id')->nullable()->index();

            // Networking context
            $table->string('ip', 45)->nullable();          // IPv4/IPv6
            $table->string('user_agent', 255)->nullable();
            $table->string('nas_id', 100)->nullable()->index();     // router/AP identifier (optional)
            $table->string('session_id', 100)->nullable()->index(); // hotspot session (optional)

            // When shown
            $table->timestamp('seen_at')->useCurrent()->index();

            // Quick filter indexes
            $table->index(['advertisement_id','seen_at'], 'ad_impr_ad_time_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_impressions');
    }
};

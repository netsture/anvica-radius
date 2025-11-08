<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();

            // Asset + click-through
            $table->string('image_path');          // e.g. ads/banner1.jpg (public disk)
            $table->string('click_url')->nullable();

            // Lifecycle
            $table->enum('status', ['draft','active','paused','expired'])->default('draft')->index();
            $table->timestamp('start_at')->nullable()->index();
            $table->timestamp('end_at')->nullable()->index();

            // Time-of-day targeting
            $table->enum('time_slot', ['all','morning','afternoon','evening','night'])
                  ->default('all')
                  ->index();
            // Optional weekday filter: ["mon","tue","wed","thu","fri","sat","sun"]
            $table->json('weekdays')->nullable();

            // Delivery controls
            $table->unsignedInteger('priority')->default(5)->comment('1=highest')->index();
            $table->unsignedBigInteger('max_impressions')->nullable();
            $table->unsignedBigInteger('max_clicks')->nullable();

            // Geo targeting on the ad itself (broad) — you can also use a separate ad_targets table if you prefer multi-row targets
            $table->string('country')->nullable()->index();
            $table->string('state')->nullable()->index();
            $table->string('city')->nullable()->index();
            $table->string('zone')->nullable()->index();
            $table->string('area')->nullable()->index();
            $table->string('society')->nullable()->index();

            // Extra metadata
            $table->json('meta')->nullable();

            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Helpful composite indexes
            // $table->index(['status','start_at','end_at','time_slot'], 'ads_status_time_idx');
            // $table->index(['country','state','city','zone','area','society'], 'ads_geo_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};

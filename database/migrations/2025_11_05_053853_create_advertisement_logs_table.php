<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advertisement_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertisement_id')->nullable()->index();
            $table->unsignedBigInteger('identity_id')->nullable()->index();
            // Networking context
            $table->enum('event',['view','click']);
            $table->string('mac', 50)->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('nas_id', 100)->nullable()->index();
            $table->string('session_id', 100)->nullable()->index();

            // When clicked
            $table->timestamp('clicked_at')->useCurrent()->index();

            // Quick filter indexes
            $table->index(['advertisement_id','clicked_at'], 'ad_click_ad_time_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_logs');
    }
};

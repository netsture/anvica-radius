<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');          // e.g. ads/banner1.jpg (public disk)
            $table->string('click_url')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->enum('time_slot', ['all','morning','afternoon','evening','night'])->default('all');
            $table->longText('weekdays')->nullable();
            $table->unsignedInteger('priority')->default(5)->comment('1=highest');
            $table->unsignedBigInteger('max_impressions')->nullable();
            $table->unsignedBigInteger('max_clicks')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zone')->nullable();
            $table->string('area')->nullable();
            $table->string('society')->nullable();
            $table->longText('meta')->nullable();
            $table->enum('status', ['Active','Inactive'])->default('Active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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

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
        Schema::create('router_status', function (Blueprint $table) {
            $table->id();
            $table->string('router', 50);
            $table->enum('status', ['UP', 'DOWN']);
            $table->string('mac', 50);
            $table->string('model', 100);            
            $table->string('serial', 100);            
            $table->dateTime('event_datetime')->nullable();
            $table->longText('api_request')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('router_status');
    }
};

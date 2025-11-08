<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('identity_id')->nullable();
        $table->string('room_no')->unique();
        $table->string('floor_no')->nullable();
        $table->string('room_type')->nullable();
        $table->string('status')->default('available');
        $table->string('series')->nullable();
        $table->timestamps();

        $table->foreign('identity_id')->references('id')->on('identities')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

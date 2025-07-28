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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('device_name')->nullable(); // e.g. iPhone 13, Chrome browser
            $table->string('device_os')->nullable();   // e.g. iOS 17, Android 12, Windows
            $table->enum('device_type', ['android', 'ios', 'web'])->nullable();
            $table->string('ip_address')->nullable();
            $table->string('fcm_token')->unique();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

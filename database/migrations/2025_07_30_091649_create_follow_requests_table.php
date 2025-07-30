<?php

use App\Enum\FollowRequestStatusEnum;
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

        Schema::create('follow_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');   // Who sent the request
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Who received the request
            $table->enum('status', FollowRequestStatusEnum::values())->default(FollowRequestStatusEnum::PENDING->value); // Status of the request
            $table->timestamps();

            $table->unique(['sender_id', 'receiver_id']); // Prevent duplicate requests
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_requests');
    }
};

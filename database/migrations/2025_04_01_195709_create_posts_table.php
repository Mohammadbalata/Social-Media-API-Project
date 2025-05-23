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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('title')->nullable(); 
            $table->text('content')->nullable(); 
            $table->enum('status', ['public', 'archived', 'private'])->default('public'); 
            $table->boolean('is_pinned')->default(false); 
            $table->boolean('is_deleted')->default(false); 
            $table->integer('shares')->default(0); 
            $table->integer('comments_count')->default(0);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

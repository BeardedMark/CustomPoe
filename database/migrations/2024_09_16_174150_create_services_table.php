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
        Schema::create('services', function (Blueprint $table) {
            // Default
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            
            // Standart
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->longText('data')->nullable();
            
            // Custom
            $table->string('type')->nullable();
            $table->unsignedInteger('count')->default(1);
            $table->unsignedInteger('price')->default(1);
            $table->string('currency')->default('Chaos');
            $table->boolean('is_buying')->default(false);
            $table->unsignedBigInteger('whisps')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            
            // Content
            $table->longText('content')->nullable();
            $table->string('comment')->nullable();
            $table->text('tags')->nullable();
            $table->string('icon')->nullable();
            $table->string('wallpaper')->nullable();
            $table->text('gallery')->nullable();
            $table->string('webhook')->nullable();
            $table->string('link')->nullable();
            
            // Relative
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

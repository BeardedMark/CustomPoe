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
        Schema::create('builds', function (Blueprint $table) {
            // Default
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            
            // Relative
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            
            // Standart
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->longText('data')->nullable();
            
            // Content
            $table->longText('content')->nullable();
            $table->string('comment')->nullable();
            $table->text('tags')->nullable();
            $table->string('icon')->nullable();
            $table->string('wallpaper')->nullable();
            $table->text('gallery')->nullable();
            $table->string('webhook')->nullable();
            $table->string('link')->nullable();
            $table->string('video')->nullable();

            // Custom
            $table->string('budget')->nullable();
            $table->string('currency')->default('Chaos');
            $table->longText('character')->nullable();
            $table->string('skill')->nullable();
            
            $table->string('poe_id')->nullable();
            $table->string('class');
            $table->string('realm');
            $table->string('league')->nullable();
            $table->string('version')->nullable();

            $table->longText('equipment')->nullable();
            $table->longText('jewels')->nullable();
            $table->longText('passives')->nullable();
            $table->longText('rucksack')->nullable();

            $table->text('pros')->nullable();
            $table->text('important')->nullable();
            $table->text('cons')->nullable();

            $table->text('hard')->nullable();
            $table->text('life')->nullable();
            $table->text('speed')->nullable();
            $table->text('damage')->nullable();
            
            $table->string('pob')->nullable();
            $table->string('three')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('buildings')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builds');
    }
};

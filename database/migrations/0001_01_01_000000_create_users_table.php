<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Default
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // Standart
            $table->string('name')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Custom
            $table->boolean('is_admin')->default(false);
            $table->string('language')->nullable();
            $table->unsignedBigInteger('points')->default(0);
            $table->timestamp('last_seen')->nullable();
            $table->string('last_page')->nullable();
            
            $table->longText('character')->nullable();
            $table->longText('characters')->nullable();
            $table->longText('filters')->nullable();
            $table->longText('stashes')->nullable();
            $table->longText('leagues')->nullable();

            // Content
            $table->longText('content')->nullable();
            $table->string('avatar')->nullable();
            $table->string('wallpaper')->nullable();
            $table->text('description')->nullable();
            $table->string('comment')->nullable();
            $table->text('gallery')->nullable();
            $table->text('tags')->nullable();
            $table->string('link')->nullable();
            
            $table->string('discord')->nullable();
            $table->string('twitch')->nullable();
        });

        $this->create('admin', 'Dev201095', true);
        $this->create('BeardedMark', 'Dev201095', true);
        $this->create('GrindingGearGames', 'Dev201095');

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    private function create(string $name, string $password = null, $is_admin = false): void
    {
        DB::table('users')->insert([
            'name' => $name,
            'password' => Hash::make($password ?: $name),
            'is_admin' => $is_admin,
            'comment' => 'Создан автоматически',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

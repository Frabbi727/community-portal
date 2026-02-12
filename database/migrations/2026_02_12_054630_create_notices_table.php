<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['notice', 'celebration', 'memorial', 'event'])->default('notice');
            $table->text('summary')->nullable();
            $table->longText('body');
            $table->boolean('is_public')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_public', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};

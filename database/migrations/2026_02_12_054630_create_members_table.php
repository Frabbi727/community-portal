<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('slug')->unique();
            $table->string('role')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('occupation')->nullable();
            $table->text('bio')->nullable();
            $table->date('joined_on')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_public', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

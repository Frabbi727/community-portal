<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('address')->nullable();
            $table->string('occupation')->nullable();
            $table->text('interests')->nullable();
            $table->text('motivation');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('review_notes')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();

            $table->index(['status', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};

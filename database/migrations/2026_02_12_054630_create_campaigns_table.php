<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description');
            $table->enum('status', ['planned', 'active', 'completed'])->default('planned');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('target_amount', 12, 2)->nullable();
            $table->decimal('current_amount', 12, 2)->default(0);
            $table->boolean('is_public')->default(true);
            $table->string('contact_email')->nullable();
            $table->timestamps();

            $table->index(['is_public', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan');           // basic | standard | premium
            $table->string('plan_name');      // Basic | Standard | Premium
            $table->unsignedInteger('price'); // RSD
            $table->string('status')->default('active'); // active | expired
            $table->string('cardholder_name');
            $table->string('card_last_four', 4);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
    }
};

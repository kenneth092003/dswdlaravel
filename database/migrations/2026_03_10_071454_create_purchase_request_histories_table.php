<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_request_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status_key');
            $table->string('status_label');
            $table->text('remarks')->nullable();

            $table->foreignId('acted_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('acted_at')->nullable();
            $table->unsignedTinyInteger('step_no')->default(1);
            $table->boolean('is_current')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_histories');
    }
};
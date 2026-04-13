<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->string('issue_type', 100);
            $table->string('priority', 50);
            $table->string('subject', 150);
            $table->text('description');
            $table->string('affected_module', 150)->nullable();
            $table->string('status', 50)->default('Open'); // Open, In Progress, Resolved
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_issues');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->foreignId('system_issue_id')
                ->nullable()
                ->after('purchase_request_id')
                ->constrained('system_issues')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('system_issue_id');
        });
    }
};

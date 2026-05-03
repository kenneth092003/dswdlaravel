<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->string('activity_title')->nullable()->after('pr_number');
            $table->string('fund_source')->nullable()->after('office_department');
            $table->date('target_date')->nullable()->after('request_date');
            $table->decimal('estimated_amount', 12, 2)->nullable()->after('target_date');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropColumn(['activity_title', 'fund_source', 'target_date', 'estimated_amount']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_requests', 'activity_title')) {
                $table->string('activity_title')->nullable()->after('pr_number');
            }
            if (!Schema::hasColumn('purchase_requests', 'fund_source')) {
                $table->string('fund_source')->nullable()->after('office_department');
            }
            if (!Schema::hasColumn('purchase_requests', 'target_date')) {
                $table->date('target_date')->nullable()->after('request_date');
            }
            if (!Schema::hasColumn('purchase_requests', 'estimated_amount')) {
                $table->decimal('estimated_amount', 12, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('purchase_requests', 'activity_date')) {
                $table->date('activity_date')->nullable()->after('target_date');
            }
            if (!Schema::hasColumn('purchase_requests', 'expected_venue')) {
                $table->string('expected_venue')->nullable()->after('activity_date');
            }
            if (!Schema::hasColumn('purchase_requests', 'doc_number')) {
                $table->string('doc_number')->nullable()->after('pr_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('purchase_requests', 'activity_title')  ? 'activity_title'  : null,
                Schema::hasColumn('purchase_requests', 'fund_source')     ? 'fund_source'     : null,
                Schema::hasColumn('purchase_requests', 'target_date')     ? 'target_date'     : null,
                Schema::hasColumn('purchase_requests', 'estimated_amount')? 'estimated_amount': null,
                Schema::hasColumn('purchase_requests', 'activity_date')   ? 'activity_date'   : null,
                Schema::hasColumn('purchase_requests', 'expected_venue')  ? 'expected_venue'  : null,
                Schema::hasColumn('purchase_requests', 'doc_number')      ? 'doc_number'      : null,
            ]));
        });
    }
};
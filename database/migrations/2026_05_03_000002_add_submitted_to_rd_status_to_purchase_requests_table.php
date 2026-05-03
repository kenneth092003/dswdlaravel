<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE purchase_requests
            MODIFY COLUMN status ENUM(
                'draft',
                'pending',
                'submitted_to_rd',
                'submitted_to_procurement',
                'approved',
                'rejected',
                'returned',
                'processing',
                'bac_processing',
                'signed_pr',
                'validated_payment'
            ) NOT NULL DEFAULT 'draft'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE purchase_requests
            MODIFY COLUMN status ENUM(
                'draft',
                'pending',
                'submitted_to_procurement',
                'approved',
                'rejected',
                'returned',
                'processing',
                'bac_processing',
                'signed_pr',
                'validated_payment'
            ) NOT NULL DEFAULT 'draft'
        ");
    }
};

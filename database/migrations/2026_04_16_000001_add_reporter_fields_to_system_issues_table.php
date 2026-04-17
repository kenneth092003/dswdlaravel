<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_issues', function (Blueprint $table) {
            $table->string('reporter_name', 150)->nullable()->after('reported_by');
            $table->string('reporter_email', 150)->nullable()->after('reporter_name');
            $table->string('reporter_role', 100)->nullable()->after('reporter_email');
        });

        Schema::table('system_issues', function (Blueprint $table) {
            $table->foreignId('reported_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('system_issues', function (Blueprint $table) {
            $table->dropColumn(['reporter_name', 'reporter_email', 'reporter_role']);
        });

        Schema::table('system_issues', function (Blueprint $table) {
            $table->foreignId('reported_by')->nullable(false)->change();
        });
    }
};

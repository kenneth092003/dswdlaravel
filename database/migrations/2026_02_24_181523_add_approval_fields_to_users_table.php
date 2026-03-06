<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends \Illuminate\Database\Migrations\Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('remember_token');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
        }); // boolean + default() is supported in Laravel migrations [web:426]

        // IMPORTANT: approve existing users so you don't lock yourself out
        DB::table('users')->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'approved_at']);
        });
    }
};

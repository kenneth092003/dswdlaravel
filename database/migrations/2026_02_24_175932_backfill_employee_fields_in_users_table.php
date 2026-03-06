<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    $users = DB::table('users')->select('id','name','employee_id','firstname','lastname')->get();

    foreach ($users as $u) {
        // split existing name into firstname/lastname
        $name = trim((string) $u->name);
        $parts = preg_split('/\s+/', $name);

        $firstname = $u->firstname ?? ($parts[0] ?? null);
        $lastname  = $u->lastname ?? (count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : null);

        $employeeId = $u->employee_id ?: ('EMP'.str_pad((string)$u->id, 5, '0', STR_PAD_LEFT));

        DB::table('users')->where('id', $u->id)->update([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'employee_id' => $employeeId,
        ]);
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

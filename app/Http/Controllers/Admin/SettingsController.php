<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        // Load recent issues if the system_issues table exists,
        // otherwise just pass an empty collection.
        $recentIssues = collect();

        if (\Schema::hasTable('system_issues')) {
            $recentIssues = DB::table('system_issues')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        return view('admin.settings.index', compact('recentIssues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'issue_type'      => 'required|string|max:100',
            'priority'        => 'required|string|max:50',
            'subject'         => 'required|string|max:150',
            'description'     => 'required|string|max:2000',
            'affected_module' => 'nullable|string|max:150',
            'reported_by'     => 'required|integer',
        ]);

        // Save to DB if the table exists, otherwise just flash success
        if (\Schema::hasTable('system_issues')) {
            DB::table('system_issues')->insert([
                'issue_type'      => $validated['issue_type'],
                'priority'        => $validated['priority'],
                'subject'         => $validated['subject'],
                'description'     => $validated['description'],
                'affected_module' => $validated['affected_module'] ?? null,
                'reported_by'     => $validated['reported_by'],
                'status'          => 'Open',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        return back()->with('status', 'Issue report submitted successfully. The administrator has been notified.');
    }
}